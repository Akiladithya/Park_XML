<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function isUser() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        $_SESSION['flash_message'] = 'Permission denied.';
        $_SESSION['flash_type'] = 'danger';
        header('Location: login.php');
        exit();
    }
}

function requireUser() {
    requireLogin();
    if (!isUser()) {
        $_SESSION['flash_message'] = 'Permission denied.';
        $_SESSION['flash_type'] = 'danger';
        header('Location: login.php');
        exit();
    }
}

function setFlashMessage($message, $type = 'info') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

function redirect($url) {
    header("Location: $url");
    exit();
}
?>