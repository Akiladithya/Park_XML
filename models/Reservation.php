<?php
class Reservation {
    private $conn;
    
    public $id;
    public $user_id;
    public $car_id;
    public $spot_id;
    public $status;
    public $reserved_at;
    public $entered_at;
    public $exited_at;
    public $total_cost;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        // Find available spot
        $spotQuery = "SELECT id FROM parking_spots WHERE lot_id = ? AND status = 'A' LIMIT 1";
        $spotStmt = $this->conn->prepare($spotQuery);
        $spotStmt->execute([$this->spot_id]); // spot_id here is actually lot_id
        
        $spot = $spotStmt->fetch(PDO::FETCH_ASSOC);
        if (!$spot) {
            return false; // No available spots
        }
        
        $this->spot_id = $spot['id'];
        
        $this->conn->beginTransaction();
        try {
            // Create reservation
            $query = "INSERT INTO reservations (user_id, car_id, spot_id, status, reserved_at) VALUES (?, ?, ?, 'Reserved', NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$this->user_id, $this->car_id, $this->spot_id]);
            
            // Update spot status to Reserved
            $updateSpot = "UPDATE parking_spots SET status = 'R' WHERE id = ?";
            $updateStmt = $this->conn->prepare($updateSpot);
            $updateStmt->execute([$this->spot_id]);
            
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function getUserReservations($user_id) {
        $query = "
            SELECT r.id, p.name AS lot_name, c.car_number,
                   r.reserved_at, r.entered_at, r.exited_at, r.status, r.total_cost
            FROM reservations r
            LEFT JOIN parking_spots s ON r.spot_id = s.id
            LEFT JOIN parking_lots p ON s.lot_id = p.id
            LEFT JOIN cars c ON r.car_id = c.id
            WHERE r.user_id = ?
            ORDER BY r.reserved_at DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveBooking($user_id) {
        $query = "
            SELECT r.id, p.name AS lot_name, r.reserved_at, r.status
            FROM reservations r
            JOIN parking_spots s ON r.spot_id = s.id
            JOIN parking_lots p ON s.lot_id = p.id
            WHERE r.user_id = ? AND r.status = 'Entered'
            ORDER BY r.entered_at DESC LIMIT 1
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllReservations($filters = []) {
        $query = "
            SELECT r.id, u.name AS user, c.car_number, p.name AS lot, s.id as spot_id, r.status,
                   r.reserved_at, r.entered_at, r.exited_at, r.total_cost
            FROM reservations r
            JOIN users u ON r.user_id = u.id
            LEFT JOIN cars c ON r.car_id = c.id
            LEFT JOIN parking_spots s ON r.spot_id = s.id
            LEFT JOIN parking_lots p ON s.lot_id = p.id
        ";
        
        $conditions = [];
        $params = [];
        
        if (!empty($filters['user'])) {
            $conditions[] = "u.name LIKE ?";
            $params[] = "%{$filters['user']}%";
        }
        
        if (!empty($filters['car'])) {
            $conditions[] = "c.car_number LIKE ?";
            $params[] = "%{$filters['car']}%";
        }
        
        if (!empty($filters['status'])) {
            $conditions[] = "r.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $query .= " ORDER BY r.reserved_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markEntered($booking_id) {
        $this->conn->beginTransaction();
        try {
            // Get spot_id
            $getSpot = "SELECT spot_id FROM reservations WHERE id = ? AND status = 'Reserved'";
            $getStmt = $this->conn->prepare($getSpot);
            $getStmt->execute([$booking_id]);
            $spot = $getStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$spot) {
                return false;
            }
            
            // Update reservation
            $updateRes = "UPDATE reservations SET status = 'Entered', entered_at = NOW() WHERE id = ?";
            $resStmt = $this->conn->prepare($updateRes);
            $resStmt->execute([$booking_id]);
            
            // Update spot status
            $updateSpot = "UPDATE parking_spots SET status = 'O' WHERE id = ?";
            $spotStmt = $this->conn->prepare($updateSpot);
            $spotStmt->execute([$spot['spot_id']]);
            
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function markExited($booking_id) {
        $this->conn->beginTransaction();
        try {
            // Get reservation details
            $getRes = "SELECT entered_at, spot_id FROM reservations WHERE id = ? AND status = 'Entered'";
            $getStmt = $this->conn->prepare($getRes);
            $getStmt->execute([$booking_id]);
            $res = $getStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$res) {
                return false;
            }
            
            // Calculate cost
            $entered = new DateTime($res['entered_at']);
            $now = new DateTime();
            $duration = $now->diff($entered);
            $minutes = ($duration->days * 24 * 60) + ($duration->h * 60) + $duration->i;
            $hours = max(1, ceil($minutes / 60)); // Minimum 1 hour
            
            // Get price
            $getPriceQuery = "SELECT price_per_unit FROM parking_lots WHERE id = (SELECT lot_id FROM parking_spots WHERE id = ?)";
            $priceStmt = $this->conn->prepare($getPriceQuery);
            $priceStmt->execute([$res['spot_id']]);
            $price = $priceStmt->fetchColumn();
            
            $cost = round($price * $hours, 2);
            
            // Update reservation
            $updateRes = "UPDATE reservations SET status = 'Exited', exited_at = NOW(), total_cost = ? WHERE id = ?";
            $resStmt = $this->conn->prepare($updateRes);
            $resStmt->execute([$cost, $booking_id]);
            
            // Update spot status
            $updateSpot = "UPDATE parking_spots SET status = 'A' WHERE id = ?";
            $spotStmt = $this->conn->prepare($updateSpot);
            $spotStmt->execute([$res['spot_id']]);
            
            $this->conn->commit();
            return $cost;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function cancel($booking_id, $user_id) {
        $this->conn->beginTransaction();
        try {
            // Get reservation details
            $getRes = "SELECT spot_id, status FROM reservations WHERE id = ? AND user_id = ?";
            $getStmt = $this->conn->prepare($getRes);
            $getStmt->execute([$booking_id, $user_id]);
            $res = $getStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$res || $res['status'] !== 'Reserved') {
                return false;
            }
            
            // Update reservation
            $updateRes = "UPDATE reservations SET status = 'Cancelled' WHERE id = ?";
            $resStmt = $this->conn->prepare($updateRes);
            $resStmt->execute([$booking_id]);
            
            // Update spot status
            $updateSpot = "UPDATE parking_spots SET status = 'A' WHERE id = ?";
            $spotStmt = $this->conn->prepare($updateSpot);
            $spotStmt->execute([$res['spot_id']]);
            
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }
}
?>