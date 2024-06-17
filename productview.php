<?php
require("connection.php");
session_start();
 
 
 if (!isset($_SESSION['email'])) {
    header("Location: login.php?msg=1"); }


    $stmt = $con->prepare("SELECT title,description,price,img FROM products WHERE id = 1");
    $stmt->excecute();
    $productView = $stmt;





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

        

        


        <?php $row = $productView->fetch_assoc(); ?>
            <div class="text-bg-primary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 py-3">
                    <h2 class="display-5"><?= $row['title'] ?></h2>
                    <p class="lead"><?= $row['description'] ?></p>
                </div>
                <div class="bg-body-tertiary shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>















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
