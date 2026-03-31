<head>
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reservation.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Reservation Billing</title>
</head>

<body>
    <?php
    session_start();
    require('includes/dbconn.php');
    include_once('includes/header.php');

    if (!isset($_SESSION['name'])) {
        header('Location: ReservationManzanilloPagadTaligatos.php');
        exit();
    }

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

    #PDO Logic
    if (isset($_POST['btnConfirm'])) {
        try {
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

            $stmt = $pdo->prepare("INSERT INTO tbl_reservation 
                    (guestID, reservationDate, reservationStartDate, reservationEndDate, reservationRoomType, reservationRoomCapacity, reservationPaymentType, reservationNoOfDays) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
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

            $stmt = $pdo->prepare("INSERT INTO tbl_payments (guestID, paymentSubTotal, paymentDiscount, paymentGrandTotal) VALUES (?, ?, ?, ?)");
            $stmt->execute([$guestID, $subTotal, $totalDiscount, $grandTotal]);

            $pdo->commit();

            $_SESSION['name'] = $customerName;
            header('Location: ReservationConfirmation.php');
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
            <h1 class="reservation-heading">Billing Confirmation</h1>
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

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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