<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/Reservation.php';

requireAdmin();

$database = new Database();
$db = $database->getConnection();
$reservation = new Reservation($db);

$filters = [
    'user' => $_GET['user'] ?? '',
    'car' => $_GET['car'] ?? '',
    'status' => $_GET['status'] ?? ''
];

$reservations = $reservation->getAllReservations($filters);

include 'templates/admin_reservations.php';
?>