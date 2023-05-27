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
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-dark" type="submit">Search</button>
            </form>
            <!-- PRETRAGA PREMA NAZIVU KNJIGE I AUTORU -->

            <!-- sortiranje -->
            <button name="btnSort" id="btnSort" type="button" class="btn btn-outline-dark">Sort</button>
            <!-- SORTIRANJE PREMA NAZIVU, AUTORU, DOSTUPNOSTI, KATEGORIJA -->
            <!-- AKO SORTIRAŠ PREMA DOSTUPNOSTI UKLJUČITI MOGUĆNOST REZERVACIJE. -->
          </div>
        </div>
    </nav>


    <div id="dodavanjeKnjige" class="prozor">

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
    </div>
   


    <script>

      $(document).ready(function(){

        $("#btnDodaj").click(function(){

          let admin = 1; //uvek imam samo 1 admina, resicu ovo preko sesija na kraju
          let naziv = $("#naziv").val();
          let autor = $("#autor").val();
          let godinaIzdavanja = $("#godinaIzdavanja").val();
          let kategorija = $("#kategorija").val();

          $.post("ajax.php?funkcija=dodajKnjigu", {admin:admin, naziv:naziv, autor:autor, godinaIzdavanja:godinaIzdavanja, kategorija:kategorija}, function(response){
            // citanje knjiga
            $("#prikazKnjiga").html(response);
          })

        })


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



      //   $("#btnObrisi").click(function(){

      //     let admin = 1; //uvek imam samo 1 admina, resicu ovo preko sesija na kraju
      //     let id = id;
      //     let naziv = $("#naziv").val();
      //     let autor = $("#autor").val();

      //     $.post("ajax.php?funkcija=obrisiKnjigu", {admin:admin, id:id, naziv:naziv, autor:autor, godinaIzdavanja:godinaIzdavanja, kategorija:kategorija}, function(response){
      //       // citanje knjiga
      //       $("#prikazKnjiga").html(response);
      //     })

      //   })

      //   $("#btnIzmeni").click(function(){

      //     let admin = 1; //uvek imam samo 1 admina, resicu ovo preko sesija na kraju
      //     let id = id;
      //     let naziv = $("#naziv").val();
      //     let autor = $("#autor").val();

      //     //jos jedna forma za podatke koji treba da se upisu

      //     $.post("ajax.php?funkcija=izmeniKnjigu", {admin:admin, id:id, naziv:naziv, autor:autor, godinaIzdavanja:godinaIzdavanja, kategorija:kategorija}, function(response){
      //       // citanje knjiga
      //       $("#prikazKnjiga").html(response);
      //     })

      //   })


      })

    </script>

    
    <div id="prikazKnjiga" class="container col-8">
       
        <div class="row">
        <ul class="list-group list-group-flush">
          
          <li class="list-group-item">Prva knjiga <br> <span class = "autor">prvi autor</span></li>
          <li class="list-group-item">Druga knjiga <br> <span class = "autor">drugi autor</span></li> 
        

      </div>
    </div>

    <!-- zatamljenje kada se otvara prozor -->
    <div id="pozadina"></div>

    <!-- konekcija JS fajla koji se bavi animacijama -->
    <script src="script.js"></script>

    <!-- konekcija bootrstrap-ovog JS-a -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>