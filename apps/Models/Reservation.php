<?php

class Reservation
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    //Fetch all reservations with guest info, ordered by ID ascending.
    public function getAllReservations(): array
    {
        $sql = "SELECT r.reservationID, g.guestName, g.guestContact, r.reservationDate, 
                       r.reservationStartDate, r.reservationEndDate,
                       r.reservationRoomType, r.reservationRoomCapacity, r.reservationPaymentType
                FROM tbl_reservation r 
                INNER JOIN tbl_guests g ON r.guestID = g.guestID 
                ORDER BY r.reservationID ASC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    //Fetch a single reservation with guest info by reservation ID.
    public function getReservationById(int $id): ?array
    {
        $sql = "SELECT r.*, g.guestName, g.guestContact 
                FROM tbl_reservation r 
                JOIN tbl_guests g ON r.guestID = g.guestID 
                WHERE r.reservationID = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ?: null;
    }

    //Delete a reservation and its associated guest if no other reservations exist.  Returns true on success, false on failure.
    public function deleteReservation(int $reservationID): bool
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("SELECT guestID FROM tbl_reservation WHERE reservationID = ?");
            $stmt->execute([$reservationID]);
            $guestID = $stmt->fetchColumn();

            if ($guestID) {
                $this->pdo->prepare("DELETE FROM tbl_reservation WHERE reservationID = ?")
                    ->execute([$reservationID]);

                $check = $this->pdo->prepare("SELECT COUNT(*) FROM tbl_reservation WHERE guestID = ?");
                $check->execute([$guestID]);

                if ($check->fetchColumn() == 0) {
                    $this->pdo->prepare("DELETE FROM tbl_guests WHERE guestID = ?")
                        ->execute([$guestID]);
                }
            }

            $this->pdo->commit();
            return true;
        } catch (\PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    //Update guest and reservation data, plus payment record.
    public function updateReservation(
        int $reservationID,
        int $guestID,
        string $guestName,
        string $guestContact,
        string $fromDate,
        string $toDate,
        string $roomType,
        string $roomCapacity,
        string $paymentType,
        int $noDays,
        float $subTotal,
        float $totalDiscount,
        float $grandTotal
    ): bool {
        try {
            $this->pdo->beginTransaction();

            //Update Guest
            $stmt1 = $this->pdo->prepare("UPDATE tbl_guests SET guestName = ?, guestContact = ? WHERE guestID = ?");
            $stmt1->execute([$guestName, $guestContact, $guestID]);

            //Update Reservation
            $stmt2 = $this->pdo->prepare("UPDATE tbl_reservation SET 
                reservationStartDate = ?, 
                reservationEndDate = ?, 
                reservationRoomType = ?, 
                reservationRoomCapacity = ?, 
                reservationPaymentType = ?, 
                reservationNoOfDays = ? 
                WHERE reservationID = ?");

            $stmt2->execute([
                $fromDate,
                $toDate,
                $roomType,
                $roomCapacity,
                $paymentType,
                $noDays,
                $reservationID
            ]);

            //Update Payments
            $stmt3 = $this->pdo->prepare("UPDATE tbl_payments SET 
                paymentSubTotal = ?, 
                paymentDiscount = ?, 
                paymentGrandTotal = ? 
                WHERE guestID = ?");
            $stmt3->execute([$subTotal, $totalDiscount, $grandTotal, $guestID]);

            $this->pdo->commit();
            return true;
        } catch (\PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    //Get the total count of reservations.
    public function getTotalCount(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM tbl_reservation");
        return (int) $stmt->fetchColumn();
    }
}
