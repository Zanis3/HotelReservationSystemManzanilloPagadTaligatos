<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/kubo-breeze-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze | Admin Login</title>
</head>

<body>

    <!--USERNAME: admin-->
    <!--PASSWORD: 12345-->
    <?php
    session_start();
    require 'includes/dbconn.php';

    if (isset($_SESSION['admin_user'])) {
        header('Location: admin.php');
        exit();
    }

    $loginError;

    if (isset($_POST['btnSubmit'])) {
        $username = $_POST['txtUsername'];
        $password = $_POST['txtPassword'];

        $stmt = $pdo->prepare("SELECT * FROM tbl_admin WHERE adminName = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['adminPass'])) {
            $_SESSION['admin_id'] = $admin['adminID'];
            $_SESSION['admin_user'] = $admin['adminName'];
            header('Location: admin.php');
            exit();
        } else {
            $loginError = "Invalid Username or Password.";
        }
    }
    ?>

    <div class="d-flex align-center justify-between login-container">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="container d-flex flex-column align-center justify-center gap-40 login-left">

            <img src="img/kubo-breeze-full-logo.png" alt="" style="width:280px;height:120px;">

            <h1 class="login-title">Admin Login</h1>

            <p class="warning"><?php echo $loginError ?? ''; ?></p>

            <div class="text-row d-flex flex-column justify-center">
                <label for="txtUsername">Username: </label>
                <input type="text" name="txtUsername" placeholder="Username here..." class="login-fields" value="<?php echo htmlspecialchars($_POST['txtUsername'] ?? ''); ?>" required>
            </div>

            <div class="text-row d-flex flex-column justify-center">
                <label for="txtPassword">Password: </label>
                <input type="password" name="txtPassword" placeholder="Password here..." class="login-fields" value="<?php echo htmlspecialchars($_POST['txtPassword'] ?? ''); ?>" required>
            </div>

            <div class="text-row d-flex justify-center gap-10">
                <input type="submit" name="btnSubmit" value="Submit" class="btn-reservation-submit-btn">
                <button type="button" class="btn-reservation-header" onclick="location.href='index.php'" style="border:none !important;">Return</button>
            </div>
        </form>

        <div class="login-right"></div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>