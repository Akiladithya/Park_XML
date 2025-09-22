<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/User.php';

if (isLoggedIn()) {
    if (isAdmin()) {
        redirect('admin_dashboard.php');
    } else {
        redirect('user_dashboard.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($email) && !empty($password)) {
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        
        if ($user->login($email, $password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_role'] = $user->role;
            
            setFlashMessage('Login successful!', 'success');
            
            if ($user->role === 'admin') {
                redirect('admin_dashboard.php');
            } else {
                redirect('user_dashboard.php');
            }
        } else {
            setFlashMessage('Invalid credentials.', 'danger');
        }
    } else {
        setFlashMessage('Please fill in all fields.', 'warning');
    }
}

include 'templates/login.php';
?>