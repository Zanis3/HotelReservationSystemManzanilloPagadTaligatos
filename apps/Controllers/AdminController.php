<?php

class AdminController
{
    private function checkSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function renderView(string $view, array $data = []): void
    {
        extract($data);
        require_once "../apps/Views/admin/{$view}.php";
    }

    //Display the admin login form.
    public function login(): void
    {
        $this->checkSession();

        // If already logged in, redirect to dashboard
        if (isset($_SESSION['admin_user'])) {
            header('Location: index.php?url=admin/dashboard');
            exit();
        }

        $loginError = '';

        if (isset($_POST['btnSubmit'])) {
            $username = trim($_POST['txtUsername']);
            $password = $_POST['txtPassword'];

            try {
                $database = new Database();
                $pdo = $database->getConnection();

                $stmt = $pdo->prepare("SELECT * FROM tbl_admin WHERE adminName = ? LIMIT 1");
                $stmt->execute([$username]);
                $admin = $stmt->fetch();

                if ($admin && password_verify($password, $admin['adminPass'])) {
                    $_SESSION['admin_id'] = $admin['adminID'];
                    $_SESSION['admin_user'] = $admin['adminName'];
                    header('Location: /HotelReservationSystemManzanilloPagadTaligatosMVC/index.php?url=admin/dashboard');
                    exit();
                } else {
                    $loginError = "Invalid Username or Password.";
                }
            } catch (PDOException $e) {
                $loginError = "Database error: " . $e->getMessage();
            }
        }

        $this->renderView('login', ['loginError' => $loginError]);
    }

    //Display the admin dashboard
    public function dashboard(): void
    {
        $this->checkSession();

        if (!isset($_SESSION['admin_user'])) {
            header('Location: /HotelReservationSystemManzanilloPagadTaligatosMVC/index.php?url=admin/login');
            exit();
        }

        $adminName = $_SESSION['admin_user'];

        // Get reservation count for the dashboard stats
        $reservationModel = new Reservation();
        $totalReservations = $reservationModel->getTotalCount();
        $recentReservations = $reservationModel->getAllReservations();

        $this->renderView('dashboard', [
            'adminName' => $adminName,
            'totalReservations' => $totalReservations,
            'recentReservations' => $recentReservations
        ]);
    }

    //Log out the admin and redirect to login.
    public function logout(): void
    {
        $this->checkSession();
        $_SESSION = [];
        session_destroy();
        header('Location: /HotelReservationSystemManzanilloPagadTaligatosMVC/index.php?url=admin/login');
        exit();
    }

    //Display all reservations in a table view.
    public function reservations(): void
    {
        $this->checkSession();

        if (!isset($_SESSION['admin_user'])) {
            header('Location: /HotelReservationSystemManzanilloPagadTaligatosMVC/index.php?url=admin/login');
            exit();
        }

        $reservationModel = new Reservation();
        $reservations = $reservationModel->getAllReservations();

        $status = $_GET['status'] ?? null;

        $this->renderView('reservations', [
            'reservations' => $reservations,
            'status' => $status
        ]);
    }

    //Display the edit reservation form.
    public function editReservation(): void
    {
        $this->checkSession();

        if (!isset($_SESSION['admin_user'])) {
            header('Location: /HotelReservationSystemManzanilloPagadTaligatosMVC/index.php?url=admin/login');
            exit();
        }

        $reservationID = $_GET['id'] ?? null;

        if (!$reservationID) {
            header('Location: index.php?url=admin/reservations');
            exit();
        }

        $reservationModel = new Reservation();
        $data = $reservationModel->getReservationById((int)$reservationID);

        if (!$data) {
            die("Reservation not found.");
        }

        $dateError = '';

        if (isset($_POST['btnUpdate'])) {
            $check = false;

            $fromDate = $_POST['dateFrom'];
            $toDate = $_POST['dateTo'];

            if ($fromDate > $toDate) {
                $dateError = "Check-out must be on or after the check-in date.";
            } else {
                $check = true;
            }

            if ($check) {
                $_SESSION['edit_reservationID'] = $reservationID;
                $_SESSION['edit_guestID'] = $data['guestID'];
                $_SESSION['edit_name'] = ucwords($_POST['txtName']);
                $_SESSION['edit_contact'] = $_POST['txtContactNum'];
                $_SESSION['edit_fromDate'] = $fromDate;
                $_SESSION['edit_toDate'] = $toDate;
                $_SESSION['edit_roomType'] = $_POST['rdoRoomType'];
                $_SESSION['edit_roomCapacity'] = $_POST['rdoRoomCapacity'];
                $_SESSION['edit_paymentType'] = $_POST['rdoPaymentType'];
                header('Location: index.php?url=admin/reservations/update-billing');
                exit();
            }
        }

        $this->renderView('edit-reservation', [
            'data' => $data,
            'reservationID' => $reservationID,
            'dateError' => $dateError
        ]);
    }

