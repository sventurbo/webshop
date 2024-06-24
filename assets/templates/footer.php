<footer class="mt-auto">

  <style>
    
      html {
    height: 100%;
  }
  body {
    min-height: 100%;
    display: flex;
    flex-direction: column;
  }
  .content {
    flex: 1;
  }

  </style>

  <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="store.php" class="nav-link px-2">Produkte</a></li>
        <?php 
        if (isset($_SESSION['permission']) || isset($_SESSION['permission']) == 'admin') { ?>
        <li><a href="admin.php" class="nav-link px-2">Admin Panel</a></li>
        <?php } ?>
  </ul>

  <ul class="nav justify-content-center">

    <li class="nav-item"><p class="nav-link px-2 text-body-secondary">© Webshop 2024</p></li>
    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Entwickelt mit &#x1F496;</a></li>

  </ul>

</footer>