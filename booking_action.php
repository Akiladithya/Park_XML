<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/Reservation.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? '';
    $action = $_POST['action'] ?? '';
    
    if (!empty($booking_id) && !empty($action)) {
        $database = new Database();
        $db = $database->getConnection();
        $reservation = new Reservation($db);
        
        if ($action === 'enter') {
            if ($reservation->markEntered($booking_id)) {
                setFlashMessage('Reservation marked as entered.', 'success');
            } else {
                setFlashMessage('Invalid or already entered booking.', 'warning');
            }
        } elseif ($action === 'exit') {
            $cost = $reservation->markExited($booking_id);
            if ($cost !== false) {
                setFlashMessage("Reservation exited and cost calculated: ₹$cost", 'success');
            } else {
                setFlashMessage('Invalid booking or already exited.', 'warning');
            }
        }
    }
}

redirect('admin_reservations.php');
?>