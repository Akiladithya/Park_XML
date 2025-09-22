<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/Reservation.php';

requireUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? '';
    
    if (!empty($booking_id)) {
        $database = new Database();
        $db = $database->getConnection();
        $reservation = new Reservation($db);
        
        if ($reservation->cancel($booking_id, $_SESSION['user_id'])) {
            setFlashMessage('Booking cancelled successfully.', 'success');
        } else {
            setFlashMessage('Cannot cancel booking or booking not found.', 'danger');
        }
    }
}

redirect('user_history.php');
?>