<?php
require("connection.php");
session_start();

if (!isset($_SESSION['permission']) || $_SESSION['permission'] != 'admin') {
    header("Location: login.php?msg=1");
    exit();
}

// Neue Produkte hinzufügen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $img = $_POST['img'];

    $stmt = $con->prepare("INSERT INTO products (title, description, price, img) VALUES (:title, :description, :price, :img)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':img', $img);
    $stmt->execute();

    $_SESSION['message'] = "Produkt erfolgreich hinzugefügt!";
}

// Produkte bearbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $old_id = $_POST['old_id'];
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $img = $_POST['img'];

    $stmt = $con->prepare("UPDATE products SET id = :id, title = :title, description = :description, price = :price, img = :img WHERE id = :old_id");
    $stmt->bindParam(':old_id', $old_id);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':img', $img);
    $stmt->execute();

    $_SESSION['message'] = "Produkt erfolgreich bearbeitet!";
}

// Produkte löschen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];

    $stmt = $con->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $_SESSION['message'] = "Produkt erfolgreich gelöscht!";
}

$stmt = $con->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="de" data-bs-theme="dark" data-lt-installed="true">
<head>
    <title>Admin Panel</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<body>
    <header>
        <?php include('assets/templates/header.php'); ?>
    </header>
    <main>
        <div class="container py-5">
            <h1 class="display-4 mb-4">Admin Panel</h1>
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php } ?>
            <div class="accordion mb-4" id="addProductAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Neues Produkt hinzufügen
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#addProductAccordion">
                        <div class="accordion-body">
                            <form method="post" action="admin.php">
                                <input type="hidden" name="action" value="add">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Titel</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Beschreibung</label>
                                    <textarea class="form-control" id="description" name="description" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Preis</label>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                                </div>
                                <div class="mb-3">
                                    <label for="img" class="form-label">Bild-URL</label>
                                    <input type="text" class="form-control" id="img" name="img" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Hinzufügen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <h2>Produkte verwalten</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titel</th>
                            <th>Beschreibung</th>
                            <th>Preis</th>
                            <th>Bild</th>
                            <th>Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) { ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><?= $product['title'] ?></td>
                                <td><?= $product['description'] ?></td>
                                <td>€<?= number_format($product['price'], 2) ?></td>
                                <td><img src="<?= $product['img'] ?>" class="img-fluid" alt="..." width="100"></td>
                                <td>
                                    <!-- Bearbeiten-Formular -->
                                    <form method="post" action="admin.php" class="d-inline-block">
                                        <input type="hidden" name="action" value="edit">
                                        <input type="hidden" name="old_id" value="<?= $product['id'] ?>">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $product['id'] ?>">Bearbeiten</button>

                                        <!-- Bearbeiten-Modal -->
                                        <div class="modal fade" id="editModal<?= $product['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $product['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel<?= $product['id'] ?>">Produkt bearbeiten</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="id<?= $product['id'] ?>" class="form-label">ID</label>
                                                            <input type="number" class="form-control" id="id<?= $product['id'] ?>" name="id" value="<?= $product['id'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="title<?= $product['id'] ?>" class="form-label">Titel</label>
                                                            <input type="text" class="form-control" id="title<?= $product['id'] ?>" name="title" value="<?= $product['title'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description<?= $product['id'] ?>" class="form-label">Beschreibung</label>
                                                            <textarea class="form-control" id="description<?= $product['id'] ?>" name="description" required><?= $product['description'] ?></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="price<?= $product['id'] ?>" class="form-label">Preis</label>
                                                            <input type="number" class="form-control" id="price<?= $product['id'] ?>" name="price" step="0.01" value="<?= $product['price'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="img<?= $product['id'] ?>" class="form-label">Bild-URL</label>
                                                            <input type="text" class="form-control" id="img<?= $product['id'] ?>" name="img" value="<?= $product['img'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                                        <button type="submit" class="btn btn-primary">Speichern</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Löschen-Formular -->
                                    <form method="post" action="admin.php" class="d-inline-block">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                        <button type="submit" class="btn btn-danger">Löschen</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer>
        <?php include('assets/templates/footer.php'); ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>