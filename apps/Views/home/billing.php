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
            <p><?php echo ($roomCapacity ?? '') . ' ' . ($roomType ?? ''); ?></p>
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
            <p><?php echo number_format($subTotal ?? 0, 2) ?? ''; ?></p>
        </div>

        <div class="row d-flex gap-20">
            <label>Discount:</label>
            <p><?php echo number_format($totalDiscount ?? 0, 2) ?? ''; ?></p>
        </div>

        <div class="row d-flex gap-20">
            <label>Grand Total:</label>
            <p><?php echo number_format($grandTotal ?? 0, 2) ?? ''; ?></p>
        </div>

        <form action="index.php?url=billing" method="post">
            <div class="button-container">
                <input type="submit" name="btnConfirm" value="Confirm" class="btn-reservation-submit-btn">
                <button type="button" class="btn-reservation-reset-btn" onclick="history.back()">Return</button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>