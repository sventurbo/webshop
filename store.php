<?php
session_start();
 
 
 if (!isset($_SESSION['email'])) {
    header("Location: login.php?msg=1");
 }
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
        <?php include('header.php'); ?>
        </header>
        <main>

        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
            <div class="col-md-6 p-lg-5 mx-auto my-5">
            <h1 class="display-3 fw-bold">Designed for engineers</h1>
            <h3 class="fw-normal text-muted mb-3">Build anything you want with Aperture</h3>
            <div class="d-flex gap-3 justify-content-center lead fw-normal">
                <a class="icon-link" href="#">
                Learn more
                <svg class="bi"><use xlink:href="#chevron-right"></use></svg>
                </a>
                <a class="icon-link" href="#">
                Buy
                <svg class="bi"><use xlink:href="#chevron-right"></use></svg>
                </a>
            </div>
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>



            <div class="album py-5 bg-body-tertiary">
                <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    
            <?php for ($x = 0; $x < 6; $x++) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                    <img src="https://picsum.photos/800/400" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">                        <div class="card-body">
                        <p class="card-text">Beschreibung hier.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Ansehen</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Warenkorb</button>
                            </div>
                            <small class="text-body-secondary">Preis €€</small>
                        </div>
                        </div>
                    </div>
                    </div>
            <?php } ?>
                    </div>
                </div>
            </div>











        </main>
        <footer>
            <?php include('footer.php'); ?>
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
