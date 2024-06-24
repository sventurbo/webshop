<?php
  require("connection.php");
  session_start();
  // Checkt ob Nutzer angemeldet ist, wenn ja, zurück zu store.php
  if(isset($_SESSION['email'])){
    header("Location: store.php");
    exit; }
  
  if(isset($_POST["submit"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stmt = $con->prepare("SELECT email,password,permission FROM users WHERE email=:email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $userExists = $stmt->fetchAll();
    // Check ob der Nutzer existiert
    if(!isset($userExists[0]["email"]) or $userExists[0]["email"] != $email){
      $errorMsg =  "Login fehlgeschlagen, Passwort oder Email stimmen nicht.";
    }
    // Überprüfung, ob Passwörter übereinstimmen
    if(isset($userExists[0]["password"])){
    $passwordHashed = $userExists[0]["password"];
    $checkPassword = password_verify($password, $passwordHashed);
      if($checkPassword === true){
        if($userExists[0]["permission"] === "admin"){
          $_SESSION["permission"] = $userExists[0]["permission"];
          $_SESSION["email"] = $userExists[0]["email"];
          header("Location: admin.php");
          exit;
          } else {        
            $_SESSION["email"] = $userExists[0]["email"];
            header("Location: store.php");
            exit;
            }
      } elseif($checkPassword === false){
          $errorMsg =  "Login fehlgeschlagen, Passwort oder Email stimmen nicht.";
        } else {
      $errorMsg =  "Login fehlgeschlagen, Passwort oder Email stimmen nicht.";
    }
  }
} 
  // Fehlercode 1, nichtautorisierter Zugriff
  if(isset($_GET['msg']) &&  $_GET['msg'] === "1"){
    $errorMsg = "Sie müssen sich zuerst anmelden, um diesen Inhalt einzusehen.";
  }
 ?>

<!doctype html>
<html lang="de" data-bs-theme="dark" data-lt-installed="true">
    <head>
        <title>Login</title>
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

          <div class="container col-xl-10 col-xxl-8 px-4 py-5">
            <div class="align-items-center g-lg-5 py-5">

              <div class="col-md-10 mx-auto col-lg-2">
                <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Login:</h1>
                <!-- <p class="col-lg-10 fs-4">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p> -->
              </div>
              <div class="col-md-10 mx-auto col-lg-5 mt-3">
                <form action="login.php" method="POST" class="row g-2 p-4 p-md-5 border rounded-3 bg-body-tertiary needs-validation was-validated" novalidate="" data-bitwarden-watching="1">
                    <!-- Feld für Fehlermeldungen -->
                    <?php if(isset($errorMsg)){ ?>
                    <div class="form-floating">
                      <div class="alert alert-danger" role="alert">
                        <?php echo($errorMsg); ?>
                        </div>
                      </div> <?php } ?>
                    <!-- Email Feld -->
                    <div class="form-floating mb-3" >
                      <input type="email" name="email"  class="form-control  is-invalid" id="floatingInput" placeholder="name@example.com" required="">
                      <label for="floatingInput">Email Adresse</label>
                    </div>
                    <!-- Passwort Feld -->
                    <div class="form-floating mb-3">
                      <input type="password" name="password"  class="form-control  is-invalid" id="floatingPassword" placeholder="Password" required="">
                      <label for="floatingPassword">Passwort</label>
                      <!-- Passwort zurücksetzen Link -->
                      <small class="text-body-secondary mt-4">Passwort vergessen? : <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="signup.php">Hier zurücksetzen.</a> </small>
                    </div>
                    <!-- Anmelden Button -->
                    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Anmelden</button>
                    <hr class="my-4">
                    <small class="text-body-secondary">Haben Sie noch kein Konto? : <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="signup.php">Registrieren</a> </small>
                </form>
              </div>     
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
