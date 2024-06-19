     
<nav>
    <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
          <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="store.php" class="nav-link px-2">Produkte</a></li>
        <li><a href="#" class="nav-link px-2">#</a></li>
        <li><a href="#" class="nav-link px-2">#</a></li>
        <li><a href="#" class="nav-link px-2">#</a></li>
        <li><div class="dropdown">
            <a href="#" class="nav-link px-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown link</a>

            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
            </div></li>
      </ul>

      <div class="col-md-3 text-end">
      <?php
                $current_page = basename($_SERVER['PHP_SELF']);
                if ($current_page === 'store.php') {
                    echo '<span class="cart-icon" onclick="openCart()">🛒</span>';
                }
                ?>
        <a href="login.php?msg=0"><button type="button" class="btn btn-outline-primary me-2">Anmelden</button></a>
        <a href="signup.php"><button type="button" class="btn btn-primary">Registrieren</button></a>
      </div>
    </header>
  </div>
</nav>