    //Display the billing confirmation for updating a reservation.
    public function updateReservationBilling(): void
    {
        $this->checkSession();

        if (!isset($_SESSION['admin_user'])) {
            header('Location: /HotelReservationSystemManzanilloPagadTaligatosMVC/index.php?url=admin/login');
            exit();
        }

        if (!isset($_SESSION['edit_name'])) {
            header('Location: index.php?url=admin/reservations');
            exit();
        }

        $reservationID = $_SESSION['edit_reservationID'] ?? null;
        $guestID = $_SESSION['edit_guestID'] ?? null;

        $customerName = $_SESSION['edit_name'];
        $customerContact = $_SESSION['edit_contact'];
        $reservationDate = date('Y-m-d');
        $fromDateReservation = $_SESSION['edit_fromDate'];
        $toDateReservation = $_SESSION['edit_toDate'];
        $roomType = $_SESSION['edit_roomType'];
        $roomCapacity = $_SESSION['edit_roomCapacity'];
        $paymentType = $_SESSION['edit_paymentType'];

        // Calculation Logic
        $rate = 0;
        $discount = 0;
        $dayDifference = strtotime($toDateReservation) - strtotime($fromDateReservation);
        $noDays = round($dayDifference / 86400);
        if ($noDays <= 0) $noDays = 1;

        // Determine Base Rate
        if ($roomCapacity == "Single") {
            $rate = ($roomType == "Regular") ? 100.00 : (($roomType == "Deluxe") ? 300.00 : 500.00);
        } elseif ($roomCapacity == "Double") {
            $rate = ($roomType == "Regular") ? 200.00 : (($roomType == "Deluxe") ? 500.00 : 800.00);
        } else {
            $rate = ($roomType == "Regular") ? 500.00 : (($roomType == "Deluxe") ? 750.00 : 1000.00);
        }

        // Adjust for Payment/Discounts
        if ($paymentType == "Credit Card") {
            $rate *= 1.10;
        } elseif ($paymentType == "Check") {
            $rate *= 1.05;
        } else {
            if ($noDays >= 3 && $noDays <= 5) {
                $discount = $rate * 0.10;
            } elseif ($noDays >= 6) {
                $discount = $rate * 0.15;
            }
        }

        $subTotal = $rate * $noDays;
        $totalDiscount = $discount * $noDays;
        $grandTotal = $subTotal - $totalDiscount;

        if (isset($_POST['btnConfirm'])) {
            if (!$reservationID || !$guestID) {
                die("Error: Session IDs lost. Reservation ID: $reservationID, Guest ID: $guestID");
            }

            try {
                $reservationModel = new Reservation();
                $reservationModel->updateReservation(
                    (int)$reservationID,
                    (int)$guestID,
                    $customerName,
                    $customerContact,
                    $fromDateReservation,
                    $toDateReservation,
                    $roomType,
                    $roomCapacity,
                    $paymentType,
                    $noDays,
                    $subTotal,
                    $totalDiscount,
                    $grandTotal
                );

                // Clear temporary session data but keep the login session
                unset(
                    $_SESSION['edit_reservationID'],
                    $_SESSION['edit_guestID'],
                    $_SESSION['edit_name'],
                    $_SESSION['edit_contact'],
                    $_SESSION['edit_fromDate'],
                    $_SESSION['edit_toDate'],
                    $_SESSION['edit_roomType'],
                    $_SESSION['edit_roomCapacity'],
                    $_SESSION['edit_paymentType']
                );

                header('Location: index.php?url=admin/reservations&status=updated');
                exit();
            } catch (\PDOException $e) {
                die("Database Error: " . $e->getMessage());
            }
        }

        $this->renderView('update-billing', [
            'reservationID' => $reservationID,
            'guestID' => $guestID,
            'customerName' => $customerName,
            'customerContact' => $customerContact,
            'reservationDate' => $reservationDate,
            'fromDateReservation' => $fromDateReservation,
            'toDateReservation' => $toDateReservation,
            'roomType' => $roomType,
            'roomCapacity' => $roomCapacity,
            'paymentType' => $paymentType,
            'noDays' => $noDays,
            'subTotal' => $subTotal,
            'totalDiscount' => $totalDiscount,
            'grandTotal' => $grandTotal,
        ]);
    }

