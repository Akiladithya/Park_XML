<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/Reservation.php';

requireUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot_id = $_POST['lot_id'] ?? '';
    $car_id = $_POST['car_id'] ?? '';
    
    if (empty($lot_id) || empty($car_id)) {
        setFlashMessage('Please select both car and parking lot.', 'warning');
    } else {
        $database = new Database();
        $db = $database->getConnection();
        
        $reservation = new Reservation($db);
        $reservation->user_id = $_SESSION['user_id'];
        $reservation->car_id = $car_id;
        $reservation->spot_id = $lot_id; // This will be converted to actual spot_id in create method
        
        if ($reservation->create()) {
            setFlashMessage('Reservation created successfully. Please wait for admin approval.', 'success');
        } else {
            setFlashMessage('No available spot in selected lot.', 'warning');
        }
    }
}

redirect('user_dashboard.php');
?>