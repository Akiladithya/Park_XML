<?php
require_once 'includes/session.php';

session_destroy();
setFlashMessage('Logged out successfully.', 'info');
redirect('login.php');
?>