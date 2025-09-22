<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/ParkingLot.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot_id = $_POST['lot_id'] ?? '';
    
    if (!empty($lot_id)) {
        $database = new Database();
        $db = $database->getConnection();
        $parkingLot = new ParkingLot($db);
        
        if ($parkingLot->delete($lot_id)) {
            setFlashMessage('Lot and spots deleted.', 'info');
        } else {
            setFlashMessage('Cannot delete. Spots still occupied.', 'danger');
        }
    }
}

redirect('admin_dashboard.php');
?>