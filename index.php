<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- konekcija jquery -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    
    <!-- konekcija font awesome css-a -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- konekcija bootstrap-ovog css-a -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!-- konekcija css-a -->
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
            <button name="btnDodajKnjigu" id="btnDodajKnjigu" type="button" class="btn btn-outline-dark">Add Book</button>
            <!-- CLASS WINDOW IZ DEVSOCNET-A I QUERY KA BAZI -->

            <!-- pretraga -->
            <form id="searchBar" class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>
            <!-- PRETRAGA PREMA NAZIVU KNJIGE I AUTORU -->

            <!-- sortiranje -->
            <button type="button" class="btn btn-outline-dark">Sort</button>
            <!-- SORTIRANJE PREMA NAZIVU, AUTORU, DOSTUPNOSTI, KATEGORIJA -->
            <!-- AKO SORTIRAŠ PREMA DOSTUPNOSTI UKLJUČITI MOGUĆNOST REZERVACIJE. -->
          </div>
        </div>
    </nav>


    <div id="DodavanjeKnjige" class="prozor">

      <!-- Forma za dodavanje knjiga u lokalnu bazu podataka -->
      <form method="POST" action="index.php">
          <label for="naziv">Naziv:</label>
          <input type="text" name="naziv" id="naziv" required><br><br>

          <label for="autor">Autor:</label>
          <input type="text" name="autor" id="autor" required><br><br>

          <label for="godinaIzdavanja">Godina izdavanja:</label>
          <input type="godinaIzdavanja" name="godinaIzdavanja" id="godinaIzdavanja" required><br><br>

          <label for="kategorija">Kategorija:</label>
          <input type="kategorija" name="kategorija" id="kategorija" required><br><br>

          <button name="btnDodaj" id="btnDodaj" type="submit" class="btn btn-outline-dark">Add Book</button>
          
      </form> 

      <!-- PHP koji se bavi dodavanjem knjige u bazu podataka -->

      <?php
        // Povezivanje sa bazom podataka
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'homelib';

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        // Provera konekcije
        if ($conn->connect_error) {
            die("Greška prilikom povezivanja sa bazom podataka: " . $conn->connect_error);
        }

        // Obrada podataka iz forme
        if (isset($_POST['btnDodaj'])) {

            //Ucitati iz logina sesiju admina i to proslediti kao parametar ovde
            //(ako planiras da imas samo jednog admina nije neophodno, moze i hardcode)

            $admin = 1;
            $naziv = $_POST["naziv"];
            $autor = $_POST["autor"];
            $godinaIzdavanja = $_POST["godinaIzdavanja"];
            $kategorija = $_POST["kategorija"];


            //Ako id knjige pravi problem a nije autoinc, samo registrujes poslednji+1



            // Upit za dodavanje podataka u bazu
            $upit="INSERT INTO knjiga (ID_ADMIN, NAZIV_KNJIGA, AUTOR_KNJIGA, GODINA_IZDAVANJA_KNJIGA, KATEGORIJA) 
            VALUES ($admin, '$naziv', '$autor', $godinaIzdavanja, '$kategorija')";


            // $odgovor="";
            
            // $rez=mysqli_query($conn, $upit);
            // while($red=mysqli_fetch_assoc($rez))
            //     $odgovor.="<div>{$red['id']}: {$red['ime']} {$red['prezime']} ({$red['status']}) - <font color='red'>{$red['lozinka']}</font></div>";
            // echo $odgovor;


            
          }

        // Zatvaranje konekcije
        $conn->close();
      ?>


    </div>
   


    <!-- prikaz knjiga (ovo treba procitati iz baze) -->
    <div class="container col-8">
      <div class="row">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Na drini cuprija <br> <span class = "autor">Ivo andric</span></li>
          <li class="list-group-item">Travnicka hronika <br> <span class = "autor">Ivo andric</span></li>

      </div>
    </div>








    <!-- zatamljenje kada se otvara prozor -->
    <div id="pozadina"></div>

    <!-- konekcija JS-a -->
    <script src="script.js"></script>

    <!-- konekcija bootrstrap-ovog JS-a -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>