<?php
//KONEKCIJA NA BAZU
  $database=mysqli_connect("localhost", "root", "", "homelib");
  mysqli_query($database, "SET NAMES utf8");

  // Provera konekcije sa bazom
  if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
  }

  session_start();
  if(isset($_SESSION['admin'])){


  }else{
      echo "Morate biti prijavljeni <br> <a href='./login/login.php'>Prijavite se ovde</a>";
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
          <a id="logo" class="navbar-brand fa-fade" href="indexAdmin.php">Bookshelf <sup>©</sup></a>

          <div class="collapse navbar-collapse justify-content-evenly" id="navbarSupportedContent">
            
            <!-- dodavanje knjige -->
            <button name="btnDodajKnjigu" id="btnDodajKnjigu" type="button" class="btn btn-outline-dark">Dodaj knjigu</button>

            <!-- izmena knjige -->
            <button name="btnIzmeniKnjigu" id="btnIzmeniKnjigu" type="button" class="btn btn-outline-dark">Izmeni knjigu</button>

            <!-- brisanje knjige -->
            <button name="btnObrisiKnjigu" id="btnObrisiKnjigu" type="button" class="btn btn-outline-dark">Obrisi knjigu</button>

           
            <!-- odjava -->
            <form method="post">
              <button name="odjava" id="odjava" type="submit" class="btn btn-outline-dark">Odjava</button>
            </form>
            <?php
              if(isset($_POST['odjava'])){
                session_unset();
                session_destroy();
                header("Location: login/login.php");
                exit();
              }
            ?>
          </div>
        </div>
    </nav>



    <!-- DODAVANJE KNJIGA -->

    <div id="dodavanjeKnjige" class="prozor">

      <!-- Forma za dodavanje knjiga u lokalnu bazu podataka -->
      <form id = "dodajForma">
          <label for="naziv">Naziv:</label>
          <input type="text" name="naziv" id="naziv" required><br><br>

          <label for="autor">Autor:</label>
          <input type="text" name="autor" id="autor" required><br><br>

          <label for="godinaIzdavanja">Godina izdavanja:</label>
          <input type="text" name="godinaIzdavanja" id="godinaIzdavanja" required><br><br>

          <label for="kategorija">Kategorija:</label>
          <input type="text" name="kategorija" id="kategorija" required><br><br>

          <input type="hidden" name="admin" id="admin" value="1">
          <!-- samo za test-->

          <button type="submit" name="btnDodaj" id="btnDodaj" value="submit" class="btn btn-outline-dark">Sačuvaj knjigu</button>
          
      </form> 

    </div> 

    <script>
      $(document).ready(function(){
          // Prikazivanje svih knjiga
          function prikaziKnjige() {
              $.post("./crud/prikaziKnjige.php", function(response){
              $("#prikazKnjiga").html(response);
            })
          }

          prikaziKnjige(); // Poziv funkcije za prikaz


        $("#dodajForma").submit(function(e){
          e.preventDefault();
          let naziv = $("naziv").val();
          let autor = $("autor").val();
          let godinaIzdavanja = $("godinaIzdavanja").val();
          let kategorija = $("kategorija").val();
          $.post("./crud/dodajKnjigu.php", {naziv: naziv, autor:autor, godinaIzdavanja:godinaIzdavanja, kategorija:kategorija}, function(response){
              $("#dodajForma input").val(""); // resetovanje input polja forme
              prikaziKnjige();
            })
        })
      })
      </script>


    <!-- PRIKAZ KNJIGA -->
      <div class="container col-12" id="prikazKnjiga"></div>
    


    <!-- IZMENA KNJIGE -->

      <div id="izmenaKnjige" class="prozor">

        <!-- Forma za izmenu knjiga u lokalnoj bazi podataka -->
        <form method="POST">

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

            <input type="hidden" name="admin" id="admin" value="1">
            <!-- umesto value=1 ce ici vrednost sesije u php tagovima -->
    

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
          $upit = "CALL IzmeniKnjigu('$naziv', '$autor', $godinaIzdavanja, '$kategorija', $izborIzmene)";
          mysqli_query($database, $upit);
          
          
        }

      
      ?>

    <!-- BRISANJE KNJIGE -->

      <div id="brisanjeKnjige" class="prozor">
        <form method="POST">
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
          $upit = "CALL ObrisiKnjigu($izborBrisanja)";
          mysqli_query($database, $upit);
        
          
        }
      ?>


    <!-- OTVARANJE DETALJA KNJIGE -->
      <script>
        $(document).ready(function () {
          $(".knjiga").click(function(){
            let idModal = $(this).attr("id");
            $.post("ajax.php?funkcija=modal", {idModal: idModal}, function(response){
                $("#prikazKnjiga").html(response);
              })
            })
          })

      </script>

    <!-- zatamljenje kada se otvara prozor -->
      <div id="pozadina"></div>

    <!-- konekcija JS fajla koji se bavi animacijama -->
      <script src="scriptAdmin.js"></script>

    <!-- konekcija bootrstrap-ovog JS-a -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

<?php
// ZATVARANJE BAZE
mysqli_close($database);
?>