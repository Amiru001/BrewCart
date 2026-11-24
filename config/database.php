<?php
require_once __DIR__ . '/bootstrap.php';

function brewcart_db()
{
    static $connection = null;

    if ($connection instanceof mysqli) {
        return $connection;
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $connection = new mysqli(
            brewcart_env('DB_HOST', 'localhost'),
            brewcart_env('DB_USER', 'root'),
            brewcart_env('DB_PASSWORD', ''),
            brewcart_env('DB_NAME', 'brewcart'),
            (int) brewcart_env('DB_PORT', '3306')
        );
        $connection->set_charset('utf8mb4');
    } catch (Throwable $error) {
        error_log('BrewCart database connection failed: ' . $error->getMessage());
        http_response_code(500);
        exit('Database connection failed. Check your local .env database settings and make sure MySQL is running.');
    }

    return $connection;
}
