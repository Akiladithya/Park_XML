<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/Reservation.php';

requireUser();

$database = new Database();
$db = $database->getConnection();
$reservation = new Reservation($db);

$history = $reservation->getUserReservations($_SESSION['user_id']);

include 'templates/user_history.php';
?>