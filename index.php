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
                  
                  <p class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill mb-4 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-award-fill" viewBox="0 0 16 16">
                      <path d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864z"/>
                      <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1z"/>
                    </svg>
                    Schnelle Lieferung und top Qualität!</p>
                  
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
