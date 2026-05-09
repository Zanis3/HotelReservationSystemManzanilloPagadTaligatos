<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="public/img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Manage Reservations</title>
</head>

<body>

    <div class="admin-layout">

        <!-- SIDEBAR -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand d-flex align-center gap-10">
                <img src="public/img/kubo-breeze-logo.png" alt="Kubo Breeze" class="sidebar-logo">
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
                <h1 class="admin-greeting">Manage Reservations</h1>
                <p class="admin-date"><?php echo date('l, F j, Y'); ?></p>
            </header>

            <!-- Status Messages -->
            <?php if (($status ?? '') === 'deleted'): ?>
                <div class="status-message status-success">
                    <i data-lucide="check-circle"></i>
                    <span>Reservation deleted successfully.</span>
                </div>
            <?php elseif (($status ?? '') === 'updated'): ?>
                <div class="status-message status-success">
                    <i data-lucide="check-circle"></i>
                    <span>Reservation updated successfully.</span>
                </div>
            <?php endif; ?>

            <!-- Reservations Table -->
            <section class="reservations-section">
                <div class="reservations-card">
                    <table class="reservations-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Guest Name</th>
                                <th>Contact Number</th>
                                <th>Reservation Date</th>
                                <th>Room Type</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count(($reservations ?? [])) > 0): ?>
                                <?php foreach (($reservations ?? []) as $row): ?>
                                    <tr>
                                        <td><?= $row['reservationID'] ?></td>
                                        <td><?= htmlspecialchars($row['guestName']) ?></td>
                                        <td><?= htmlspecialchars($row['guestContact']) ?></td>
                                        <td><?= date('M d, Y', strtotime($row['reservationDate'])) ?></td>
                                        <td>
                                            <?= $row['reservationRoomCapacity'] ?> - <?= $row['reservationRoomType'] ?>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="index.php?url=admin/reservations/edit&id=<?= $row['reservationID'] ?>" class="btn-table-action btn-table-view" title="View / Edit">
                                                    <i data-lucide="eye"></i>
                                                </a>
                                                <a href="index.php?url=admin/reservations/delete&id=<?= $row['reservationID'] ?>" class="btn-table-action btn-table-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this reservation?');">
                                                    <i data-lucide="trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="table-empty">
                                        <i data-lucide="inbox"></i>
                                        <p>No reservations found.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>