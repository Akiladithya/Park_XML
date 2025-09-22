<?php
require_once 'config/database.php';

function initDatabase() {
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        die("Database connection failed");
    }

    // Create database if not exists
    try {
        $conn->exec("CREATE DATABASE IF NOT EXISTS parking_db");
        $conn->exec("USE parking_db");
        
        // Users table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'user') NOT NULL
            )
        ");

        // Cars table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS cars (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                car_number VARCHAR(50) NOT NULL,
                FOREIGN KEY(user_id) REFERENCES users(id)
            )
        ");

        // Parking lots table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS parking_lots (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                address TEXT NOT NULL,
                pin VARCHAR(10) NOT NULL,
                price_per_unit DECIMAL(10,2) NOT NULL,
                max_spots INT NOT NULL
            )
        ");

        // Parking spots table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS parking_spots (
                id INT AUTO_INCREMENT PRIMARY KEY,
                lot_id INT,
                status ENUM('A', 'O', 'R') NOT NULL DEFAULT 'A',
                FOREIGN KEY (lot_id) REFERENCES parking_lots(id)
            )
        ");

        // Reservations table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS reservations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                car_id INT,
                spot_id INT,
                status VARCHAR(20) NOT NULL,
                reserved_at DATETIME NOT NULL,
                entered_at DATETIME NULL,
                exited_at DATETIME NULL,
                total_cost DECIMAL(10,2) NULL,
                FOREIGN KEY(user_id) REFERENCES users(id),
                FOREIGN KEY(car_id) REFERENCES cars(id),
                FOREIGN KEY(spot_id) REFERENCES parking_spots(id)
            )
        ");

        // Create default admin users
        $hashedPassword = password_hash('first', PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute(['harish@admin.com']);
        if (!$stmt->fetch()) {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute(['Harish', 'harish@admin.com', $hashedPassword, 'admin']);
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute(['janani@admin.com']);
        if (!$stmt->fetch()) {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute(['Janani', 'janani@admin.com', $hashedPassword, 'admin']);
        }

        echo "✅ Database and tables created successfully!\n";
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

if (php_sapi_name() === 'cli') {
    initDatabase();
}
?>