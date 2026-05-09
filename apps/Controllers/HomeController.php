<?php

class HomeController
{

    private function checkAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['admin_user'])) {
            header('Location: index.php?url=admin/dashboard');
            exit();
        }
    }

    private function renderView(string $view, array $data = []): void
    {
        extract($data);
        require_once '../apps/Views/layouts/header.php';
        require_once "../apps/Views/home/{$view}.php";
        require_once '../apps/Views/layouts/footer.php';
    }

    public function home(): void
    {
        $this->checkAdmin();
        $this->renderView('home');
    }

    public function contact(): void
    {
        $this->checkAdmin();
        $this->renderView('contact');
    }

    public function profile(): void
    {
        $this->checkAdmin();
        $this->renderView('profile');
    }

    public function reserve(): void
    {
        $this->checkAdmin();

        $dateError = '';
        if (isset($_POST['btnSubmit'])) {
            $check = false;

            $fromDate = $_POST['dateFrom'];
            $toDate = $_POST['dateTo'];

            if ($fromDate > $toDate) {
                $dateError = "Check-out must be on or after the check-in date.";
            } else {
                $check = true;
            }

            if ($check) {
                $_SESSION['name'] = ucwords($_POST['txtName']);
                $_SESSION['contact'] = $_POST['txtContactNum'];
                $_SESSION['fromDate'] = $fromDate;
                $_SESSION['toDate'] = $toDate;
                $_SESSION['roomType'] = $_POST['rdoRoomType'];
                $_SESSION['roomCapacity'] = $_POST['rdoRoomCapacity'];
                $_SESSION['paymentType'] = $_POST['rdoPaymentType'];
                header('Location: index.php?url=billing');
                exit();
            }
        }

        $this->renderView('reserve', ['dateError' => $dateError]);
    }
}
