<?php
require_once __DIR__ . '/config/bootstrap.php';
require_once __DIR__ . '/config/database.php';
brewcart_start_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['btnSubmit'])) {
    header('Location: login.html');
    exit;
}

$name = trim(isset($_POST['txtName']) ? (string) $_POST['txtName'] : '');
$email = trim(isset($_POST['txtEmail']) ? (string) $_POST['txtEmail'] : '');
$password = isset($_POST['txtPassword']) ? (string) $_POST['txtPassword'] : '';
$confirmPassword = isset($_POST['txtConfimPassword']) ? (string) $_POST['txtConfimPassword'] : '';
$contact = trim(isset($_POST['txtContactNo']) ? (string) $_POST['txtContactNo'] : '');

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8 || $password !== $confirmPassword || !preg_match('/^[0-9+()\-\s]{7,20}$/', $contact)) {
    header('Location: login.html?registration=invalid');
    exit;
}

$con = brewcart_db();
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $statement = $con->prepare('INSERT INTO `user` (`name`, `email`, `password`, `contact`) VALUES (?, ?, ?, ?)');
    $statement->bind_param('ssss', $name, $email, $hashedPassword, $contact);
    $statement->execute();
    $statement->close();
    header('Location: login.html?registered=1');
    exit;
} catch (mysqli_sql_exception $error) {
    error_log('BrewCart registration failed: ' . $error->getMessage());
    if ((int) $error->getCode() === 1062) {
        header('Location: login.html?registration=exists');
    } else {
        header('Location: login.html?registration=error');
    }
    exit;
}
