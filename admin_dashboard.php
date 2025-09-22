<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/ParkingLot.php';

requireAdmin();

$database = new Database();
$db = $database->getConnection();
$parkingLot = new ParkingLot($db);

$search = $_GET['search'] ?? '';
$lots = $parkingLot->getAll($search);

// Add occupancy data
foreach ($lots as &$lot) {
    $lot['occupied'] = $parkingLot->getOccupiedSpots($lot['id']);
    $lot['available'] = $lot['max_spots'] - $lot['occupied'];
}

include 'templates/admin_dashboard.php';
?>