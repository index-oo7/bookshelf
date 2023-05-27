<?php
  $database=mysqli_connect("localhost", "root", "", "homelib");
  mysqli_query($database, "SET NAMES utf8");

  // Provera konekcije sa bazom
  if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
}

?>

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

            <!-- pretraga -->
            <form id="searchBar" class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" id="search" aria-label="Search">
              <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>
            <!-- PRETRAGA PREMA NAZIVU KNJIGE I AUTORU -->

            <!-- sortiranje -->
            <button name="btnSort" id="btnSort" type="button" onclick='prikaz()' class="btn btn-outline-dark">Sort</button>
            <!-- SORTIRANJE PREMA NAZIVU, AUTORU, DOSTUPNOSTI, KATEGORIJA -->
            <!-- AKO SORTIRAŠ PREMA DOSTUPNOSTI UKLJUČITI MOGUĆNOST REZERVACIJE. -->
          </div>
        </div>
    </nav>



    <!-- DODAVANJE KNJIGA -->

    <div id="dodavanjeKnjige" class="prozor">

      <!-- Forma za dodavanje knjiga u lokalnu bazu podataka -->
      <form method="POST" action="index.php">
          <label for="naziv">Naziv:</label>
          <input type="text" name="naziv" id="naziv" required><br><br>

          <label for="autor">Autor:</label>
          <input type="text" name="autor" id="autor" required><br><br>

          <label for="godinaIzdavanja">Godina izdavanja:</label>
          <input type="text" name="godinaIzdavanja" id="godinaIzdavanja" required><br><br>

          <label for="kategorija">Kategorija:</label>
          <input type="text" name="kategorija" id="kategorija" required><br><br>

          <input type="hidden" name="admin" id="admin" value="1">
          <!-- umesto value=1 ce ici vrednost sesije u php tagovima -->

          <button type="submit" name="btnDodaj" id="btnDodaj" value="submit" class="btn btn-outline-dark">Add Book</button>
          
      </form> 

    </div> 

    <?php

      if(isset($_POST['btnDodaj'])){
    
        //Kupimo vrednosti iz post zahteva
        $admin = $_POST['admin'];
        $naziv = $_POST['naziv'];
        $autor = $_POST['autor'];
        $godinaIzdavanja = $_POST['godinaIzdavanja'];
        $kategorija = $_POST['kategorija'];

        // Slanje upita za upis knjige u bazu
        $upit = "INSERT INTO knjiga (ID_ADMIN, NAZIV_KNJIGA, AUTOR_KNJIGA, GODINA_IZDAVANJA_KNJIGA, KATEGORIJA) 
        VALUES ({$admin}, '{$naziv}', '{$autor}', {$godinaIzdavanja}, '{$kategorija}')";
        mysqli_query($database, $upit);

        // Nakon kreiranja osvezava stranicu
        header("Location: index.php");
      }

    ?>


    <!-- PRIKAZ KNJIGA -->
    
    <div id="prikazKnjiga" class="container col-8">
        <div class="row">
        <ul class="list-group list-group-flush">
          
          <?php
  
            $odgovor="";
            $upit = 'SELECT * FROM knjiga';
            $rez = mysqli_query($database, $upit);
            while($red = mysqli_fetch_assoc($rez))
              $odgovor.="<li id='id{$red['ID_KNJIGA']}' class='list-group-item'>{$red['NAZIV_KNJIGA']}<br><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span><br></li>";
            echo $odgovor;

            ?>

      </div>
    </div>

    <script>
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 1. Dodati dugme za brisanje knjige
        // 2. Dodati dugme za izmenu knjige
        // 3. Dodati formu za izmenu knjige
        // 4. Dodati login/register stranicu + odjavu home page
        // 5. Dodati pretragu pojmova (imas vec ceo algoritam u pva zad5)
        // 6. Dodati sortiranje po select izboru (ChatGPT da uradi algoritam)
        // 7. Dodati info za svaku knjigu mogucnost rezervacije knjige
        //    - u info spada i to da li je knjiga trenutno dostupna ili ne, svakako rezervacija se pravi od prvog dostupnog dana.
        //    - ograniciti rezervaciju na mesec dana
        // 8. Smisliti kako da prosledis ID knjige ukoliko ispisujes dugmad za brisanje i izmenu u sklopu ispisa info o knjizi.
    </script>


    <!-- zatamljenje kada se otvara prozor -->
    <div id="pozadina"></div>

    <!-- konekcija JS fajla koji se bavi animacijama -->
    <script src="script.js"></script>

    <!-- konekcija bootrstrap-ovog JS-a -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// ZATVARANJE BAZE
mysqli_close($database);
?>