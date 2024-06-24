<?php
require("connection.php");
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php?msg=1");
}

// Fetch all Products
$stmt = $con->prepare("SELECT id, title, description, price, img FROM products");
$stmt->execute();
$productList = $stmt;
$product = 0;

// Fetch newest product
$stmt = $con->prepare("SELECT id, title, description, price, img FROM products ORDER BY id DESC");
$stmt->execute();
$newest = $stmt;

if (isset($_GET["product"])) {
    $stmt2 = $con->prepare("SELECT id, title, description, price, img FROM products WHERE id = :productID");
    $stmt2->bindParam(':productID', $_GET["product"], PDO::PARAM_INT);
    $stmt2->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'addToShoppingCart') {
        $productID = $_POST['productID'];
        addToShoppingCart($productID, $con); // Pass $con to the function
    }
}

function addToShoppingCart($productID, $con) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION["email"];

        $stmt = $con->prepare("SELECT id FROM users WHERE email = :email"); // Get the user ID instead of email
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $userID = $result['id'];

            $stmt_check = $con->prepare("SELECT * FROM shoppingcart WHERE productID = :productID AND userID = :userID");
            $stmt_check->bindParam(':productID', $productID, PDO::PARAM_INT);
            $stmt_check->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt_check->execute();
            $existing_product = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($existing_product) {
                $newAmount = $existing_product['Amount'] + 1;
                $stmt_update = $con->prepare("UPDATE shoppingcart SET Amount = :newAmount WHERE productID = :productID AND userID = :userID");
                $stmt_update->bindParam(':newAmount', $newAmount, PDO::PARAM_INT);
                $stmt_update->bindParam(':productID', $productID, PDO::PARAM_INT);
                $stmt_update->bindParam(':userID', $userID, PDO::PARAM_INT);
                $stmt_update->execute();
            } else {
                $stmt = $con->prepare("INSERT INTO shoppingcart (productID, Amount, userID) VALUES (:productID, 1, :userID)");
                $stmt->bindParam(":productID", $productID, PDO::PARAM_INT);
                $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                $stmt->execute();
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "User not logged in.";
    }
}

function deleteshoppingcart($con) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION["email"];

        $stmt = $con->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $userID = $result['id'];

            $stmt_delete = $con->prepare("DELETE FROM shoppingcart WHERE userID = :userID");
            $stmt_delete->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt_delete->execute();
        } else {
            echo "User not found.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'deleteshoppingcart') {
        deleteshoppingcart($con);
    }
}
?>

<!doctype html>
<html lang="de" data-bs-theme="dark" data-lt-installed="true">
<head>
    <title>Produkte</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        #popupBox {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: #DCEDC8;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
            z-index: 1000;
        }
        #popupBox .close {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 20px;
            color: red;
            cursor: pointer;
        }
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <header>
        <?php include('assets/templates/header.php'); ?>
    </header>
    <main>
        <?php 
        if (isset($_GET["product"]) && $_GET["product"] != null && is_numeric($_GET["product"]) && $_GET["product"] > 0) {
            while ($product = $stmt2->fetch()) { ?>
                <div class="text-bg-white me-md-3 pt-3 pb-4 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                    <div class="my-3 py-3">
                        <h2 class="display-5"><?= $product['title'] ?></h2>
                        <p class="lead"><?= $product['description'] ?></p>
                    </div>
                    <div class="bg-body-tertiary shadow-sm mx-auto" style="width: 60%; border-radius: 21px 21px 21px 21px;">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-5">
                                <img src="<?= $product['img'] ?>" class="img-fluid rounded" alt="...">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $product['title'] ?></h5>
                                    <p class="card-text"><?= $product['description'] ?></p>
                                    <small class="text-success">Preis: €<?= $product['price'] ?></small>
                                    <div class="d-grid gap-2 d-md-block">
                                        <button class="btn btn-primary" type="button" onclick="addToCart(<?= $product['id'] ?>);">In den Warenkorb</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        } else { 
            $newest = $newest->fetch(); ?>
            <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
                <div class="col-md-6 p-lg-5 mx-auto my-5">
                    <h1 class="display-3 fw-bold">Neu im Sortiment: </h1>
                    <h3 class="fw-normal text-muted mb-3"><?= $newest['title'] ?></h3>
                    <div class="d-flex gap-3 justify-content-center lead fw-normal">
                        <a class="icon-link" href="?product=<?= $newest['id'] ?>">
                            Ansehen
                            <img src="assets/images/fanta.png" class="bi"><use xlink:href="#chevron-right"></use></img>
                        </a>
                        <a class="icon-link" href="?product=<?= $newest['id'] ?>">
                            Kaufen
                            <img src="assets/images/fanta.png" class="bi"><use xlink:href="#chevron-right"></use></img>
                        </a>
                    </div>
                </div>
                <div class="product-device shadow-sm d-none d-md-block"></div>
                <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
            </div>
            <div class="album py-5 bg-body-tertiary">
                <div class="container">
                    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-1">
                        <?php while ($productsDB = $productList->fetch()) {
                            $productID = $productsDB['id']; ?>
                            <div class="col">
                                <div class="card shadow-sm">
                                    <a href="?product=<?= $productsDB['id'] ?>"><img src="<?= $productsDB['img'] ?>" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy"></a>
                                    <div class="card-body">
                                        <h5 class="card-title"> <?= $productsDB['title'] ?> </h5>
                                        <p class="card-text"><?= $productsDB['description'] ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <a href="?product=<?= $productsDB['id'] ?>"><button class="btn btn-sm btn-primary">Ansehen</button></a>
                                                <button id="<?= $productsDB['id'] ?>" class="btn btn-sm btn-secondary" onclick="addToCart(<?= $productsDB['id'] ?>);">In den Warenkorb</button>
                                            </div>
                                            <small class="text-success"><?= $productsDB['price'] ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </main>
    <footer>
        <?php include('assets/templates/footer.php'); ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        window.addEventListener('beforeunload', function(event) {
            deleteshoppingcart();
        });

        function addToCart(productID) {
            $.ajax({
                url: 'store.php',
                type: 'POST',
                data: { action: 'addToShoppingCart', productID: productID },
                success: function(response) {
                    console.log('Product added to cart: ' + response);
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred: ' + status + ': ' + error);
                }
            });
        }
    </script>
</body>
</html>
