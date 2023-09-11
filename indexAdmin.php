<?php
session_start();
if($_SESSION['uloga'] != '1'){
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

    <title>Admin</title>
</head>
<body>
    
    <!-- nav bar -->
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">

            <!-- logo -->
            <a id="logo" class="navbar-brand fa-fade" href="indexAdmin.php">Bookshelf <sup>©</sup></a>

            <div class="collapse navbar-collapse justify-content-evenly" id="navbarSupportedContent">

              <p class="ime"><?php echo $_SESSION['korime'];?></p>

              <!-- uredjivanje naloga -->
              <button name="btnEdit" id="btnEdit" type="button" class="btn btn-secondary">Uredi nalog</button>
              
              <!-- dodavanje Bibliotekara -->
              <button name="btnDodajBibliotekara" id="btnDodajBibliotekara" type="button" class="btn btn-secondary">Dodaj bibliotekara</button>

              <!-- odjava -->
              <form method="post">
                <button name="odjava" id="odjava" type="submit" class="btn btn-secondary">Odjava</button>
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

    <!-- PRIKAZ AKTIVNIH -->
      <br><br>
      <div class="container col-12" id="prikazAktivnih"></div>

    <!-- PRIKAZ NEAKTIVNIH -->
      <br><br>
      <div class="container col-12" id="prikazNeaktivnih"></div>
    
    <!-- MODAL ZA DODAVANJE BIBLIOTEKARA -->
      <div class="modal fade" id="dodavanjeBibliotekara" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <!-- Forma za dodavanje knjiga u lokalnu bazu podataka -->
              <form id = "dodajForma">

                <label for="ime">Ime:</label>
                <input type="text" id="ime" name="ime" required><br><br>

                <label for="prezime">Prezime:</label>
                <input type="text" id="prezime" name="prezime" required><br><br>

                <label for="mail">E-Mail:</label>
                <input type="text" id="mail" name="mail" required><br><br>

                <label for="lozinka">Lozinka:</label>
                <input type="password" id="lozinka" name="lozinka" required><br><br>

                <label for="potvrda">Potvrda lozinke:</label>
                <input type="password" id="potvrda" name="potvrda" required><br><br>


                <button type="submit" name="btnDodaj" id="btnDodaj" value="submit" class="btn btn-outline-dark">Dodaj bibliotekara</button><br><br>
                  
              </form>
              <div class="greska"></div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- UREDJIVANJE PROFILA -->
        <div class="modal fade" id="uredjivanje" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form id="urediForma">

                                <!-- Forma u kojoj treba uneti podatke za izmenu -->
                                <h3>Uredi nalog:</h3> <br>

                                <label for="ime">Ime:</label>
                                <input type="text" name="izmeniIme" id="izmeniIme" placeholder="<?php echo $_SESSION['ime'];?>"><br><br>

                                <label for="prezime">Prezime:</label>
                                <input type="text" name="izmeniPrezime" id="izmeniPrezime" placeholder="<?php echo $_SESSION['prezime'];?>"><br><br>

                                <label for="lozinka">Lozinka:</label>
                                <input type="text" name="lozinka" id="lozinka"><br><br>

                                <label for="novaLozinka">Nova Lozinka:</label>
                                <input type="text" name="novaLozinka" id="novaLozinka"><br><br>

                                <label for="potvrdaLozinka">Potvrda Lozinke:</label>
                                <input type="text" name="potvrdaLozinka" id="potvrdaLozinka"><br><br>

                                <button type="submit" name="btnUredi" id="btnUredi" value="submit" class="btn btn-outline-dark">Sačuvaj izmene</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



    <script>
        // PRIKAZ AKTIVNIH
          function prikaziAktivne() {
              $.post("./crud/prikaziAktivne.php", function(response){
              $("#prikazAktivnih").html(response);
            });
          }

          prikaziAktivne(); // Poziv funkcije za prikaz
        
        // PRIKAZ NEAKTIVNIH
          function prikaziNeaktivne() {
              $.post("./crud/prikaziNeaktivne.php", function(response){
              $("#prikazNeaktivnih").html(response);
            });
          }

          prikaziNeaktivne(); // Poziv funkcije za prikaz
        
        // Aktiviranje korisnika
          $(document).on('click', '.aktiviraj', function() {
                let idKorisnika = this.id;
                $.post("./ajaxOperations/aktivirajKorisnika.php", {idKorisnika: idKorisnika}, function(response){
                  prikaziAktivne();
                  prikaziNeaktivne();
                });
            });

        // Deaktiviranje korisnika
          $(document).on('click', '.deaktiviraj', function() {
                let idKorisnika = this.id;
                $.post("./ajaxOperations/deaktivirajKorisnika.php", {idKorisnika: idKorisnika}, function(response){
                  prikaziAktivne();
                  prikaziNeaktivne();
                });
            });

        $(document).ready(function(){

        
        //PRIKAZ MODALA ZA DODAVANJE KNJIGE 
          $('#btnDodajBibliotekara').click(function() {
            $('#dodavanjeBibliotekara').modal('show');
          });
        
        // DODAVANJE KNJIGE
          $("#dodajForma").submit(function(e){
            e.preventDefault();
            
            let ime = $("#ime").val();
            let prezime = $("#prezime").val();
            let mail = $("#mail").val();
            let lozinka =  $("#lozinka").val();
            let potvrda =  $("#potvrda").val();


            $.post("./crud/dodajBibliotekara.php", {ime: ime, prezime: prezime,  mail: mail, lozinka: lozinka, potvrda:potvrda}, function(response){
                  prikaziAktivne();
                  prikaziNeaktivne();
                });
          });

        // PRIKAZ MODALA ZA UREDJIVANJE NALOGA 
          $('#btnEdit').click(function() {
                    $('#uredjivanje').modal('show');
                });
        
        // UREDJIVANJE NALOGA
          $("#urediForma").submit(function(e){
              e.preventDefault();
              let ime = $("#izmeniIme").val();
              let prezime = $("#izmeniPrezime").val();
              let lozinka = $("#lozinka").val();
              let novaLozinka = $("#novaLozinka").val();
              let potvrdaLozinka = $("#potvrdaLozinka").val();

              var formDataUredi = new FormData(this);

              formDataUredi.append('ime', ime);
              formDataUredi.append('prezime', prezime);
              formDataUredi.append('lozinka', lozinka);
              formDataUredi.append('novaLozinka', novaLozinka);
              formDataUredi.append('potvrdaLozinka', potvrdaLozinka);
              $.ajax({
              url: "./crud/urediNalog.php",
              type: "POST",
              data: formDataUredi,
              contentType: false,
              processData: false,
              success: function(response) {
                  var odgovor = $("#urediForma");
                  odgovor.append(response);
              }
              });
          });
        
      })
    </script>

    <!-- konekcija bootrstrap-ovog JS-a -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

  </body>
</html>


