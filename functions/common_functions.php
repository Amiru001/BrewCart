<?php
require_once __DIR__ . '/../config/database.php';

$con = brewcart_db();

/** Return the remote address supplied by the web server. */
function getIPAddress()
{
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
}

/** Escape values before inserting them into HTML. */
function brewcart_escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Render products using the existing product-card markup and CSS classes. */
function getproducts()
{
    global $con;

    try {
        $result = $con->query('SELECT product_id, product_title, product_price, product_image FROM products ORDER BY product_id DESC');
        while ($row = $result->fetch_assoc()) {
            $productId = (int) $row['product_id'];
            $productTitle = brewcart_escape($row['product_title']);
            $productPrice = brewcart_escape($row['product_price']);
            $productImage = rawurlencode(basename((string) $row['product_image']));

            echo "
                <div class='box'>
                    <img src='./admin_area/product_images/{$productImage}' alt='" . $productTitle . "'>
                    <h3>{$productTitle}</h3>
                    <div class='content'>
                        <span>Rs. {$productPrice}/=</span>
                        <a href='index.php?add_to_cart={$productId}'>Add to cart</a>
                    </div>
                </div>
            ";
        }
        $result->free();
    } catch (Throwable $error) {
        error_log('BrewCart product listing failed: ' . $error->getMessage());
        echo '<p>Products are temporarily unavailable.</p>';
    }
}

/** Handle the existing add-to-cart URL using parameterized SQL. */
function cart()
{
    global $con;

    if (!isset($_GET['add_to_cart'])) {
        return;
    }

    $productId = filter_var($_GET['add_to_cart'], FILTER_VALIDATE_INT);
    if ($productId === false || $productId < 1) {
        header('Location: index.php?cart=invalid#product');
        exit;
    }

    $ipAddress = getIPAddress();

    try {
        $productCheck = $con->prepare('SELECT product_id FROM products WHERE product_id = ? LIMIT 1');
        $productCheck->bind_param('i', $productId);
        $productCheck->execute();
        $productCheck->store_result();
        $productExists = $productCheck->num_rows === 1;
        $productCheck->close();

        if (!$productExists) {
            header('Location: index.php?cart=not_found#product');
            exit;
        }

        $cartCheck = $con->prepare('SELECT product_id FROM cart_details WHERE ip_address = ? AND product_id = ? LIMIT 1');
        $cartCheck->bind_param('si', $ipAddress, $productId);
        $cartCheck->execute();
        $cartCheck->store_result();
        $alreadyAdded = $cartCheck->num_rows > 0;
        $cartCheck->close();

        if ($alreadyAdded) {
            header('Location: index.php?cart=exists#product');
            exit;
        }

        $insert = $con->prepare('INSERT INTO cart_details (product_id, ip_address, quantity) VALUES (?, ?, 1)');
        $insert->bind_param('is', $productId, $ipAddress);
        $insert->execute();
        $insert->close();
        header('Location: index.php?cart=added#product');
        exit;
    } catch (Throwable $error) {
        error_log('BrewCart cart action failed: ' . $error->getMessage());
        header('Location: index.php?cart=error#product');
        exit;
    }
}

/** Output the number of cart rows for the current visitor. */
function cart_item()
{
    global $con;
    $ipAddress = getIPAddress();
    $count = 0;

    try {
        $statement = $con->prepare('SELECT COUNT(*) FROM cart_details WHERE ip_address = ?');
        $statement->bind_param('s', $ipAddress);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        $statement->close();
    } catch (Throwable $error) {
        error_log('BrewCart cart count failed: ' . $error->getMessage());
    }

    echo (int) $count;
}
