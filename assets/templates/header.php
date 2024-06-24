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

<nav>
    <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z"/>
          </svg>
        </a>
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="store.php" class="nav-link px-2">Produkte</a></li>
        <?php 
        if (isset($_SESSION['permission']) || isset($_SESSION['permission']) == 'admin') { ?>
        <li><a href="admin.php" class="nav-link px-2">Admin Panel</a></li>
        <?php } ?>
      </ul>

      <div class="col-md-3 text-end">
        <?php if(!isset($_SESSION['email'])){?>
        <a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Anmelden</button></a>
        <a href="signup.php"><button type="button" class="btn btn-primary">Registrieren</button></a>
        <?php } else{ ?>
          <button type="button" class="btn btn-outline-success me-2" onclick="openCart()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
          <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"></path>
            </svg>
            Warenkorb
          </button>
          <a href="assets\templates\logout.php"><button type="button" class="btn btn-outline-danger me-2">Abmelden</button></a>
          <?php }?>
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