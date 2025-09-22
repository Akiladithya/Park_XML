<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/ParkingLot.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $pin = $_POST['pin'] ?? '';
    $price = $_POST['price_per_unit'] ?? '';
    $max_spots = $_POST['max_spots'] ?? '';
    
    if (!empty($name) && !empty($address) && !empty($pin) && !empty($price) && !empty($max_spots)) {
        $database = new Database();
        $db = $database->getConnection();
        $parkingLot = new ParkingLot($db);
        
        $parkingLot->name = $name;
        $parkingLot->address = $address;
        $parkingLot->pin = $pin;
        $parkingLot->price_per_unit = floatval($price);
        $parkingLot->max_spots = intval($max_spots);
        
        if ($parkingLot->create()) {
            setFlashMessage('Lot created and spots added.', 'success');
            redirect('admin_dashboard.php');
        } else {
            setFlashMessage('Failed to create lot.', 'danger');
        }
    } else {
        setFlashMessage('Please fill in all fields.', 'warning');
    }
}

include 'templates/create_lot.php';
?>