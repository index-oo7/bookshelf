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
              
              <!-- dodavanje Bibliotekara -->
              <button name="btnDodajBibliotekara" id="btnDodajBibliotekara" type="button" class="btn btn-outline-dark">Dodaj bibliotekara</button>

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

    <!-- PRIKAZ AKTIVNIH -->
      <br><br>
      <div class="container col-12" id="prikazAktivnih"></div>

    <!-- PRIKAZ NEAKTIVNIH -->
      <br><br>
      <div class="container col-12" id="prikazNeaktivnih"></div>
          
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
        
      })
    </script>

    <!-- konekcija bootrstrap-ovog JS-a -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

  </body>
</html>


