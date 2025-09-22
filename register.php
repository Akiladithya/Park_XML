<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Car.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $car_numbers = $_POST['car_numbers'] ?? [];
    
    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        setFlashMessage('Please fill in all required fields.', 'warning');
    } elseif (strlen($password) < 6) {
        setFlashMessage('Password must be at least 6 characters.', 'warning');
    } elseif (empty($car_numbers) || empty(array_filter($car_numbers))) {
        setFlashMessage('Please add at least one car number.', 'warning');
    } else {
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        
        // Check if email exists
        if ($user->emailExists($email)) {
            setFlashMessage('Email already registered.', 'warning');
        } else {
            // Register user
            $user->name = $name;
            $user->email = $email;
            $user->password = $password;
            $user->role = 'user';
            
            if ($user->register()) {
                // Get the new user ID
                $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user_id = $stmt->fetchColumn();
                
                // Add cars
                $car = new Car($db);
                $car->user_id = $user_id;
                
                foreach ($car_numbers as $car_number) {
                    $car_number = trim($car_number);
                    if (!empty($car_number)) {
                        $car->car_number = $car_number;
                        $car->addCar();
                    }
                }
                
                setFlashMessage('Registration successful! Please log in.', 'success');
                redirect('login.php');
            } else {
                setFlashMessage('Registration failed. Please try again.', 'danger');
            }
        }
    }
}

include 'templates/register.php';
?>