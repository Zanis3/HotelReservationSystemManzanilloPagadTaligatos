<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Admin View</title>
</head>

<body>
    <?php
    session_start();
    require 'includes/dbconn.php';

    if (isset($_POST['btnLogout'])) {
        session_destroy();
        header('Location: index.php');
        exit();
    }

    try {
        $sql = "SELECT r.reservationID, g.guestName, g.guestContact, r.reservationDate, r.reservationRoomType, r.reservationRoomCapacity FROM tbl_reservation r INNER JOIN tbl_guests g ON r.guestID = g.guestID ORDER BY r.reservationID ASC";

        $stmt = $pdo->query($sql);
        $reservations = $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Error fetching reservations: " . $e->getMessage());
    }
    ?>

    <div class="container d-flex flex-column justify-center gap-40">

        <div class="admin-header d-flex justify-between align-center" style="padding: 35px;">

            <div class="d-flex justify-center align-center gap-20">
                <img src="img/kubo-breeze-logo.png" alt="" style="height:70px; width:70px;">
                <h1 class="admin-title">Welcome, <?php echo $_SESSION['admin_user']; ?>!</h1>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <input type="submit" name="btnLogout" value="Logout" class="btn-reservation-reset-btn">
            </form>
        </div>

        <div class="reservation-table d-flex justify-center">
            <table>
                <thead>
                    <tr>
                        <th colspan="1">ID</th>
                        <th colspan="1">Guest Name</th>
                        <th colspan="1">Contact Number</th>
                        <th colspan="1">Reservation Date</th>
                        <th colspan="1">Room Type</th>
                        <th colspan="1">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($reservations) > 0): ?>
                        <?php foreach ($reservations as $row): ?>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td colspan="1"><?= $row['reservationID'] ?></td>
                                <td colspan="1"><?= htmlspecialchars($row['guestName']) ?></td>
                                <td colspan="1"><?= htmlspecialchars($row['guestContact']) ?></td>
                                <td colspan="1"><?= date('M d, Y', strtotime($row['reservationDate'])) ?></td>
                                <td colspan="1">
                                    <?= $row['reservationRoomCapacity'] ?> - <?= $row['reservationRoomType'] ?>
                                </td>
                                <td colspan="1" style="text-align: center;">
                                    <div class="d-flex gap-10 justify-center">
                                        <a href="UpdateReservation.php?id=<?= $row['reservationID'] ?>" class="btn-reservation-header d-flex justify-center align-center" style="width:60px; height:60px;"><i data-lucide="eye"></i></a>

                                        <a href="DeleteReservation.php?id=<?= $row['reservationID'] ?>" class="btn-reservation-reset-btn d-flex justify-center align-center" style="width:60px; height:60px;" onclick="return confirm('Are you sure you want to delete this reservation?');"><i data-lucide="trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No reservations found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>