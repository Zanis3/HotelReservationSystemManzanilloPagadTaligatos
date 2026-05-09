<?php

require_once '../apps/Core/Database.php';
require_once '../apps/Models/Reservation.php';
require_once '../apps/Controllers/HomeController.php';
require_once '../apps/Controllers/ReservationController.php';
require_once '../apps/Controllers/AdminController.php';

$page = $_GET['url'] ?? 'home';

$homeController = new HomeController();
$reservationController = new ReservationController();
$adminController = new AdminController();

switch ($page) {
    case 'home':
        $homeController->home();
        break;
    case 'contact':
        $homeController->contact();
        break;
    case 'profile':
        $homeController->profile();
        break;
    case 'reserve':
        $homeController->reserve();
        break;
    case 'billing':
        $reservationController->billing();
        break;
    case 'confirmation':
        $reservationController->confirmation();
        break;
    case 'admin/login':
        $adminController->login();
        break;
    case 'admin/dashboard':
        $adminController->dashboard();
        break;
    case 'admin/logout':
        $adminController->logout();
        break;
    case 'admin/reservations':
        $adminController->reservations();
        break;
    case 'admin/reservations/edit':
        $adminController->editReservation();
        break;
    case 'admin/reservations/delete':
        $adminController->deleteReservation();
        break;
    case 'admin/reservations/update-billing':
        $adminController->updateReservationBilling();
        break;
    case 'admin/settings':
        $adminController->settings();
        break;
    default:
        $homeController->home();
        break;
}
