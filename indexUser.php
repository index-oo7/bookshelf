<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
                <a id="logo" class="navbar-brand fa-fade" href="indexUser.php">Bookshelf <sup>©</sup></a>

                <div class="collapse navbar-collapse justify-content-evenly" id="navbarSupportedContent">

                <!-- rezervacija knjige -->
                    <button name="btnRezervisiKnjigu" id="btnRezervisiKnjigu" type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#rez">Rezervisi knjigu</button>

                <!-- pretraga -->
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" name="pretraga" id="pretraga" aria-label="Search">
                        <div id="rezultatiPretrage"></div>
                        <button class="btn btn-outline-dark" type="submit" name="btnPretrazi" id="btnPretrazi">Search</button>
                    </form>

                <!-- sortiranje -->
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true" name="btnSortiranje" id="btnSortiranje">
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


    <!-- REZERVACIJA KNJIGE -->
            <div id="rezervacijaKnjige" class="prozor">
                
            
            </div>

    <div class="modal fade" id="rez" tabindex="-1" role="dialog" aria-labelledby="dodajNalogLBL" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="dodajNalogLBL">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="rezervisiKnjigu">
                <h3>Ovde izaberite koju knjigu zelite da rezervišete:</h3>
                <select name="izborRezervacije" id="izborRezervacije"></select><br><br>
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

    //PRIKAZ KNJIGA
        function prikaziKnjige() {
            $.post("./crud/prikaziKnjige.php", function(response){
              $("#prikazKnjiga").html(response);
            });
          }

        prikaziKnjige();


    //DINAMICKI ISPIS DOSTUPNIH KNJIGA U REZERVACIJI
        $.post("./ajaxOperations/opcijeRezervacija.php?funkcija=dostupno", function(response){
              $("#izborRezervacije").html(response);
            });
      })
    </script>

    <!-- zatamljenje kada se otvara prozor -->
        <div id="pozadina"></div>

    <!-- konekcija JS fajla koji se bavi animacijama -->
        <script src="script.js"></script>

    <!-- konekcija bootrstrap-ovog JS-a -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>