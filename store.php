<?php
session_start();
require('connection.php');
 
if (isset($_SESSION['email'])) {

    $email = $_SESSION["email"];
    
    $stmt = $con->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    foreach ($result as $row) {

        $firstname = $row['firstname']; 
        $lastname = $row['name'];

    }

    $username = $firstname . ' ' . $lastname;

    echo <<<HTML
    <!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Popup Password Reset</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            #popupBox {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 300px;
                padding: 20px;
                background-color: #FFEAEB;
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

    <div id="overlay"></div>
    <div id="popupBox">
        <button class="close" onclick="closePopup()">&times;</button>
        <h2 style="color: black;">Wilkommmen $username!</h2>
        <p style="color: black">Der Shop öffnet in kürze.</p>
    </div>

    <script>
        function closePopup() {
            document.getElementById('popupBox').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function showPopup() {
            document.getElementById('popupBox').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        showPopup();

    </script>

    </body>
    </html>
    HTML;

} else {
    header("Location: login.php?msg=1");
}
?>

<!doctype html>
<html lang="de" data-bs-theme="dark" data-lt-installed="true">
    <head>
        <title>Produkte</title>
        <!-- Required meta tags -->
        <meta charset="UTF-8" />
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

        <style>
        /* Container styling */
        .product-container {
            width: 300px;
            padding: 15px;
            border-radius: 15px;
            background-color: #f2f2f2;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            float: left;
        }

        /* Image styling */
        .product-image {
            border-radius: 50%;
            max-width: 200px;
            height: auto;
            margin: 0 auto 15px;
            display: block;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        /* Title styling */
        .product-title {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        /* Button styling */
        .add-to-cart-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .add-to-cart-btn:hover {
            background-color: #45a049;
        }
    </style>

    </head>

    <body>
        <header>
        <?php include('assets\templates\header.php'); ?>
        </header>
        <main>
        
        <?php 
        require('connection.php');
            
            $stmt = $con->prepare("SELECT * FROM products");
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            foreach ($result as $row) {
        
                $image = $row['Image']; 
                $name = $row['name'];
                $alttext = $row['alttext'];
                $price = $row['price'];
        
                echo '<div class="product-container">';
                echo    '<img src="'.$image.'" alt="'.htmlspecialchars($alttext).'" class="product-image">';
                echo    '<h2 class="product-title">' . htmlspecialchars($name) . ' <span>' . htmlspecialchars($price) . '</span></h2>';
                echo    '<button class="add-to-cart-btn" onclick="addtocart()">Zum Warenkorb hinzufügen</button>';
                echo '</div>';
            }

            ?>
        
        </main>

        <footer>
            <?php include('assets\templates\footer.php'); ?>
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

<?php

function addtocart() {


}

?>
