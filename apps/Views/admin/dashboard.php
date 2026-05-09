<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Admin Dashboard</title>
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
                        <a href="index.php?url=admin/dashboard" class="sidebar-link active">
                            <i data-lucide="layout-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?url=admin/reservations" class="sidebar-link">
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
                <h1 class="admin-greeting">Welcome back, <?php echo htmlspecialchars($adminName ?? 'Admin'); ?>!</h1>
                <p class="admin-date"><?php echo date('l, F j, Y'); ?></p>
            </header>

            <!-- Stats Card -->
            <section class="stats-row">
                <div class="stat-card">
                    <div class="stat-card-header d-flex align-center justify-between">
                        <span class="stat-label">Total Reservations</span>
                        <div class="stat-icon stat-icon-primary">
                            <i data-lucide="calendar-check"></i>
                        </div>
                    </div>
                    <p class="stat-value"><?php echo $totalReservations ?? 0; ?></p>
                    <p class="stat-change">
                        <i data-lucide="info"></i>
                        <span><?php echo ($totalReservations ?? 0) > 0 ? 'Total reservations recorded' : 'No reservations recorded yet'; ?></span>
                    </p>
                </div>
            </section>

            <!-- Recent Activity / Quick Actions -->
            <section class="dashboard-panels">
                <div class="panel panel-recent">
                    <div class="panel-header d-flex align-center justify-between">
                        <h2 class="panel-title">Recent Reservations</h2>
                        <a href="index.php?url=admin/reservations" class="panel-link">View All</a>
                    </div>
                    <div class="panel-body">
                        <?php if (isset($recentReservations) && count($recentReservations) > 0): ?>
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="text-align: left; padding: 8px;">ID</th>
                                        <th style="text-align: left; padding: 8px;">Guest</th>
                                        <th style="text-align: left; padding: 8px;">Date</th>
                                        <th style="text-align: left; padding: 8px;">Room</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($recentReservations, 0, 5) as $res): ?>
                                        <tr style="border-bottom: 1px solid #f5f5f5;">
                                            <td style="padding: 8px;"><?= $res['reservationID'] ?></td>
                                            <td style="padding: 8px;"><?= htmlspecialchars($res['guestName']) ?></td>
                                            <td style="padding: 8px;"><?= date('M d, Y', strtotime($res['reservationDate'])) ?></td>
                                            <td style="padding: 8px;"><?= $res['reservationRoomCapacity'] ?> - <?= $res['reservationRoomType'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="panel-empty">
                                <i data-lucide="inbox"></i>
                                <span>No reservations yet.</span>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="panel panel-actions">
                    <div class="panel-header">
                        <h2 class="panel-title">Quick Actions</h2>
                    </div>
                    <div class="panel-body quick-actions-grid">
                        <a href="index.php?url=admin/reservations" class="quick-action-card">
                            <i data-lucide="calendar-plus"></i>
                            <span>Manage Reservations</span>
                        </a>
                        <a href="index.php?url=admin/settings" class="quick-action-card">
                            <i data-lucide="user-cog"></i>
                            <span>Account Settings</span>
                        </a>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>