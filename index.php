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

    <title>Korisnik</title>
</head>
<body>
    
    <!-- nav bar -->

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

          <!-- logo -->
          <a id="logo" class="navbar-brand fa-fade" href="index.php">Bookshelf <sup>©</sup></a>

          <div class="collapse navbar-collapse justify-content-evenly" id="navbarSupportedContent">

            <!-- rezervacija knjige -->
            <button name="btnRezervisiKnjigu" id="btnRezervisiKnjigu" type="button" class="btn btn-outline-dark"  data-toggle="modal" data-target="#rezervacijaKnjige">Rezervisi knjigu</button>

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


  <!-- PRIKAZ KNJIGA -->
    <div class="container col-12" id="prikazKnjiga"></div>
    <script>
      $(document).ready(function(){
        // Prikaz knjiga
        function prikaziKnjige() {
            $.post("./crud/prikaziKnjige.php", function(response){
              $("#prikazKnjiga").html(response);
            });
          }

        prikaziKnjige(); // Poziv funkcije za prikaz
      })
    </script>

  <!-- REZERVISANJE KNJIGE -->
  <div class="modal fade" id="rezervacijaKnjige" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Rezervacija knjige</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="rezervisiKnjigu">
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
    
    <script>
      $(document).ready(function(){
        $("#rezervisiKnjigu").submit(function(e){
          let izborRezervacije = $("#izborRezervacije").val();
          $.post("./ajaxOperations/rezervacija.php",{izborRezervacije:izborRezervacije}, function(response){
            prikaziKnjige();  
            });
        })
      })
    </script>


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
              $.post("./ajaxOperations/pretraga.php?funkcija=pretraga", { terminPretrage: terminPretrage }, function(response) {
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
              $.post("./ajaxOperations/sortiranje.php?funkcija=sortirajPoKoloni", { kolona: kolona }, function(response) {
                  $("#prikazKnjiga").html(response);
                });
                
            }
              // po autoru
            if (kriterijum === "Autor") {
              let kolona = "AUTOR_KNJIGA";
              $.post("./ajaxOperations/sortiranje.php?funkcija=sortirajPoKoloni", { kolona: kolona }, function(response) {
                  $("#prikazKnjiga").html(response);
                });
            }
              // po kategoriji
            if (kriterijum === "Kategorija") {
              let kolona = "KATEGORIJA";
              $.post("./ajaxOperations/sortiranje.php?funkcija=sortirajPoKoloni", { kolona: kolona }, function(response) {
                  $("#prikazKnjiga").html(response);
                });
            }
              // dostupne knjige
            if (kriterijum === "Dostupno") {
              $.post("./ajaxOperations/sortiranje.php?funkcija=sortirajDostupno", function(response) {
                  $("#prikazKnjiga").html(response);
                });
            }
              // rezervisane
            if (kriterijum === "Rezervisano") {
              $.post("./ajaxOperations/sortiranje.php?funkcija=sortirajRezervisano", function(response) {
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