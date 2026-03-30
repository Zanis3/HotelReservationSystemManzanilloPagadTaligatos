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
        <div class="container d-flex flex-column justify-center align-center">

            <!--Date and time row-->
            <div class="date-row d-flex align-center gap-10">
                <i data-lucide="clock"></i>
                <span id="date-time">08:00:00 AM</span>
            </div>

            <!--Reservation Form-->
            <form action="reservationConfirmation.php" method="POST" class="reservation-form-container">

            </form>

        </div>
    </div>

    <?php include_once('includes/footer.php'); ?>

    <script>
        lucide.createIcons();

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