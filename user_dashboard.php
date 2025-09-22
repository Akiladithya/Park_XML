<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/ParkingLot.php';
require_once 'models/Car.php';
require_once 'models/Reservation.php';

requireUser();

$database = new Database();
$db = $database->getConnection();

// Get active booking
$reservation = new Reservation($db);
$active_booking = $reservation->getActiveBooking($_SESSION['user_id']);

// Get all parking lots with availability
$parkingLot = new ParkingLot($db);
$lots = $parkingLot->getAll();

// Add availability info to lots
foreach ($lots as &$lot) {
    $lot['available'] = $parkingLot->getAvailableSpots($lot['id']);
}

// Get user cars
$car = new Car($db);
$cars = $car->getUserCars($_SESSION['user_id']);

include 'templates/user_dashboard.php';
?>