<?php
require_once __DIR__ . '/../config/bootstrap.php';
brewcart_start_session();

if (!empty($_SESSION['brewcart_admin_authenticated'])) {
    header('Location: index.php');
    exit;
}

if (empty($_SESSION['brewcart_admin_login_csrf'])) {
    $_SESSION['brewcart_admin_login_csrf'] = bin2hex(random_bytes(32));
}

$errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : '';
    $username = isset($_POST['username']) ? trim((string) $_POST['username']) : '';
    $password = isset($_POST['password']) ? (string) $_POST['password'] : '';
    $configuredUsername = (string) brewcart_env('ADMIN_USERNAME', '');
    $configuredHash = (string) brewcart_env('ADMIN_PASSWORD_HASH', '');

    $validCsrf = $csrfToken !== '' && hash_equals($_SESSION['brewcart_admin_login_csrf'], $csrfToken);
    $validUser = $configuredUsername !== '' && hash_equals($configuredUsername, $username);
    $validPassword = $configuredHash !== '' && password_verify($password, $configuredHash);

    if ($validCsrf && $validUser && $validPassword) {
        session_regenerate_id(true);
        $_SESSION['brewcart_admin_authenticated'] = true;
        $_SESSION['brewcart_admin_username'] = $configuredUsername;
        $_SESSION['brewcart_admin_csrf'] = bin2hex(random_bytes(32));
        unset($_SESSION['brewcart_admin_login_csrf']);
        header('Location: index.php');
        exit;
    }

    $errorMessage = ($configuredUsername === '' || $configuredHash === '')
        ? 'Admin login is not configured. Add ADMIN_USERNAME and ADMIN_PASSWORD_HASH to your local .env file.'
        : 'The username or password is incorrect. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrewCart Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <style>
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f6f5f7; font-family: Arial, sans-serif; }
        .login-card { width: 100%; max-width: 420px; padding: 32px; background: #fff; border-radius: 10px; box-shadow: 0 10px 28px rgba(0,0,0,.14); }
        .login-card h1 { margin-bottom: 24px; text-align: center; font-size: 26px; }
    </style>
</head>
<body>
    <main class="login-card">
        <h1>BrewCart Admin</h1>
        <?php if ($errorMessage !== ''): ?>
            <div class="alert alert-warning" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <form method="post" action="login.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['brewcart_admin_login_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" id="username" name="username" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" autocomplete="current-password" required>
            </div>
            <button class="btn btn-success btn-block" type="submit">Login</button>
            <a class="btn btn-link btn-block" href="../index.php">Back to BrewCart</a>
        </form>
    </main>
</body>
</html>
