<?php
class Car {
    private $conn;
    
    public $id;
    public $user_id;
    public $car_number;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addCar() {
        $query = "INSERT INTO cars (user_id, car_number) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->user_id, $this->car_number]);
    }

    public function getUserCars($user_id) {
        $query = "SELECT * FROM cars WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCar($car_id, $user_id) {
        $query = "DELETE FROM cars WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$car_id, $user_id]);
    }
}
?>