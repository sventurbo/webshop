     
<nav>
<style>
  .icon {
      cursor: pointer;
      position: relative;
  }

  .icon .count {
      position: absolute;
      top: -8px;
      right: -8px;
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 4px 8px;
      font-size: 12px;
      font-weight: bold;
      min-width: 18px;
      text-align: center;
  }
  </style>

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

                  echo '<span class="icon" onclick="openCart()" style="font-size: 40px">🛒</span>';

                } else {

                  echo '<a href="login.php?msg=0"><button type="button" class="btn btn-outline-primary me-2">Anmelden</button></a>';
                  echo '<a href="signup.php"><button type="button" class="btn btn-primary">Registrieren</button></a>';

                }

                ?>
      </div>
    </header>
  </div>
</nav>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
  function openCart() {

    window.location.href = 'shoppingcart.php';

  }
</script>

<script>
  let cartCount = 0;

  function addToCart() {

    cartCount++;
    UpdateCardCount(cartCount);

  }

  function UpdateCardCount(count) {

    const Icon = document.querySelector('.icon');
    let countElement = Icon.querySelector('.icon');

    if(countElement) {

    countElement.textcontent = count;

    } else {

      const countElement = document.createElement('span');
      countElement.classList.add('count');
      countElement.textContent =count;
      Icon.appendChild(countElement);


    }
  
  }

</script>

<script>
  function triggerPHPFunction(productID) {

    console.log("Here ... Script");
    console.log(productID);

      $.ajax({
        url: 'store.php',
        type: 'POST',
        data: { action: 'addToShoppingCart', productID: productID },
        success: function(response) {
            console.log('Response from server: ' + response);
        },
        error: function(xhr, status, error) {
            console.error('Error occurred: ' + status + ': ' + error);
        }
      });

  }
</script>