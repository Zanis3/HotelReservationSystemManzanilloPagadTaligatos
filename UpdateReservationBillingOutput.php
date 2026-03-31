<head>
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reservation.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Update Reservation Billing</title>
</head>

<body>
    <?php
    session_start();
    require('includes/dbconn.php');
    include_once('includes/header.php');

    if (!isset($_SESSION['name'])) {
        header('Location: UpdateReservation.php');
        exit();
    }

    $reservationID = $_SESSION['reservationID'] ?? null;
    $customerID = $_SESSION['guestID'] ?? null;

    $customerName = $_SESSION['name'];
    $customerContact = $_SESSION['contact'];
    $reservationDate = date('Y-m-d');
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

    # PDO Logic
    if (isset($_POST['btnConfirm'])) {
        if (!$reservationID || !$customerID) {
            die("Error: Session IDs lost. Reservation ID: $reservationID, Guest ID: $customerID");
        }

        try {
            $pdo->beginTransaction();

            // 1. Update Guest
            $stmt1 = $pdo->prepare("UPDATE tbl_guests SET guestName = ?, guestContact = ? WHERE guestID = ?");
            $stmt1->execute([$customerName, $customerContact, $customerID]);

            // 2. Update Reservation
            $stmt2 = $pdo->prepare("UPDATE tbl_reservation SET 
                reservationStartDate = ?, 
                reservationEndDate = ?, 
                reservationRoomType = ?, 
                reservationRoomCapacity = ?, 
                reservationPaymentType = ?, 
                reservationNoOfDays = ? 
                WHERE reservationID = ?");

            $stmt2->execute([
                $fromDateReservation,
                $toDateReservation,
                $roomType,
                $roomCapacity,
                $paymentType,
                $noDays,
                $reservationID
            ]);

            // 3. Update Payments (Crucial: check if guestID exists in tbl_payments)
            $stmt3 = $pdo->prepare("UPDATE tbl_payments SET 
                paymentSubTotal = ?, 
                paymentDiscount = ?, 
                paymentGrandTotal = ? 
                WHERE guestID = ?");
            $stmt3->execute([$subTotal, $totalDiscount, $grandTotal, $customerID]);

            $pdo->commit();

            // Clear temporary session data but keep the login session
            unset($_SESSION['reservationID'], $_SESSION['guestID'], $_SESSION['name']);

            header('Location: admin.php?status=updated');
            exit();
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            die("Database Error: " . $e->getMessage());
        }
    }
    ?>

    <div class="reservation-hero">
        <div class="container d-flex">
            <h1 class="reservation-heading">Update Billing Confirmation</h1>
        </div>
    </div>

    <div class="reservation-form">
        <div class="container d-flex flex-column justify-center gap-20">

            <div class="row d-flex gap-20">
                <label>Name:</label>
                <p><?php echo $customerName ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label>Contact:</label>
                <p><?php echo $customerContact ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label>Reservation Date:</label>
                <p><?php echo $reservationDate ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label style="font-family:'Playfair Display';font-size:36px;">Reservation Details:</label>
            </div>

            <div class="row d-flex gap-20">
                <label>From:</label>
                <p><?php echo $fromDateReservation ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label>To:</label>
                <p><?php echo $toDateReservation ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label>Room:</label>
                <p><?php echo "$roomCapacity $roomType" ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label>Payment:</label>
                <p><?php echo $paymentType ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label style="font-family:'Playfair Display';font-size:36px;">Billing Statement:</label>
            </div>

            <div class="row d-flex gap-20">
                <label>Number of Days:</label>
                <p><?php echo $noDays ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label>Sub-Total:</label>
                <p><?php echo number_format($subTotal, 2) ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label>Discount:</label>
                <p><?php echo number_format($totalDiscount, 2) ?? ''; ?></p>
            </div>

            <div class="row d-flex gap-20">
                <label>Grand Total:</label>
                <p><?php echo number_format($grandTotal, 2) ?? ''; ?></p>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="button-container">
                    <input type="submit" name="btnConfirm" value="Confirm" class="btn-reservation-submit-btn">
                    <button type="button" class="btn-reservation-reset-btn" onclick="history.back()">Return</button>
                </div>
            </form>
        </div>
    </div>

    <?php include_once('includes/footer.php'); ?>

    <script>
        lucide.createIcons();
    </script>
</body>