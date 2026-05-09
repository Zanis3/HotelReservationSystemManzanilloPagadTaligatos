<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/reservation.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Update Reservation Billing</title>
</head>

<body>

    <div class="admin-layout">

        <!-- SIDEBAR -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand d-flex align-center gap-10">
                <img src="img/kubo-breeze-logo.png" alt="Kubo Breeze" class="sidebar-logo">
                <span class="sidebar-brand-text">Kubo Breeze</span>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="index.php?url=admin/dashboard" class="sidebar-link">
                            <i data-lucide="layout-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?url=admin/reservations" class="sidebar-link active">
                            <i data-lucide="calendar-check"></i>
                            <span>Reservations</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?url=admin/settings" class="sidebar-link">
                            <i data-lucide="settings"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <a href="index.php?url=admin/logout" class="sidebar-link sidebar-logout">
                    <i data-lucide="log-out"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="admin-main">

            <!-- Top Bar -->
            <header class="admin-topbar">
                <h1 class="admin-greeting">Update Billing Confirmation</h1>
                <p class="admin-date"><?php echo date('l, F j, Y'); ?></p>
            </header>

            <!-- Billing Content -->
            <div class="reservation-form" style="padding: 20px 0;">
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
                        <p><?php echo number_format($subTotal ?? 0, 2); ?></p>
                    </div>

                    <div class="row d-flex gap-20">
                        <label>Discount:</label>
                        <p><?php echo number_format($totalDiscount ?? 0, 2); ?></p>
                    </div>

                    <div class="row d-flex gap-20">
                        <label>Grand Total:</label>
                        <p><?php echo number_format($grandTotal ?? 0, 2); ?></p>
                    </div>

                    <form action="index.php?url=admin/reservations/update-billing" method="POST">
                        <div class="button-container">
                            <input type="submit" name="btnConfirm" value="Confirm" class="btn-reservation-submit-btn">
                            <button type="button" class="btn-reservation-reset-btn" onclick="history.back()">Return</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>