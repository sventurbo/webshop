<?php
  require("connection.php");

  if(isset($_POST["submit"])){
    var_dump($_POST);

    $firstname = $_POST["firstname"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = PASSWORD_HASH($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $con->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $userAlreadyExists = $stmt->fetchColumn();

    if(!$userAlreadyExists){
      //Registrieren
      registerUser($firstname, $name, $email, $password);
    }
    else{
      //User existiert bereits
    }
  }

  function registerUser($firstname, $name, $email, $password){
    global $con;
    $stmt = $con->prepare("INSERT INTO users(firstname, name, email, password) VALUES (:firstname, :name, :email, :password)");
    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
    header("Location: index.php");
  }

 ?>

<!doctype html>
<html lang="de" data-bs-theme="dark" data-lt-installed="true">
    <head>
        <title>Webshop</title>
        <!-- Required meta tags -->
        <meta charset="utf-8"/>
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
        <link href="/custom.css" rel="stylesheet">
    </head>

    <body>
      <header>
        <?php include('assets/templates/header.php'); ?>
      </header>

            <main>
            <div class="px-4 pt-5 my-5 text-center border-bottom">
                <h1 class="display-4 fw-bold text-body-emphasis">Webshop</h1>
                <div class="col-lg-6 mx-auto">
                  <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum facilisis mi ac aliquet rutrum. Morbi eget nisi vitae justo consectetur ultricies. In interdum nulla leo, a convallis justo commodo nec. Maecenas faucibus dictum est. Cras ut odio aliquet, luctus felis quis, blandit sem.</p>
                  
                  <p class="badge bg-primary-subtle border border-priimary-subtle text-primary-emphasis rounded-pill mb-4 mt-2">Schnelle Lieferung und top Qualität!</p>
                  
                  <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                    <!-- <a href="#"><button type="button" class="btn btn-outline-secondary btn-lg px-4">XYZ</button></a> -->
                    <a href="store.php"><button type="button" class="btn btn-primary btn-lg px-4 me-sm-3">Entdecken Sie unsere Produkte</button></a>

                  </div>


                </div>
                <div class="overflow-hidden" style="max-height: 30vh;">
                  <div class="container px-5">
                    <img src="https://picsum.photos/800/800" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
                  </div>
                </div>
              </div>
            </div>

             
            <div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Ein Benutzerkonto bei uns macht vieles einfacher!</h1>
        <!-- <p class="col-lg-10 fs-4">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p> -->
      </div>


      <div class="col-md-10 mx-auto col-lg-5">
        <form action="signup.php" method="POST" class="row g-2 p-4 p-md-5 border rounded-3 bg-body-tertiary" data-bitwarden-watching="1">
        
        <div class="form-floating mb-3 col-md-6 position-relative">
            <input type="text" name="firstname" class="form-control" id="floatingInput" placeholder="Max">
            <label for="floatingInput">Vorname</label>
          </div>
          
          <div class="form-floating mb-3 col-md-6 position-relative">
            <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Mustermann">
            <label for="floatingInput">Nachname</label>
          </div>
          
          <div class="form-floating mb-3">
            <input type="email" name="email"  class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email Adresse</label>
          </div>
          
          <div class="form-floating mb-3">
            <input type="password" name="password"  class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Passwort</label>
          </div>
          
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Angemeldet bleiben
            </label>
          </div>
          <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Registrieren</button>
          <hr class="my-4">
          <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
        </form>
      </div>

    </div>
        <?php 
        session_start();
        //Hier ist code von Chrissi für Anzahl von sachen im Warenkorb die dann header angezeigt werden
        $result =getDb()->query($sql);
        $cartItems = 0;

        $userId = random_int(0,time());

        if(isset($_COOKIE['UserId'])){
          $userId = (int) $_COOKIE['userId'];

        }
        
        if(isset($_SESSION['UserId'])){
          $userId = (int) $_SESSION['userId'];

        }

        setcookie('userId',$userId,strtotime('+30 days'));
        
       

        $sql= "SELECT COUNT(id) FROM shoppingcart WHERE user_id =".$userId; 
        $cartResults = getDb()->query($sql);

        $cartItems = $cartResults->fetchColumn(); 

        ?>

                    


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
