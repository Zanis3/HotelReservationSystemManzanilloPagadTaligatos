<?php
session_start();
require 'includes/dbconn.php';

if (isset($_GET['id'])) {
    $reservationID = $_GET['id'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT guestID FROM tbl_reservation WHERE reservationID = ?");
        $stmt->execute([$reservationID]);
        $guestID = $stmt->fetchColumn();

        if ($guestID) {
            $pdo->prepare("DELETE FROM tbl_reservation WHERE reservationID = ?")
                ->execute([$reservationID]);

            $check = $pdo->prepare("SELECT COUNT(*) FROM tbl_reservation WHERE guestID = ?");
            $check->execute([$guestID]);

            if ($check->fetchColumn() == 0) {
                $pdo->prepare("DELETE FROM tbl_guests WHERE guestID = ?")
                    ->execute([$guestID]);
            }
        }

        $pdo->commit();
        header("Location: admin.php?status=deleted");
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}
