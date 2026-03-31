<head>
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/reservation.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Reservation Confirmation</title>
</head>

<?php
session_start();
require 'includes/dbconn.php';
include_once 'includes/header.php';

$name = $_SESSION['name'];
?>

<body>
    <div class="reservation-hero">
        <div class="container d-flex">
            <h1 class="reservation-heading">Reservation Successful!</h1>
        </div>
    </div>

    <div class="reservation-form">
        <div class="container d-flex flex-column justify-center gap-20">
            <label>Thank you for reserving to our hotel, Mr/Ms <?php echo $name; ?>! You may now go back to our home page.</label>
            <form action="index.php">
                <input type="submit" value="Go Back" class="btn-reservation-submit-btn">
            </form>
        </div>

        <?php
        include_once 'includes/footer.php';
        session_destroy();
        ?>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>