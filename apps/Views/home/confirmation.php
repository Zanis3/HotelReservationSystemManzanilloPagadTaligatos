<div class="reservation-hero">
    <div class="container d-flex">
        <h1 class="reservation-heading">Reservation Successful!</h1>
    </div>
</div>

<div class="reservation-form">
    <div class="container d-flex flex-column justify-center gap-20">
        <label>Thank you for reserving to our hotel, Mr/Ms <?php echo $name ?? ''; ?>! You may now go back to our home page.</label>
        <form action="index.php">
            <input type="submit" value="Go Back" class="btn-reservation-submit-btn">
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>