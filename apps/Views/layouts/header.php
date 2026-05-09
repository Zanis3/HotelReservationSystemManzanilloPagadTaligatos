<head>
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/reservation.css">
    <link rel="shortcut icon" href="public/img/kubo-breeze-logo.png" type="image/x-icon">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Kubo Breeze</title>
</head>

<body>
    <header>
        <div class="container d-flex justify-between">
            <a href="index.php" style="display:block" class="logo">
                <img src="public/img/kubo-breeze-full-logo.png" class="logo">
            </a>

            <ul class="nav d-flex justify-center gap-10">
                <li class="nav-item">
                    <a href="index.php?url=home" class="d-flex justify-center align-center">Home</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?url=profile" class="d-flex justify-center align-center">Company Profile</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?url=contact" class="d-flex justify-center align-center">Contacts</a>
                </li>
                <li class="nav-item d-flex justify-center align-center">
                    <a href="index.php?url=reserve" class="btn-reservation-header d-flex justify-center align-center gap-10">
                        <i data-lucide="bookmark"></i>
                        <span>Reserve Now</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <script>
        lucide.createIcons();
    </script>
</body>