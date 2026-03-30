<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reservation.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Reservation</title>
</head>

<body>
    <?php include_once('includes/header.php'); ?>

    <div class="reservation-hero">
        <div class="container d-flex">
            <h1 class="reservation-heading">Book a Room Today!</h1>
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
            <form action="reservationConfirmation.php" method="POST" class="reservation-form-container d-flex flex-column gap-40">

                <!--Name (Last Name, First Name, Middle Initial)-->
                <div class="name-row d-flex gap-20">
                    <div class="name d-flex flex-column">
                        <label for="lname">Last Name:</label>
                        <input type="text" id="lname" name="lname" placeholder="Last Name..." required>
                    </div>

                    <div class="name d-flex flex-column">
                        <label for="fname">First Name:</label>
                        <input type="text" id="fname" name="fname" placeholder="First Name..." required>
                    </div>

                    <div class="name d-flex flex-column">
                        <label for="mi">M.I.:</label>
                        <input type="text" id="mi" name="mi" placeholder="M.I." required>
                    </div>
                </div>

                <!--Contact Number-->
                <div class="contact-number-row d-flex flex-column">
                    <label for="contactNum">Contact Number:</label>
                    <input type="tel" id="contactNum" name="contactNum" placeholder="Contact Number..." required>
                </div>

                <!--Room Type-->
                <div class="room-type-row d-flex flex-column gap-20">
                    <div class="room-type-title">
                        <label>Select Room Type</label>
                    </div>

                    <div class="room-type-row-container d-flex gap-40">
                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoType" id="rdoType1" value="Regular" checked>
                            <label for="rdoType1">Regular</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoType" id="rdoType2" value="Deluxe">
                            <label for="rdoType2">Deluxe</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoType" id="rdoType3" value="Suite">
                            <label for="rdoType3">Suite</label>
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
                            <input type="radio" name="rdoCapacity" id="rdoCapacity1" value="Single" checked>
                            <label for="rdoCapacity1">Single</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoCapacity" id="rdoCapacity2" value="Double">
                            <label for="rdoCapacity2">Double</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoCapacity" id="rdoCapacity3" value="Family">
                            <label for="rdoCapacity3">Family</label>
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
                            <input type="radio" name="rdoPayment" id="rdoPayment1" value="Cash" checked>
                            <label for="rdoPayment1">Cash</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoPayment" id="rdoPayment2" value="Check">
                            <label for="rdoPayment2">Check</label>
                        </div>

                        <div class="radio-row d-flex align-center gap-10">
                            <input type="radio" name="rdoPayment" id="rdoPayment3" value="Credit Card">
                            <label for="rdoPayment3">Credit Card</label>
                        </div>
                    </div>

                </div>

                <!--Submit and Reset Buttons-->
                <div class="button-row d-flex gap-20">
                    <input type="button" value="Submit" class="btn-reservation-submit-btn">
                    <input type="reset" value="Reset" class="btn-reservation-reset-btn">
                </div>
            </form>

        </div>
    </div>

    <?php include_once('includes/footer.php'); ?>

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
                    timeZZone: 'Asia/Manila',
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