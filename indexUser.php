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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

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
                        <button name="btnRezervisiKnjigu" id="btnRezervisiKnjigu" type="button" class="btn btn-outline-dark">Rezervisi knjigu</button>

                    <!-- pretraga -->
                        <form class="d-flex" role="search" id="pretraga">
                            <input class="form-control me-2" type="search" placeholder="Search" name="terminPretrage" id="terminPretrage" aria-label="Search">
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
        
    <div class="modal fade" id="rezervacija" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="rezervisiKnjigu">
                        <h3>Ovde izaberite koju knjigu zelite da rezervišete:</h3>
                        <select name="izborRezervacije" id="izborRezervacije"></select><br><br>
                        <p>Rezervacija traje 5 dana od trenutka rezervisanja.</p>
                        <button type="submit" name="btnRezervisi" id="btnRezervisi" value="submit" class="btn btn-outline-dark">Rezerviši knjigu</button>
                    </form>
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

            //PRIKAZ MODALA ZA REZERVACIJU 
                $('#btnRezervisiKnjigu').click(function() {
                    $('#rezervacija').modal('show');
                    });

            //DINAMICKI ISPIS DOSTUPNIH KNJIGA U REZERVACIJI
                $.post("./ajaxOperations/opcijeRezervacija.php?funkcija=dostupno", function(response){
                    $("#izborRezervacije").html(response);
                    });

            //UPIS REZERVACIJE
                $("#rezervisiKnjigu").submit(function(e){
                    e.preventDefault();
                    let izborRezervacije = $("#izborRezervacije").val();
                    $.post("./ajaxOperations/rezervacija.php?",{izborRezervacije:izborRezervacije});
                })

            //PRETRAGA
                $("#btnPretrazi").click(function(e) {
                    e.preventDefault();
                    let terminPretrage = $("#terminPretrage").val();
                    $.post("./ajaxOperations/pretraga.php?",{terminPretrage:terminPretrage}, function(response){
                    $("#prikazKnjiga").html(response);
                    });
                });
            
            //SORTIRANJE
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

    
        
    <!-- konekcija bootrstrap-ovog JS-a -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

</body>
</html>