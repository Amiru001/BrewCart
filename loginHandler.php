<?php
require_once __DIR__ . '/config/bootstrap.php';
require_once __DIR__ . '/config/database.php';
brewcart_start_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['btnSubmit1'])) {
    header('Location: login.html');
    exit;
}

$email = trim(isset($_POST['txtEmail']) ? (string) $_POST['txtEmail'] : '');
$password = isset($_POST['txtPassword']) ? (string) $_POST['txtPassword'] : '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
    header('Location: login.html?login=invalid');
    exit;
}

$con = brewcart_db();
try {
    $statement = $con->prepare('SELECT name, email, password FROM `user` WHERE email = ? LIMIT 1');
    $statement->bind_param('s', $email);
    $statement->execute();
    $statement->bind_result($name, $storedEmail, $storedPassword);
    $userFound = $statement->fetch();
    $statement->close();

    $passwordIsValid = false;
    if ($userFound) {
        $passwordIsValid = password_verify($password, (string) $storedPassword);

        // One-time migration for accounts created by the old plain-text version.
        if (!$passwordIsValid && hash_equals((string) $storedPassword, $password)) {
            $passwordIsValid = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $upgrade = $con->prepare('UPDATE `user` SET password = ? WHERE email = ?');
            $upgrade->bind_param('ss', $newHash, $storedEmail);
            $upgrade->execute();
            $upgrade->close();
        }
    }

    if (!$userFound || !$passwordIsValid) {
        header('Location: login.html?login=failed');
        exit;
    }

    session_regenerate_id(true);
    $_SESSION['brewcart_user_name'] = $name;
    $_SESSION['brewcart_user_email'] = $storedEmail;
    header('Location: index.php?login=success');
    exit;
} catch (Throwable $error) {
    error_log('BrewCart login failed: ' . $error->getMessage());
    header('Location: login.html?login=error');
    exit;
}
