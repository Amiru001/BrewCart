<?php
require_once __DIR__ . '/../config/bootstrap.php';
brewcart_start_session();

if (empty($_SESSION['brewcart_admin_authenticated'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['brewcart_admin_csrf'])) {
    $_SESSION['brewcart_admin_csrf'] = bin2hex(random_bytes(32));
}
