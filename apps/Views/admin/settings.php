<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="public/img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Admin Settings</title>
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
                        <a href="index.php?url=admin/reservations" class="sidebar-link">
                            <i data-lucide="calendar-check"></i>
                            <span>Reservations</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?url=admin/settings" class="sidebar-link active">
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
                <h1 class="admin-greeting">Account Settings</h1>
                <p class="admin-date"><?php echo date('l, F j, Y'); ?></p>
            </header>

            <!-- Settings Form -->
            <section class="settings-container">
                <div class="settings-card">
                    <div class="settings-card-header">
                        <i data-lucide="user-cog"></i>
                        <h2>Admin Credentials</h2>
                    </div>
                    <p class="settings-description">Update your admin username and password.</p>

                    <?php if (!empty($message)): ?>
                        <div class="settings-alert settings-alert-<?php echo ($messageType ?? ''); ?>">
                            <i data-lucide="<?php echo ($messageType ?? '') === 'success' ? 'check-circle' : 'alert-circle'; ?>"></i>
                            <span><?php echo htmlspecialchars($message); ?></span>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?url=admin/settings" method="POST" class="settings-form">
                        <div class="form-group">
                            <label for="txtUsername">Username</label>
                            <input type="text" name="txtUsername" id="txtUsername" class="form-input" value="<?php echo htmlspecialchars($adminName ?? ''); ?>" required>
                        </div>

                        <hr class="settings-divider">

                        <div class="form-group">
                            <label for="txtCurrentPassword">Current Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="txtCurrentPassword" id="txtCurrentPassword" class="form-input" placeholder="Enter current password" required>
                                <button type="button" class="btn-toggle-password" data-target="txtCurrentPassword" aria-label="Show password">
                                    <i data-lucide="eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="txtNewPassword">New Password <span class="optional">(optional)</span></label>
                            <div class="password-wrapper">
                                <input type="password" name="txtNewPassword" id="txtNewPassword" class="form-input" placeholder="Leave blank to keep current">
                                <button type="button" class="btn-toggle-password" data-target="txtNewPassword" aria-label="Show password">
                                    <i data-lucide="eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="txtConfirmPassword">Confirm New Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="txtConfirmPassword" id="txtConfirmPassword" class="form-input" placeholder="Confirm new password">
                                <button type="button" class="btn-toggle-password" data-target="txtConfirmPassword" aria-label="Show password">
                                    <i data-lucide="eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="btnSave" class="btn-save">
                                <i data-lucide="save"></i>
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

        </main>
    </div>

    <script>
        lucide.createIcons();

        // Toggle password visibility
        document.querySelectorAll('.btn-toggle-password').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                if (input) {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.innerHTML = type === 'password' ?
                        '<i data-lucide="eye"></i>' :
                        '<i data-lucide="eye-off"></i>';
                    lucide.createIcons();
                }
            });
        });
    </script>
</body>

</html>