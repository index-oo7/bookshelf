<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- font awesome connection-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- bootstrap css connection -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!-- css connection -->
    <link rel="stylesheet" href="./style.css">

    <title>Home page</title>
</head>
<body>
    
    <!-- nav bar -->

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a id="logo" class="navbar-brand fa-fade" href="index.html">Bookshelf <sup>©</sup></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-evenly" id="navbarSupportedContent">
            
            <button type="button" class="btn btn-outline-dark">Add Book</button>

            <form id="searchBar" class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>

            <button type="button" class="btn btn-outline-dark">Sort</button>
          </div>
        </div>
    </nav>

    <div class="container col-8">
      <div class="row">
        <ul class="list-group list-group-flush">
        <li class="list-group-item">An item <br> <span class = "autor">Ivo andric</span></li>
        <li class="list-group-item">A second item<br> <span class = "autor"> </span></li>
        <li class="list-group-item">A third item<br> <span class = "autor"> </span></li>
        <li class="list-group-item">A fourth item<br> <span class = "autor"> </span></li>
        <li class="list-group-item">And a fifth one<br> <span class = "autor"> </span></li>
        </ul>
      </div>
    </div>

    <!-- js connection -->
    <script src="script.js"></script>

    <!-- bootstrap js connection -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>