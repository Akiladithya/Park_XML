<?php
class ParkingLot {
    private $conn;
    
    public $id;
    public $name;
    public $address;
    public $pin;
    public $price_per_unit;
    public $max_spots;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $this->conn->beginTransaction();
        try {
            $query = "INSERT INTO parking_lots (name, address, pin, price_per_unit, max_spots) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$this->name, $this->address, $this->pin, $this->price_per_unit, $this->max_spots]);
            
            $lot_id = $this->conn->lastInsertId();
            
            // Create parking spots
            $spotQuery = "INSERT INTO parking_spots (lot_id, status) VALUES (?, 'A')";
            $spotStmt = $this->conn->prepare($spotQuery);
            
            for ($i = 0; $i < $this->max_spots; $i++) {
                $spotStmt->execute([$lot_id]);
            }
            
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function getAll($search = '') {
        $query = "SELECT * FROM parking_lots";
        $params = [];
        
        if (!empty($search)) {
            $query .= " WHERE name LIKE ? OR pin LIKE ?";
            $params = ["%$search%", "%$search%"];
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM parking_lots WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE parking_lots SET name = ?, address = ?, pin = ?, price_per_unit = ?, max_spots = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->name, $this->address, $this->pin, $this->price_per_unit, $this->max_spots, $id]);
    }

    public function delete($id) {
        // Check if any spots are occupied
        $checkQuery = "SELECT COUNT(*) FROM parking_spots WHERE lot_id = ? AND status = 'O'";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->execute([$id]);
        
        if ($checkStmt->fetchColumn() > 0) {
            return false; // Cannot delete, spots are occupied
        }
        
        $this->conn->beginTransaction();
        try {
            // Delete reservations first
            $delReservations = "DELETE FROM reservations WHERE spot_id IN (SELECT id FROM parking_spots WHERE lot_id = ?)";
            $stmt1 = $this->conn->prepare($delReservations);
            $stmt1->execute([$id]);
            
            // Delete spots
            $delSpots = "DELETE FROM parking_spots WHERE lot_id = ?";
            $stmt2 = $this->conn->prepare($delSpots);
            $stmt2->execute([$id]);
            
            // Delete lot
            $delLot = "DELETE FROM parking_lots WHERE id = ?";
            $stmt3 = $this->conn->prepare($delLot);
            $stmt3->execute([$id]);
            
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function getOccupiedSpots($lot_id) {
        $query = "SELECT COUNT(*) FROM parking_spots WHERE lot_id = ? AND status = 'O'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$lot_id]);
        return $stmt->fetchColumn();
    }

    public function getAvailableSpots($lot_id) {
        $query = "SELECT COUNT(*) FROM parking_spots WHERE lot_id = ? AND status = 'A'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$lot_id]);
        return $stmt->fetchColumn();
    }
}
?>