<!doctype html>
<html lang="de" data-bs-theme="dark" data-lt-installed="true">
<head>
    <title>Passwort zurücksetzen</title>
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
        <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="align-items-center g-lg-5 py-5">
            <div class="align-items-center">
                <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3" style="text-align: center">Passwort Zurücksetzen</h1>
                <p>Gebe hier die E-Mail deines Benutzerkontos ein. Wir versenden im Anschluss eine E-Mail an dich, in welcher du dein Passwort zurücksetzen kannst. Alle weiteren Anweisungenk kannst du der E-Mail entnehmen.</p> 
            </div>
        </div>

        <form action="ResetPassword.php" method="POST">
            <div class="form-floating mb-3">
                    <input type="email" name="email"  class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email Adresse</label>
            </div>
            <button name="buttonResetPassword" class="w-10 btn btn-lg btn-primary" type="submit">Passwort zurücksetzen!</button>
        </form>

        </div>
    </main>
</body>
</html>

<?php

function sendmail() {
    
    require("connection.php");

    var_dump($_POST); 
    $email = $_POST["email"];
    $sUrl = "http://sventurbo.bplaced.net/ResetPassword.php";
    
    $stmt = $con->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    foreach ($result as $row) {
        $emailsql = $row['email'];
        $username = $row['name']; 
    }

    var_dump($emailsql);

    if($email == $emailsql) {

        $recipient = $emailsql;
        $subject = 'Passwort zurücksetzen';
        $message = '
                    <html>
                    <head>
                        <title>HTML Email</title>
                    </head>


                    <body>
                        <h1>Hallo, '. htmlspecialchars($username) .'! </h1>
                        <p>Du erhälst diese E-Mail, da du dein Passwort <b>zurücksetzen</b> möchtest. Wenn 		dies nicht der Fall sein sollte, kannst du diese E-Mail ignorieren.</p>
                        
                        <p> Klicke auf den Button, um ein neues Passwort zu vergeben.</p>
                        
                        <a href="' . htmlspecialchars($sUrl) . '" style="text-align: center; padding: 10px 20px; font-size: 16px; color: #ffffff; background-color: #007BFF; text-decoration: none; border-radius: 5px;">Passwort zurücksetzen</a>
                
                    </body>
                    </html>';
        $headers = 'From: webshop.team.informatik@gmail.com' . "\r\n" .
        'Reply-To: webshop.team.informatik@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        if (mail($recipient, $subject, $message, $headers)) {
            echo $recipient, $headers;
            
            echo <<<HTML
            <!DOCTYPE html>
            <html>
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
                        background-color: #f9f9f9;
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
                <h2 style="color: black">E-Mail versendet!</h2>
                <p style="color: black">Vergiss nicht deinen Spam Ordner zu checken.</p>
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
        
        }   else {
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
                <h2 style="color: red;" >Fehler!</h2>
                <p style="color: black">Die E-Mail konnte nicht versendet werden, bitte versuche es erneut oder kontaktiere uns!</p>
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

        }
    }   else {
        echo <<<HTML
        <!DOCTYPE html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Fehlermeldung E-Mail</title>
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
            <h2 style="color: red;" >Fehler!</h2>
            <p style="color:black;">Es existiert kein Account mit dieser E-Mail. Bitte überprüfe die Eingabe oder erstelle hier ein Nutzerkonto: </p>
            <a href="http://sventurbo.bplaced.net/signup.php"> Registrieren</a>
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
    }


    
}
    

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buttonResetPassword'])) {

    sendmail();

} 

?>