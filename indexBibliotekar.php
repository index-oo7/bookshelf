<?php
    session_start();
    if($_SESSION['uloga'] != '2'){
      header("Location: ./login/login.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- konekcija css-a -->
    <link rel="stylesheet" href="./style.css">

    <title>Bibliotekar</title>
</head>
<body>
    
    <!-- nav bar -->
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">

            <!-- logo -->
            <a id="logo" class="navbar-brand fa-fade" href="indexBibliotekar.php">Bookshelf <sup>©</sup></a>

            <div class="collapse navbar-collapse justify-content-evenly" id="navbarSupportedContent">
              
              <p class="ime"><?php echo $_SESSION['korime'];?></p>

              <!-- dodavanje knjige -->
              <button name="btnDodajKnjigu" id="btnDodajKnjigu" type="button" class="btn btn-outline-dark">Dodaj knjigu</button>

              <!-- izmena knjige -->
              <button name="btnIzmeniKnjigu" id="btnIzmeniKnjigu" type="button" class="btn btn-outline-dark">Izmeni knjigu</button>

              <!-- brisanje knjige -->
              <button name="btnObrisiKnjigu" id="btnObrisiKnjigu" type="button" class="btn btn-outline-dark">Obrisi knjigu</button>
              
              <!-- Rezervacije knjiga -->
              <button name="btnRezervacija" id="btnRezervacija" type="button" class="btn btn-outline-dark">Rezervacije</button>
            
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
      <div class="container col-12" id="prikazKnjiga"></div><br><br>
      <div class="container col-12" id="prikazZaduzenja"></div>

    
    <!-- DODAVANJE KNJIGA -->
      <div class="modal fade" id="dodavanjeKnjige" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <!-- Forma za dodavanje knjiga u lokalnu bazu podataka -->
              <form id = "dodajForma" enctype = "multipart/form-data">
                  <label for="naziv">Naziv:</label>
                  <input type="text" name="naziv" id="naziv" required><br><br>

                  <label for="autor">Autor:</label>
                  <input type="text" name="autor" id="autor" required><br><br>

                  <label for="godinaIzdavanja">Godina izdavanja:</label>
                  <input type="number" name="godinaIzdavanja" id="godinaIzdavanja" required><br><br>

                  <label for="kategorija">Kategorija:</label>
                  <input type="text" name="kategorija" id="kategorija" required><br><br>

                  <label for="stanje">Stanje:</label>
                  <input type="number" name="stanje" id="stanje" required><br><br>

                  <label for="slika">Slika:</label>
                  <input type="file" name="slika" id="slika" accept="image/*" required><br><br>

                  <button type="submit" name="btnDodaj" id="btnDodaj" value="submit" class="btn btn-outline-dark">Sačuvaj knjigu</button>
                  
              </form> 
            </div>
          </div>
        </div>
      </div>

    <!-- IZMENA KNJIGE -->
      <div class="modal fade" id="izmenaKnjige" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <!-- Forma za izmenu knjiga u lokalnoj bazi podataka -->
                  <form id="izmeniForma" enctype = "multipart/form-data">

                  <select name="izborIzmene" id="izborIzmene"></select>


                    <!-- Forma u kojoj treba uneti podatke za izmenu -->
                    <h3>Ovde unesite izmene:</h3>

                    <label for="naziv">Naziv:</label>
                      <input type="text" name="izmeniNaziv" id="izmeniNaziv"><br><br>

                      <label for="autor">Autor:</label>
                      <input type="text" name="izmeniAutor" id="izmeniAutor"><br><br>

                      <label for="godinaIzdavanja">Godina izdavanja:</label>
                      <input type="text" name="izmeniGodinaIzdavanja" id="izmeniGodinaIzdavanja"><br><br>

                      <label for="kategorija">Kategorija:</label>
                      <input type="text" name="izmeniKategorija" id="izmeniKategorija"><br><br>

                      <label for="stanje">Stanje:</label>
                      <input type="text" name="izmeniStanje" id="izmeniStanje"><br><br>

                      <label for="slika">Slika:</label>
                      <input type="file" name="izmeniSlika" id="izmeniSlika" accept="image/*"><br><br>


                    <button type="submit" name="btnIzmeni" id="btnIzmeni" value="submit" class="btn btn-outline-dark">Sačuvaj izmene</button>
                      
              </form>
              
            </div>
          </div>
        </div>
      </div>

    <!-- BRISANJE KNJIGE  -->
      <div class="modal fade" id="brisanjeKnjige" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <form id="obrisiForma">
                <h3>Ovde izaberite koju knjigu zelite da obrišete:</h3>
                <select name="izborBrisanja" id="izborBrisanja"></select><br><br>
                  
                <button type="submit" name="btnObrisi" id="btnObrisi" value="submit" class="btn btn-outline-dark">Obriši knjigu</button>

              </form>
            </div>
          </div>
        </div>
      </div>
          
    <script>
        // funkcije
        function prikaziRezervacije() {
                $.post("./crud/prikaziRezervacije.php", function(response){
                $("#prikazKnjiga").html(response);
              });
            }

        function prikaziZaduzenja() {
              $.post("./crud/prikaziZaduzenja.php", function(response){
              $("#prikazZaduzenja").html(response);
            });
          }
        

        
        // Definisanje klika na elemente s klasom "knjiga"
          $(document).on('click', '.knjiga', function() {
                let idModal = this.id;
                $.post("./ajaxOperations/detaljiKnjiga.php", {idModal: idModal}, function(response){
                    $("#prikazKnjiga").html(response);
                });
            });

        //Zaduzivanje knjige
          $(document).on('click', '.zaduzi', function() {
                let idRezervacije = this.id;
                $.post("./ajaxOperations/zaduzenje.php", {idRezervacije: idRezervacije}, function(response){
                  prikaziRezervacije();
                  prikaziZaduzenja();
                });
            });
          
        //Razduzivanje knjige
          $(document).on('click', '.razduzi', function() {
                let idZaduzenja = this.id;
                $.post("./ajaxOperations/razduzenje.php", {idZaduzenja: idZaduzenja}, function(response){
                  prikaziRezervacije();
                  prikaziZaduzenja();
                });
            });

        $(document).ready(function(){

        // PRIKAZ KNJIGA
          function prikaziKnjige() {
              $.post("./crud/prikaziKnjige.php", function(response){
              $("#prikazKnjiga").html(response);
            });
          }

          prikaziKnjige(); // Poziv funkcije za prikaz

        //PRIKAZ MODALA ZA DODAVANJE KNJIGE 
          $('#btnDodajKnjigu').click(function() {
            $('#dodavanjeKnjige').modal('show');
          });
        
        // DODAVANJE KNJIGE
          $("#dodajForma").submit(function(e){
            e.preventDefault();
            
            let naziv = $("#naziv").val();
            let godinaIzdavanja = $("#godinaIzdavanja").val();
            let stanje = $("#stanje").val();
            let slika = $("#slika")[0].files[0];

            var formData = new FormData(this);

            formData.append('naziv', naziv);
            formData.append('godinaIzdavanja', godinaIzdavanja);
            formData.append('stanje', stanje);
            formData.append('slika', slika);

            let kategorije = $("#kategorija").val();
            let autori = $("#autor").val();
            formData.append('kategorije', kategorije);
            formData.append('autori', autori);


            $.ajax({
              url: "./crud/dodajKnjigu.php",
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function(response) {
                  console.log(response);
                  prikaziKnjige();
              }
            });
          });

        //PRIKAZ MODALA ZA IZMENU KNJIGE 
          $('#btnIzmeniKnjigu').click(function() {
              $('#izmenaKnjige').modal('show');
            });

        //DINAMICKI ISPIS IZBORA IZMENE
          $.post("./ajaxOperations/opcijeIzmena.php", function(response){
            $("#izborIzmene").html(response);
          });

        // IZMENA KNJIGE
          $("#izmeniForma").submit(function(e){
            e.preventDefault();
            let izborIzmene = $("#izborIzmene").val();
            let naziv = $("#izmeniNaziv").val();
            let godinaIzdavanja = $("#izmeniGodinaIzdavanja").val();
            let stanje = $("#izmeniStanje").val();
            let slika = $("#izmeniSlika")[0].files[0];
            let kategorije = $("#izmeniKategorija").val();
            let autori = $("#izmeniAutor").val();

            var formDataIzmena = new FormData(this);

            formDataIzmena.append('izborIzmene', izborIzmene);
            formDataIzmena.append('naziv', naziv);
            formDataIzmena.append('godinaIzdavanja', godinaIzdavanja);
            formDataIzmena.append('stanje', stanje);
            formDataIzmena.append('slika', slika);
            formDataIzmena.append('kategorije', kategorije);
            formDataIzmena.append('autori', autori);

            $.ajax({
              url: "./crud/izmeniKnjigu.php",
              type: "POST",
              data: formDataIzmena,
              contentType: false,
              processData: false,
              success: function(response) {
                  console.log(response);
                  prikaziKnjige();
              }
            });
          });

        //PRIKAZ MODALA ZA BRISANJE KNJIGE 
          $('#btnObrisiKnjigu').click(function() {
            $('#brisanjeKnjige').modal('show');
          });
        
        //DINAMICKI ISPIS IZBORA BRISANJA
          $.post("./ajaxOperations/opcijeBrisanje.php", function(response){
              $("#izborBrisanja").html(response);
            });

        // BRISANJE KNJIGE
          $("#obrisiForma").submit(function(e){
            e.preventDefault();
            let izborBrisanja = $("#izborBrisanja").val();

            $.post("./crud/obrisiKnjigu.php", {izborBrisanja:izborBrisanja}, function(response){
              prikaziKnjige();
            });
          });

        // PRIKAZ REZERVACIJA
          $('#btnRezervacija').click(function(){
            prikaziRezervacije();
            prikaziZaduzenja();
          })
      
        
      })
    </script>

    <!-- konekcija bootrstrap-ovog JS-a -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

  </body>
</html>


