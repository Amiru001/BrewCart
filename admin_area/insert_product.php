<?php
require_once __DIR__ . '/require_admin.php';
require_once __DIR__ . '/../config/database.php';

$con = brewcart_db();
$message = '';
$messageType = 'danger';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert_product'])) {
    $csrfToken = isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : '';
    $productTitle = trim(isset($_POST['product_title']) ? (string) $_POST['product_title'] : '');
    $productPrice = trim(isset($_POST['product_price']) ? (string) $_POST['product_price'] : '');

    if ($csrfToken === '' || !hash_equals($_SESSION['brewcart_admin_csrf'], $csrfToken)) {
        $message = 'The form expired. Please reload the page and try again.';
    } elseif ($productTitle === '' || strlen($productTitle) > 255 || !is_numeric($productPrice) || (float) $productPrice <= 0) {
        $message = 'Enter a valid product title and a price greater than zero.';
    } elseif (!isset($_FILES['product_image']) || $_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
        $message = 'Please select a valid product image.';
    } elseif ($_FILES['product_image']['size'] > 5 * 1024 * 1024) {
        $message = 'The image must be 5 MB or smaller.';
    } else {
        $temporaryFile = $_FILES['product_image']['tmp_name'];
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $fileInfo->file($temporaryFile);
        $allowedMimeTypes = array(
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp'
        );

        if (!isset($allowedMimeTypes[$mimeType]) || @getimagesize($temporaryFile) === false) {
            $message = 'Only valid JPG, PNG, or WebP image files are allowed.';
        } else {
            $extension = $allowedMimeTypes[$mimeType];
            $imageName = bin2hex(random_bytes(16)) . '.' . $extension;
            $uploadDirectory = __DIR__ . '/product_images/';
            $destination = $uploadDirectory . $imageName;

            if (!is_dir($uploadDirectory) || !is_writable($uploadDirectory) || !move_uploaded_file($temporaryFile, $destination)) {
                $message = 'The image could not be uploaded. Check the product_images folder permissions.';
            } else {
                try {
                    $price = (float) $productPrice;
                    $statement = $con->prepare('INSERT INTO products (product_title, product_price, product_image) VALUES (?, ?, ?)');
                    $statement->bind_param('sds', $productTitle, $price, $imageName);
                    $statement->execute();
                    $statement->close();
                    $message = 'Product added successfully.';
                    $messageType = 'success';
                } catch (Throwable $error) {
                    error_log('BrewCart product insert failed: ' . $error->getMessage());
                    if (is_file($destination)) {
                        unlink($destination);
                    }
                    $message = 'The product could not be saved. Check the database setup.';
                }
            }
        }
    }
}
?>

<!--connect file-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product-Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .form-control{ margin-bottom: 20px; }
        .text-center{ margin-bottom: 20px; }
        #product_image{ padding-bottom: 75px; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Products</h1>
        <?php if ($message !== ''): ?>
            <div class="alert alert-<?php echo htmlspecialchars($messageType, ENT_QUOTES, 'UTF-8'); ?>" role="alert">
                <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['brewcart_admin_csrf'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter Product title" autocomplete="off" maxlength="255" required>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product price</label>
                <input type="number" name="product_price" id="product_price" class="form-control" placeholder="Enter Product price" min="0.01" step="0.01" required>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image" class="form-label">Product image (JPG, PNG, WebP; max 5 MB)</label>
                <input type="file" name="product_image" id="product_image" class="form-control" accept="image/jpeg,image/png,image/webp" required>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3" value="Insert Product">
                <a class="btn btn-secondary mb-3 px-3" href="index.php">Back</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
