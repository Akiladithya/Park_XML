<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'models/Car.php';

requireUser();

$database = new Database();
$db = $database->getConnection();
$car = new Car($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_car'])) {
        $new_car = trim($_POST['new_car'] ?? '');
        if (!empty($new_car)) {
            $car->user_id = $_SESSION['user_id'];
            $car->car_number = $new_car;
            if ($car->addCar()) {
                setFlashMessage('Car added successfully.', 'success');
            } else {
                setFlashMessage('Failed to add car.', 'danger');
            }
        }
    } elseif (isset($_POST['delete_car_id'])) {
        $car_id = $_POST['delete_car_id'];
        if ($car->deleteCar($car_id, $_SESSION['user_id'])) {
            setFlashMessage('Car removed.', 'info');
        }
    }
    redirect('user_profile.php');
}

$cars = $car->getUserCars($_SESSION['user_id']);
include 'templates/user_profile.php';
?>