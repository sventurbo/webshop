<?php
require("connection.php");
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php?msg=1");
    exit();
}

$email = $_SESSION['email'];

$stmt = $con->prepare("SELECT id FROM users WHERE email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

$userID = $user['id'];

$stmt = $con->prepare("SELECT p.id, p.title, p.description, p.price, p.img, s.Amount 
                        FROM products p 
                        JOIN shoppingcart s ON p.id = s.productID 
                        WHERE s.userID = :userID");
$stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
$stmt->execute();
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['Amount'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'updateAmount') {
        $productID = $_POST['productID'];
        $newAmount = $_POST['newAmount'];
        updateAmount($productID, $newAmount);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'deleteProduct') {
        $productID = $_POST['productID'];
        deleteProduct($productID);
    }
}

function updateAmount($productID, $newAmount) {
    global $con, $userID;

    $stmt = $con->prepare("UPDATE shoppingcart SET Amount = :newAmount WHERE productID = :productID AND userID = :userID");
    $stmt->bindParam(':newAmount', $newAmount, PDO::PARAM_INT);
    $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: shoppingcart.php");
    exit();
}

function deleteProduct($productID) {
    global $con, $userID;

    $stmt = $con->prepare("DELETE FROM shoppingcart WHERE productID = :productID AND userID = :userID");
    $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: shoppingcart.php");
    exit();
}
?>

<!doctype html>
<html lang="de" data-bs-theme="dark" data-lt-installed="true">
<head>
    <title>Warenkorb</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?php include('assets/templates/header.php'); ?>
    </header>
    <main>
        <div class="container py-5">
            <h1 class="display-4 mb-4">Ihr Warenkorb</h1>
            <?php if (count($cartItems) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Bild</th>
                                <th>Produkt</th>
                                <th>Preis</th>
                                <th>Menge</th>
                                <th>Gesamtpreis</th>
                                <th>Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item) { ?>
                                <tr>
                                    <td><a href="store.php?product=<?= $item['id'] ?>"><img src="<?= $item['img'] ?>" class="img-fluid" alt="..." width="100"></a></td>
                                    <td><table class="">
                                    <tr><td class="fw-bold text-primary"><a href="store.php?product=<?= $item['id'] ?>" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"><?= $item['title'] ?></a></td></tr>
                                    <tr><td><?= $item['description'] ?></td></a></tr>
                                    </table></td>
                                    <td>€<?= number_format($item['price'], 2) ?></td>
                                    <td>
                                        <form method="post" action="shoppingcart.php">
                                            <input type="hidden" name="action" value="updateAmount">
                                            <input type="hidden" name="productID" value="<?= $item['id'] ?>">
                                            <input type="number" name="newAmount" value="<?= $item['Amount'] ?>" min="1" class="form-control" style="width: 80px; display: inline;">
                                            <button type="submit" class="btn btn-primary btn-sm">Ändern</button>
                                        </form>
                                    </td>
                                    <td>€<?= number_format($item['price'] * $item['Amount'], 2) ?></td>
                                    <td>
                                        <form method="post" action="shoppingcart.php">
                                            <input type="hidden" name="action" value="deleteProduct">
                                            <input type="hidden" name="productID" value="<?= $item['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Entfernen</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-end">
                    <h4>Total: €<?= number_format($totalPrice, 2) ?></h4>
                </div>
            <?php } else { ?>
                <p class="lead">Ihr Warenkorb ist leer.</p>
            <?php } ?>
        </div>
    </main>
    <footer>
        <?php include('assets/templates/footer.php'); ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
