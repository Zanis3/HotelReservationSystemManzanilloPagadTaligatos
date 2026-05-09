<?php

class ReservationController
{
    private function checkSession()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['name'])) {
            header('Location: index.php?url=reserve');
            exit();
        }
    }

    private function renderView(string $view, array $data = []): void
    {
        extract($data);
        require_once '../apps/Views/layouts/header.php';
        require_once "../apps/Views/home/{$view}.php";
        require_once '../apps/Views/layouts/footer.php';
    }

    public function billing(): void
    {
        $this->checkSession();

        $customerName = $_SESSION['name'];
        $customerContact = $_SESSION['contact'];
        $reservationDate = date('Y-m-d');
        $reservationTime = date('h:i:s A');
        $fromDateReservation = $_SESSION['fromDate'];
        $toDateReservation = $_SESSION['toDate'];
        $roomType = $_SESSION['roomType'];
        $roomCapacity = $_SESSION['roomCapacity'];
        $paymentType = $_SESSION['paymentType'];

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

        // PDO Logic — on Confirm
        if (isset($_POST['btnConfirm'])) {
            try {
                $database = new Database();
                $pdo = $database->getConnection();

                $pdo->beginTransaction();

                $stmt = $pdo->prepare("SELECT guestID FROM tbl_guests WHERE guestName = ? LIMIT 1");
                $stmt->execute([$customerName]);
                $guestData = $stmt->fetch();

                if ($guestData) {
                    $guestID = $guestData['guestID'];
                } else {
                    $stmt = $pdo->prepare("INSERT INTO tbl_guests (guestName, guestContact) VALUES (?, ?)");
                    $stmt->execute([$customerName, $customerContact]);
                    $guestID = $pdo->lastInsertId();
                }

                $stmt = $pdo->prepare("INSERT INTO tbl_reservation (guestID, reservationDate, reservationStartDate, reservationEndDate, reservationRoomType, reservationRoomCapacity, reservationPaymentType, reservationNoOfDays) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->execute([
                    $guestID,
                    $reservationDate,
                    $fromDateReservation,
                    $toDateReservation,
                    $roomType,
                    $roomCapacity,
                    $paymentType,
                    $noDays
                ]);

                $reservationID = $pdo->lastInsertId();

                $stmt = $pdo->prepare("INSERT INTO tbl_payments (reservationID, guestID, paymentSubTotal, paymentDiscount, paymentGrandTotal) VALUES (?, ?, ?, ?, ?)");

                $stmt->execute([
                    $reservationID,
                    $guestID,
                    $subTotal,
                    $totalDiscount,
                    $grandTotal
                ]);

                $pdo->commit();

                $_SESSION['name'] = $customerName;
                header('Location: index.php?url=confirmation');
                exit();
            } catch (PDOException $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                die("Database Error: " . $e->getMessage());
            }
        }

        $this->renderView('billing', [
            'customerName' => $customerName,
            'customerContact' => $customerContact,
            'reservationDate' => $reservationDate,
            'reservationTime' => $reservationTime,
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

    public function confirmation(): void
    {
        $this->checkSession();

        $name = $_SESSION['name'];

        $this->renderView('confirmation', ['name' => $name]);

        session_destroy();
    }
}
