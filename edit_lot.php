<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/ParkingLot.php';

requireAdmin();

$lot_id = $_GET['id'] ?? '';
if (empty($lot_id)) {
    redirect('admin_dashboard.php');
}

$database = new Database();
$db = $database->getConnection();
$parkingLot = new ParkingLot($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $pin = $_POST['pin'] ?? '';
    $price = $_POST['price_per_unit'] ?? '';
    $max_spots = $_POST['max_spots'] ?? '';
    
    if (!empty($name) && !empty($address) && !empty($pin) && !empty($price) && !empty($max_spots)) {
        $parkingLot->name = $name;
        $parkingLot->address = $address;
        $parkingLot->pin = $pin;
        $parkingLot->price_per_unit = floatval($price);
        $parkingLot->max_spots = intval($max_spots);
        
        if ($parkingLot->update($lot_id)) {
            setFlashMessage('Lot updated successfully.', 'success');
            redirect('admin_dashboard.php');
        } else {
            setFlashMessage('Failed to update lot.', 'danger');
        }
    } else {
        setFlashMessage('Please fill in all fields.', 'warning');
    }
}

$lot = $parkingLot->getById($lot_id);
if (!$lot) {
    redirect('admin_dashboard.php');
}

include 'templates/edit_lot.php';
?>