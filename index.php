<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jquery connection -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    
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

        <!-- logo -->
          <a id="logo" class="navbar-brand fa-fade" href="index.html">Bookshelf <sup>©</sup></a>

          <div class="collapse navbar-collapse justify-content-evenly" id="navbarSupportedContent">
            
            <!-- dodavanje knjige -->
            <button name="btnAdd" id="btnAdd" type="button" class="btn btn-outline-dark">Add Book</button>
            <!-- CLASS WINDOW IZ DEVSOCNET-A I QUERY KA BAZI -->

            <!-- pretraga -->
            <form id="searchBar" class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>
            <!-- PRETRAGA PREMA NAZIVU KNJIGE I AUTORU -->

            <!-- sortiranje -->
            <button type="button" class="btn btn-outline-dark">Sort</button>
            <!-- SORTIRANJE PREMA NAZIVU, AUTORU, DOSTUPNOSTI, KATEGORIJA, REJTING -->
            <!-- AKO SORTIRAŠ PREMA DOSTUPNOSTI UKLJUČITI MOGUĆNOST REZERVACIJE. -->
          </div>
        </div>
    </nav>


    <div id="adding" class="window">
      <form method="POST" action="index.php">
          <label for="naziv">Naziv:</label>
          <input type="text" name="naziv" id="naziv" required><br><br>

          <label for="autor">Autor:</label>
          <input type="text" name="autor" id="autor" required><br><br>

          <label for="brStrana">Broj strana:</label>
          <input type="brStrana" name="brStrana" id="brStrana" required><br><br>

          <input type="submit" value="Dodaj podatke">
      </form> 

      <!-- PHP that handles adding book into the database -->

      <?php
        
      ?>


    </div>
   


    <!-- prikaz knjiga (ovo treba procitati iz baze) -->
    <div class="container col-8">
      <div class="row">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">An item <br> <span class = "autor">Ivo andric</span></li>
      </div>
    </div>






    <!-- zatamljenje kada se otvara prozor -->
    <div id="background"></div>

    <!-- js connection -->
    <script src="script.js"></script>

    <!-- bootstrap js connection -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>