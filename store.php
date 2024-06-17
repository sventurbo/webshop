<?php
require("connection.php");
session_start();
 
 
 if (!isset($_SESSION['email'])) {
    header("Location: login.php?msg=1"); }


$stmt = $con->prepare("SELECT id,title,description,price,img FROM products");
$stmt->execute();
$products = $stmt;





?>

<!doctype html>
<html lang="de" data-bs-theme="dark" data-lt-installed="true">
    <head>
        <title>Produkte</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
        <?php include('assets/templates/header.php'); ?>
        </header>
        <main>

        <?php 
        $product = $_GET["product"];
        if($product === null){ ?>

        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
            <div class="col-md-6 p-lg-5 mx-auto my-5">
            <h1 class="display-3 fw-bold">Neu im Sortiment: </h1>
            <h3 class="fw-normal text-muted mb-3">Coca Cola 0,33l Dose</h3>
            <div class="d-flex gap-3 justify-content-center lead fw-normal">
                <a class="icon-link" href="#">
                Ansehen
                <img src="assets/images/fanta.png" class="bi"><use xlink:href="#chevron-right"></use></img>
                </a>
                <a class="icon-link" href="#">
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

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    
            <?php while($row = $products->fetch()) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                    <img src="<?= $row['img'] ?>" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
                    <div class="card-body">
                        <h5 class="card-title"> <?= $row['title'] ?> </h5>
                        <p class="card-text"><?= $row['description'] ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Ansehen</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Kaufen</button>
                            </div>
                            <small class="text-body-secondary"><?= $row['price'] ?></small>
                        </div>
                        </div>
                    </div>
                    </div>
            <?php } ?>
                    </div>
                </div>
            </div>

        <?php } 
        
        
        else { ?>
            <div class="text-bg-primary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 py-3">
                    <h2 class="display-5"><?= $productView['title'] ?></h2>
                    <p class="lead"><?= $productView['description'] ?></p>
                </div>
                <div class="bg-body-tertiary shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>
            <?php } ?>














        </main>
        <footer>
            <?php include('assets/templates/footer.php'); ?>
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
