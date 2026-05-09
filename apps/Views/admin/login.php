<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/login.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Admin Login</title>
</head>

<body>

    <!--USERNAME: admin-->
    <!--PASSWORD: 12345-->

    <div class="d-flex align-center justify-between login-container">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?url=admin/login" method="POST" class="container d-flex flex-column align-center justify-center gap-40 login-left">

            <img src="img/kubo-breeze-full-logo.png" alt="" style="width:280px;height:120px;">

            <h1 class="login-title">Admin Login</h1>

            <p class="warning"><?php echo $loginError ?? ''; ?></p>

            <div class="text-row d-flex flex-column justify-center">
                <label for="txtUsername">Username: </label>
                <input type="text" name="txtUsername" id="txtUsername" placeholder="Username here..." class="login-fields" value="<?php echo htmlspecialchars($_POST['txtUsername'] ?? ''); ?>" required>
            </div>

            <div class="text-row d-flex flex-column justify-center">
                <label for="txtPassword">Password: </label>
                <div class="password-wrapper d-flex align-center">
                    <input type="password" name="txtPassword" id="txtPassword" placeholder="Password here..." class="login-fields" value="<?php echo htmlspecialchars($_POST['txtPassword'] ?? ''); ?>" required>
                    <button type="button" id="togglePassword" class="btn-toggle-password" aria-label="Show password">
                        <i data-lucide="eye"></i>
                    </button>
                </div>
            </div>

            <div class="text-row d-flex justify-center gap-10">
                <input type="submit" name="btnSubmit" value="Submit" class="btn-reservation-submit-btn">
                <button type="button" class="btn-reservation-header" onclick="location.href='?url=home'" style="border:none !important;">Return</button>
            </div>
        </form>

        <div class="login-right"></div>
    </div>

    <script>
        lucide.createIcons();

        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('txtPassword');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the icon
            this.innerHTML = type === 'password' ?
                '<i data-lucide="eye"></i>' :
                '<i data-lucide="eye-off"></i>';
            lucide.createIcons();
        });
    </script>
</body>

</html>