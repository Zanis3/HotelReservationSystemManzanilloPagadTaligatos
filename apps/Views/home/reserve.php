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
        <form action="index.php?url=reserve" method="POST" class="reservation-form-container d-flex flex-column gap-40">

            <!--Name-->
            <div class="name-row d-flex gap-20">
                <div class="name d-flex flex-column">
                    <label for="txtName">Name:</label>
                    <input type="text" id="txtName" name="txtName" placeholder="Enter Name..." value="<?php echo htmlspecialchars($_POST['txtName'] ?? ''); ?>" required>
                </div>
            </div>

            <!--Contact Number-->
            <div class="contact-number-row d-flex flex-column">
                <label for="txtContactNum">Contact Number:</label>
                <input type="number" id="txtContactNum" name="txtContactNum" placeholder="Contact Number..." value="<?php echo htmlspecialchars($_POST['txtContactNum'] ?? ''); ?>" required>
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
                        <input type="date" name="dateFrom" id="dateFrom" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($_POST['dateFrom'] ?? ''); ?>" required>
                    </div>

                    <div class="dates-row d-flex align-center gap-10">
                        <label for="dateTo">To:</label>
                        <input type="date" name="dateTo" id="dateTo" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($_POST['dateTo'] ?? ''); ?>" required>
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
                        <input type="radio" name="rdoRoomType" id="rdoRoomType1" value="Regular" <?php echo (htmlspecialchars($_POST['rdoRoomType'] ?? '') === 'Regular') ? 'checked' : ''; ?>>
                        <label for="rdoRoomType1">Regular</label>
                    </div>

                    <div class="radio-row d-flex align-center gap-10">
                        <input type="radio" name="rdoRoomType" id="rdoRoomType2" value="Deluxe" <?php echo (htmlspecialchars($_POST['rdoRoomType'] ?? '') === 'Deluxe') ? 'checked' : ''; ?>>
                        <label for="rdoRoomType2">Deluxe</label>
                    </div>

                    <div class="radio-row d-flex align-center gap-10">
                        <input type="radio" name="rdoRoomType" id="rdoRoomType3" value="Suite" <?php echo (htmlspecialchars($_POST['rdoRoomType'] ?? '') === 'Suite') ? 'checked' : ''; ?> required>
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
                        <input type="radio" name="rdoRoomCapacity" id="rdoRoomCapacity1" value="Single" <?php echo (htmlspecialchars($_POST['rdoRoomCapacity'] ?? '') === 'Single') ? 'checked' : ''; ?>>
                        <label for="rdoRoomCapacity1">Single</label>
                    </div>

                    <div class="radio-row d-flex align-center gap-10">
                        <input type="radio" name="rdoRoomCapacity" id="rdoRoomCapacity2" value="Double" <?php echo (htmlspecialchars($_POST['rdoRoomCapacity'] ?? '') === 'Double') ? 'checked' : ''; ?>>
                        <label for="rdoRoomCapacity2">Double</label>
                    </div>

                    <div class="radio-row d-flex align-center gap-10">
                        <input type="radio" name="rdoRoomCapacity" id="rdoRoomCapacity3" value="Family" <?php echo (htmlspecialchars($_POST['rdoRoomCapacity'] ?? '') === 'Family') ? 'checked' : ''; ?> required>
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
                        <input type="radio" name="rdoPaymentType" id="rdoPaymentType1" value="Cash" <?php echo (htmlspecialchars($_POST['rdoPaymentType'] ?? '') === 'Cash') ? 'checked' : ''; ?>>
                        <label for="rdoPaymentType1">Cash</label>
                    </div>

                    <div class="radio-row d-flex align-center gap-10">
                        <input type="radio" name="rdoPaymentType" id="rdoPaymentType2" value="Check" <?php echo (htmlspecialchars($_POST['rdoPaymentType'] ?? '') === 'Check') ? 'checked' : ''; ?>>
                        <label for="rdoPaymentType2">Check</label>
                    </div>

                    <div class="radio-row d-flex align-center gap-10">
                        <input type="radio" name="rdoPaymentType" id="rdoPaymentType3" value="Credit Card" <?php echo (htmlspecialchars($_POST['rdoPaymentType'] ?? '') === 'Credit Card') ? 'checked' : ''; ?> required>
                        <label for="rdoPaymentType3">Credit Card</label>
                    </div>
                </div>

            </div>

            <!--Submit and Reset Buttons-->
            <div class="button-row d-flex gap-20">
                <input type="submit" name="btnSubmit" value="Submit" class="btn-reservation-submit-btn">
                <button type="button" onclick="location.href='index.php?url=reserve'" class="btn-reservation-reset-btn">Clear</button>
            </div>
        </form>

    </div>
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