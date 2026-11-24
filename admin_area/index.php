<?php
require_once __DIR__ . '/require_admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    
        <header>
            <a href="#" class="logo">
            <img src="../images/55.png" alt="" class="icon">
            </a>
            <div class="button">
                <a href="logout.php" class="login">LOGOUT</a>
            </div>
        </header>
    
        <section>
            
           
        </section>

        <section>
            <div class="row">
                <div class="col-md-12 bg-secondary  ">
                <div class="">
                    <h3 class="text-center h1 p-3"><b>Manage Details</b></h3>
                </div>
                    <div>
                        <a href="#" class="img"><img src="../images/Admin2.png" alt="" class="admin_img"></a>
                        <p class="text-light text-center">Admin Name</p>
                    </div>
                
                <div class="buttons">
                    <button class="button create"><a href="insert_product.php">Insert Product</a></button>
                    <button class="button read">Read</button>
                    <button class="button update">Update</button>
                    <button class="button delete">Delete</button>
                </div>
                </div>
            </div>
        </section>

    








    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>