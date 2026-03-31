<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reservation.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Update Reservation</title>
</head>

<body>
    <?php
    session_start();
    require 'includes/dbconn.php';

    if (!isset($_SESSION['admin_user'])) {
        header('Location: login.php');
        exit();
    }

    $reservationID = $_GET['id'] ?? null;

    try {
        $stmt = $pdo->prepare("SELECT r.*, g.guestName, g.guestContact FROM tbl_reservation r JOIN tbl_guests g ON r.guestID = g.guestID WHERE r.reservationID = ?");
        $stmt->execute([$reservationID]);
        $data = $stmt->fetch();

        if (!$data) {
            die("Reservation not found.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
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
            $_SESSION['reservationID'] = $reservationID;
            $_SESSION['guestID'] = $data['guestID'];
            $_SESSION['name'] = ucwords($_POST['txtName']);
            $_SESSION['contact'] = $_POST['txtContactNum'];
            $_SESSION['fromDate'] = $fromDate;
            $_SESSION['toDate'] = $toDate;
            $_SESSION['roomType'] = $_POST['rdoRoomType'];
            $_SESSION['roomCapacity'] = $_POST['rdoRoomCapacity'];
            $_SESSION['paymentType'] = $_POST['rdoPaymentType'];
            header('Location: UpdateReservationBillingOutput.php');
            exit();
        }
    }
    ?>

    <div class="reservation-hero">
        <div class="container d-flex">
            <h1 class="reservation-heading">Update Reservation</h1>
        </div>
    </div>

    <!--Form Content-->
    <div class="reservation-form">
        <div class="container d-flex flex-column justify-center align-center gap-40">

            <!--Date and time row-->
            <div class="date-row d-flex align-center gap-10">
                <i data-lucide="clock"></i>
                <span id="date-time">08:00:00 AM</span>
            </div>

            <!--Reservation Form-->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $reservationID); ?>" method="POST" class="reservation-form-container d-flex flex-column gap-40">

                <!--Name (Last Name, First Name, Middle Initial)-->
                <div class="name-row d-flex gap-20">
                    <div class="name d-flex flex-column">
                        <label for="txtName">Name:</label>
                        <input type="text" id="txtName" name="txtName" placeholder="Enter Name..." value="<?= htmlspecialchars($data['guestName']); ?>" required>
                    </div>
                </div>

                <!--Contact Number-->
                <div class="contact-number-row d-flex flex-column">
                    <label for="txtContactNum">Contact Number:</label>
                    <input type="number" id="txtContactNum" name="txtContactNum" placeholder="Contact Number..." value="<?= htmlspecialchars($data['guestContact']); ?>" required>
                </div>

                <!--From and To Dates-->
                <div class="dates-row d-flex flex-column gap-20">
                    <div class="room-type-title">
                        <label>Duration</label>
                        <p class="warning"><?php echo $dateError ?? ''; ?></p>
                    </div>

                    <div class="dates-row-container d-flex gap-40">
                        <div class="dates-row d-flex align-center gap-10">
                            <label for="dateFrom">From:</label>
                            <input type="date" name="dateFrom" id="dateFrom" min="<?= $data['reservationStartDate']; ?>" value="<?= $data['reservationStartDate']; ?>" required>
                        </div>

                        <div class="dates-row d-flex align-center gap-10">
                            <label for="dateTo">To:</label>
                            <input type="date" name="dateTo" id="dateTo" min="<?php echo date('Y-m-d'); ?>" value="<?= $data['reservationEndDate'] ?>" required>
                        </div>
                    </div>
                </div>

                <!--Room Type-->
                <div class="room-type-row d-flex flex-column gap-20">
                    <div class="room-type-title">
                        <label>Select Room Type</label>
                    </div>

                    <div class="room-type-row-container d-flex gap-40">
                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoRoomType" id="rdoRoomType1" value="Regular" <?= ($data['reservationRoomType'] === 'Regular') ? 'checked' : ''; ?> required>
                            <label for="rdoRoomType1">Regular</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoRoomType" id="rdoRoomType2" value="Deluxe" <?= ($data['reservationRoomType'] === 'Deluxe') ? 'checked' : ''; ?>>
                            <label for="rdoRoomType2">Deluxe</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoRoomType" id="rdoRoomType3" value="Suite" <?= ($data['reservationRoomType'] === 'Suite') ? 'checked' : ''; ?>>
                            <label for="rdoRoomType3">Suite</label>
                        </div>
                    </div>
                </div>

                <!--Room Capacity-->
                <div class="room-capacity-row d-flex flex-column gap-20">
                    <div class="room-capacity-title">
                        <label>Select Room Capacity</label>
                    </div>

                    <div class="room-capacity-row-container d-flex gap-40">
                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoRoomCapacity" id="rdoRoomCapacity1" value="Single" <?= ($data['reservationRoomCapacity'] === 'Single') ? 'checked' : ''; ?>>
                            <label for="rdoRoomCapacity1">Single</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoRoomCapacity" id="rdoRoomCapacity2" value="Double" <?= ($data['reservationRoomCapacity'] === 'Double') ? 'checked' : ''; ?>>
                            <label for="rdoRoomCapacity2">Double</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoRoomCapacity" id="rdoRoomCapacity3" value="Family" <?= ($data['reservationRoomCapacity'] === 'Family') ? 'checked' : ''; ?> required>
                            <label for="rdoRoomCapacity3">Family</label>
                        </div>
                    </div>
                </div>

                <!--Payment Type-->
                <div class="payment-type-row d-flex flex-column gap-20">
                    <div class="payment-type-title">
                        <label>Select Payment Method</label>
                    </div>

                    <div class="payment-type-row-container d-flex gap-40">
                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoPaymentType" id="rdoPaymentType1" value="Cash" <?= ($data['reservationPaymentType'] === 'Cash') ? 'checked' : ''; ?>>
                            <label for="rdoPaymentType1">Cash</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoPaymentType" id="rdoPaymentType2" value="Check" <?= ($data['reservationPaymentType'] === 'Check') ? 'checked' : ''; ?>>
                            <label for="rdoPaymentType2">Check</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoPaymentType" id="rdoPaymentType3" value="Credit Card" <?= ($data['reservationPaymentType'] === 'Credit Card') ? 'checked' : ''; ?> required>
                            <label for="rdoPaymentType3">Credit Card</label>
                        </div>
                    </div>

                </div>

                <!--Submit and Reset Buttons-->
                <div class="button-row d-flex gap-20">
                    <input type="submit" name="btnUpdate" value="Update" class="btn-reservation-submit-btn">
                    <button type="button" onclick="location.href='admin.php'" class="btn-reservation-reset-btn">Go Back</button>
                </div>
            </form>

        </div>

        <script>
            lucide.createIcons();

            //Date and Time
            function dateTime() {
                const displayDateTime = document.getElementById('date-time');

                function update() {
                    const now = new Date();

                    const datePart = now.toLocaleDateString('en-PH', {
                        timeZone: 'Asia/Manila',
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    });

                    const timePart = now.toLocaleTimeString('en-PH', {
                        timeZone: 'Asia/Manila',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    });

                    displayDateTime.textContent = `${datePart} @ ${timePart}`;
                }

                update();
                setInterval(update, 1000);
            }

            dateTime();
        </script>
</body>

</html>