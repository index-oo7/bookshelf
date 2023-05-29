<?php
  $database=mysqli_connect("localhost", "root", "", "homelib");
  mysqli_query($database, "SET NAMES utf8");

  // Provera konekcije sa bazom
  if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
}

session_start();
if(isset($_SESSION['korisnik'])){

}else{
  echo "Morate biti prijavljeni";
  exit();
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
          <a id="logo" class="navbar-brand fa-fade" href="index.php">Bookshelf <sup>©</sup></a>

          <div class="collapse navbar-collapse justify-content-evenly" id="navbarSupportedContent">
            
            <!-- dodavanje knjige -->
            <button name="btnDodajKnjigu" id="btnDodajKnjigu" type="button" class="btn btn-outline-dark">Dodaj knjigu</button>

            <!-- izmena knjige -->
            <button name="btnIzmeniKnjigu" id="btnIzmeniKnjigu" type="button" class="btn btn-outline-dark">Izmeni knjigu</button>

            <!-- brisanje knjige -->
            <button name="btnObrisiKnjigu" id="btnObrisiKnjigu" type="button" class="btn btn-outline-dark">Obrisi knjigu</button>

            <!-- rezervacija knjige -->
            <button name="btnRezervisiKnjigu" id="btnRezervisiKnjigu" type="button" class="btn btn-outline-dark">Rezervisi knjigu</button>

            <!-- pretraga -->
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" name="pretraga" id="pretraga" aria-label="Search">
              <div id="rezultatiPretrage"></div>
              <button class="btn btn-outline-dark" type="submit" name="btnPretrazi" id="btnPretrazi">Search</button>
            </form>

            <!-- sortiranje -->
            <div class="dropdown">
              <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" name="btnSortiranje" id="btnSortiranje">
                Sortiraj
              </button>
                <ul class="dropdown-menu" name="sortiranje" id="sortiranje">
                  <li id="sortNaziv"><a class="dropdown-item">Naziv</a></li>
                  <li id="sortAutor"><a class="dropdown-item">Autor</a></li>
                  <li id="sortKategorija"><a class="dropdown-item">Kategorija</a></li>
                  <li id="sortDostupno"><a class="dropdown-item">Dostupno</a></li>
                  <li id="sortRezervisano"><a class="dropdown-item">Rezervisano</a></li>
                </ul>
            </div>

            <form method="post" action="index.php">
            <button name="odjava" id="odjava">Odjava</button>
            <!-- odjava -->
            </form>
            <?php
              if(isset($_POST['odjava'])){
                session_unset();
                session_destroy();
                header("Location: login/login.php");
              }
            ?>

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
          

          <button type="submit" name="btnDodaj" id="btnDodaj" value="submit" class="btn btn-outline-dark">Sačuvaj knjigu</button>
          
      </form> 

    </div> 

    <?php

      if(isset($_POST['btnDodaj'])){
    
        //Kupimo vrednosti iz post zahteva
        $admin = $_SESSION['prijava'];
        $naziv = $_POST['naziv'];
        $autor = $_POST['autor'];
        $godinaIzdavanja = $_POST['godinaIzdavanja'];
        $kategorija = $_POST['kategorija'];

        // Slanje upita za upis knjige u bazu
        $upit = "INSERT INTO knjiga (ID_ADMIN, NAZIV_KNJIGA, AUTOR_KNJIGA, GODINA_IZDAVANJA_KNJIGA, KATEGORIJA) 
        VALUES ({$admin}, '{$naziv}', '{$autor}', {$godinaIzdavanja}, '{$kategorija}')";
        mysqli_query($database, $upit);

        
      }

    ?>

    <!-- PRIKAZ KNJIGA -->
    
    <div class="container col-8">
        <div class="row">
        <ul class="list-group list-group-flush" id="prikazKnjiga" > 

          <?php
  
            $odgovor="";
            $upit = 'SELECT * FROM knjiga';
            $rez = mysqli_query($database, $upit);
            while($red = mysqli_fetch_assoc($rez))
              $odgovor.="<li class='list-group-item'>{$red['NAZIV_KNJIGA']}<br><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span><br></li>";
            echo $odgovor;

            ?>

        </ul>
      </div>
    </div>



    <!-- IZMENA KNJIGE -->

    <div id="izmenaKnjige" class="prozor">

      <!-- Forma za izmenu knjiga u lokalnoj bazi podataka -->
      <form method="POST" action="index.php">

        <select name="izborIzmene" id="izborIzmene">
          <?php
            $odgovor="";
            $upit = 'SELECT * FROM knjiga';
            $rez = mysqli_query($database, $upit);
            while($red = mysqli_fetch_assoc($rez))
              $odgovor.="<option value='{$red['ID_KNJIGA']}'>{$red['NAZIV_KNJIGA']}</option>";
            echo $odgovor;
          ?>
        </select>


        <!-- Forma u kojoj treba uneti podatke za izmenu -->
        <h3>Ovde unesite izmene:</h3>

        <label for="naziv">Naziv:</label>
          <input type="text" name="naziv" id="naziv"><br><br>

          <label for="autor">Autor:</label>
          <input type="text" name="autor" id="autor"><br><br>

          <label for="godinaIzdavanja">Godina izdavanja:</label>
          <input type="text" name="godinaIzdavanja" id="godinaIzdavanja"><br><br>

          <label for="kategorija">Kategorija:</label>
          <input type="text" name="kategorija" id="kategorija"><br><br>
          
  

        <button type="submit" name="btnIzmeni" id="btnIzmeni" value="submit" class="btn btn-outline-dark">Sačuvaj izmene</button>
          
      </form> 

    </div> 

    <?php

      if(isset($_POST['btnIzmeni'])){

        //Kupimo vrednosti iz post zahteva
        $izborIzmene = $_POST['izborIzmene'];
        $naziv = $_POST['naziv'];
        $autor = $_POST['autor'];
        $godinaIzdavanja = $_POST['godinaIzdavanja'];
        $kategorija = $_POST['kategorija'];

        
        // Slanje upita za upis knjige u bazu
        $upit = "UPDATE knjiga 
        SET NAZIV_KNJIGA = '{$naziv}', AUTOR_KNJIGA = '{$autor}', GODINA_IZDAVANJA_KNJIGA = '{$godinaIzdavanja}', KATEGORIJA = '{$kategorija}'
        WHERE ID_KNJIGA = '{$izborIzmene}' ";
        mysqli_query($database, $upit);
        
        
      }

    
    ?>

    <!-- BRISANJE KNJIGE -->

    <div id="brisanjeKnjige" class="prozor">
      <form method="POST" action="index.php">
        <h3>Ovde izaberite koju knjigu zelite da obrišete:</h3>
        <select name="izborBrisanja" id="izborBrisanja">
          <?php
            $odgovor="";
            $upit = 'SELECT * FROM knjiga';
            $rez = mysqli_query($database, $upit);
            while($red = mysqli_fetch_assoc($rez))
              $odgovor.="<option value='{$red['ID_KNJIGA']}'>{$red['NAZIV_KNJIGA']}</option>";
            echo $odgovor;
          ?>

        </select><br><br>
        
        <button type="submit" name="btnObrisi" id="btnObrisi" value="submit" class="btn btn-outline-dark">Obriši knjigu</button>

      </form>

    </div>

    <?php
      if(isset($_POST['btnObrisi'])){

        //Kupimo vrednosti iz post zahteva
        
        $izborBrisanja = $_POST['izborBrisanja'];

        // Slanje upita za upis knjige u bazu
        $upit = "DELETE FROM knjiga
        WHERE ID_KNJIGA = '$izborBrisanja'";
        mysqli_query($database, $upit);
       
        
      }
    ?>

    <!-- REZERVISANJE KNJIGE -->

    <div id="rezervacijaKnjige" class="prozor">
    <form method="POST" action="index.php">
        <h3>Ovde izaberite koju knjigu zelite da rezervišete:</h3>
        <select name="izborRezervacije" id="izborRezervacije">
          <?php
            $odgovor="";

            //prikaz samo dostupnih knjiga
            $upit = "SELECT * FROM knjiga WHERE ID_KNJIGA NOT IN (SELECT ID_KNJIGA FROM rezervacija)";
            $rez = mysqli_query($database, $upit);
            while($red = mysqli_fetch_assoc($rez))
              $odgovor.="<option value='{$red['ID_KNJIGA']}'>{$red['NAZIV_KNJIGA']}</option>";
            echo $odgovor;
          ?>

        </select><br><br>
        
        <p>Rezervacija traje 5 dana od trenutka rezervisanja.</p>


        <button type="submit" name="btnRezervisi" id="btnRezervisi" value="submit" class="btn btn-outline-dark">Rezerviši knjigu</button>


      </form>
    </div>
    <?php
    
  //   // Provera konekcije sa bazom
  //   if (!$database) {
  //     die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
  //    }

  //     if(isset($_POST['btnRezervisi']) and isset($_POST['izborRezervacije'])){

  //       $idKnjiga = $_POST['izborRezervacije'];
  //       $idKorisnik = 1;//sesija korisnika

  //       // formiranje datuma za pocetak i kraj rezervacije
  //       $pocetakRezervacije = strtotime("now");
  //       $krajRezervacije = $pocetakRezervacije + (24*60*60*5);

  //       $pocetak = date("Y-m-d H:i:s", $pocetakRezervacije);
  //       $kraj = date("Y-m-d H:i:s", $krajRezervacije);

      
  //       // Provera da li se id_knjiga nalazi u tabeli rezervacija
  //       $upit = "SELECT * FROM rezervacija WHERE id_knjiga = $id_knjiga";

  //       $rezultat = mysqli_query($database, $upit);

  //       if (mysqli_num_rows($rezultat) > 0) {
  //           // Id_knjiga se nalazi u tabeli rezervacija
            
  //           return;
            
  //       } else {
  //         $upit = "INSERT INTO rezervacija (ID_KORISNIK, ID_KNJIGA, POCETAK_REZERVACIJA, KRAJ_REZERVACIJA)
  //         VALUES ($idKorisnik, $idKnjiga, '$pocetak', '$kraj')";

  //         // Izvršavanje upita
  //         mysqli_query($database, $upit);
  //       }
  //     }
    ?>


    <script>
      

      $(document).ready(function () {
        // PRETRAGA

        function pozicijaRezultataPretrage() {
          var searchInputOffset = $("#pretraga").offset();
          var searchInputHeight = $("#pretraga").outerHeight();
          $("#rezultatiPretrage").css({
            top: searchInputOffset.top + searchInputHeight + 5,
            left: searchInputOffset.left,
            width: $("#pretraga").outerWidth()
          });
        }

          $(window).resize(function() {
            pozicijaRezultataPretrage();
          });

          $("#pretraga").on("input", function() {
            var terminPretrage = $(this).val();
            if (terminPretrage.length >= 2) {
              $.post("ajax.php?funkcija=pretraga", { terminPretrage: terminPretrage }, function(response) {
                $("#rezultatiPretrage").html(response);
              });
            } else {
              $("#rezultatiPretrage").empty();
            }
          });

          pozicijaRezultataPretrage();


          // SORTIRANJE

          $("#sortiranje li").click(function() {
          // Izbor korisnika (tekst stavke koju je kliknuo)
          var kriterijum = $(this).text();
          
            // po nazivu
          if (kriterijum === "Naziv") {
            let kolona = "NAZIV_KNJIGA";
            $.post("ajax.php?funkcija=sortirajPoKoloni", { kolona: kolona }, function(response) {
                $("#prikazKnjiga").html(response);
              });
              
          }
            // po autoru
          if (kriterijum === "Autor") {
            let kolona = "AUTOR_KNJIGA";
            $.post("ajax.php?funkcija=sortirajPoKoloni", { kolona: kolona }, function(response) {
                $("#prikazKnjiga").html(response);
              });
          }
            // po kategoriji
          if (kriterijum === "Kategorija") {
            let kolona = "KATEGORIJA";
            $.post("ajax.php?funkcija=sortirajPoKoloni", { kolona: kolona }, function(response) {
                $("#prikazKnjiga").html(response);
              });
          }
            // dostupne knjige
          if (kriterijum === "Dostupno") {
            $.post("ajax.php?funkcija=sortirajDostupno", function(response) {
                $("#prikazKnjiga").html(response);
              });
          }
            // rezervisane
          if (kriterijum === "Rezervisano") {
            $.post("ajax.php?funkcija=sortirajRezervisano", function(response) {
                $("#prikazKnjiga").html(response);
              });
          }

        });

      })
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