    //Delete a reservation by ID.
    public function deleteReservation(): void
    {
        $this->checkSession();

        if (!isset($_SESSION['admin_user'])) {
            header('Location: /HotelReservationSystemManzanilloPagadTaligatosMVC/index.php?url=admin/login');
            exit();
        }

        $reservationID = $_GET['id'] ?? null;

        if ($reservationID) {
            try {
                $reservationModel = new Reservation();
                $reservationModel->deleteReservation((int)$reservationID);
                header('Location: index.php?url=admin/reservations&status=deleted');
                exit();
            } catch (\PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }

        header('Location: index.php?url=admin/reservations');
        exit();
    }

    //Display and process the admin settings page (change username/password).
    public function settings(): void
    {
        $this->checkSession();

        if (!isset($_SESSION['admin_user'])) {
            header('Location: /HotelReservationSystemManzanilloPagadTaligatosMVC/index.php?url=admin/login');
            exit();
        }

        $adminName = $_SESSION['admin_user'];
        $message = '';
        $messageType = '';

        if (isset($_POST['btnSave'])) {
            $newUsername = trim($_POST['txtUsername']);
            $currentPassword = $_POST['txtCurrentPassword'];
            $newPassword = $_POST['txtNewPassword'];
            $confirmPassword = $_POST['txtConfirmPassword'];

            try {
                $database = new Database();
                $pdo = $database->getConnection();

                // Verify current password
                $stmt = $pdo->prepare("SELECT * FROM tbl_admin WHERE adminID = ? LIMIT 1");
                $stmt->execute([$_SESSION['admin_id']]);
                $admin = $stmt->fetch();

                if (!$admin || !password_verify($currentPassword, $admin['adminPass'])) {
                    $message = "Current password is incorrect.";
                    $messageType = 'error';
                } elseif (empty($newUsername)) {
                    $message = "Username cannot be empty.";
                    $messageType = 'error';
                } elseif (!empty($newPassword) && $newPassword !== $confirmPassword) {
                    $message = "New password and confirmation do not match.";
                    $messageType = 'error';
                } else {
                    // Build update query
                    if (!empty($newPassword)) {
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("UPDATE tbl_admin SET adminName = ?, adminPass = ? WHERE adminID = ?");
                        $stmt->execute([$newUsername, $hashedPassword, $_SESSION['admin_id']]);
                    } else {
                        $stmt = $pdo->prepare("UPDATE tbl_admin SET adminName = ? WHERE adminID = ?");
                        $stmt->execute([$newUsername, $_SESSION['admin_id']]);
                    }

                    // Update session with new username
                    $_SESSION['admin_user'] = $newUsername;
                    $adminName = $newUsername;

                    $message = "Settings updated successfully.";
                    $messageType = 'success';
                }
            } catch (PDOException $e) {
                $message = "Database error: " . $e->getMessage();
                $messageType = 'error';
            }
        }

        $this->renderView('settings', [
            'adminName' => $adminName,
            'message' => $message,
            'messageType' => $messageType
        ]);
    }
}
