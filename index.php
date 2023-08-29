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

    <title>Gost</title>
</head>
<body>
    <!-- nav bar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">

                <!-- logo -->
                    <a id="logo" class="navbar-brand fa-fade" href="index.php">Bookshelf <sup>©</sup></a>

                <div class="collapse navbar-collapse justify-content-evenly" id="navbarSupportedContent">
                    
                    <p class="ime">Gost</p>
                    
                    <!-- pretraga -->
                        <form class="d-flex" role="search" id="pretraga">
                            <input class="form-control me-2" type="search" placeholder="Pretraga" name="terminPretrage" id="terminPretrage" aria-label="Search">
                            <button class="btn btn-secondary" type="submit" name="btnPretrazi" id="btnPretrazi">Pretrazi</button>
                        </form>

                    <!-- sortiranje -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true" name="btnSortiranje" id="btnSortiranje">
                                Sortiraj
                            </button>
                            <ul class="dropdown-menu" name="sortiranje" id="sortiranje">
                                <li id="sortNaziv"><a class="dropdown-item">Naziv</a></li>
                            </ul>
                        </div>
                    
                    <!-- kategorija -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true" name="btnKategorija" id="btnKategorija">
                                Kategorije
                            </button>
                            <ul class="dropdown-menu" name="izborKategorije" id="izborKategorije"></ul>
                        </div>

                    <!-- prijava -->
                        <form method="post">
                            <a href="login/login.php"><button type="button" name="prijava" id="prijava" class="btn btn-secondary">Prijava</button></a>
                        </form>
                </div>
            </div>
        </nav>


    <!-- PRIKAZ KNJIGA -->
        <div class="container col-12" id="prikazKnjiga"></div>




    <script>
        // Definisanje klika na elemente s klasom "knjiga"
            $(document).on('click', '.knjiga', function() {
                let idModal = this.id;
                $.post("./ajaxOperations/detaljiKnjiga.php", {idModal: idModal}, function(response){
                    $("#prikazKnjiga").html(response);
                });
            });

        //SORTIRANJE KATEGORIJA
            $(document).on('click', '#izborKategorije li', function() {
                    var kriterijum = this.id;
                    $.post("./ajaxOperations/kategorizacija.php", {kriterijum:kriterijum}, function(response) {
                            $("#prikazKnjiga").html(response);
                        });
                })


        $(document).ready(function(){

            //PRIKAZ KNJIGA
                function prikaziKnjige() {
                    $.post("./crud/prikaziKnjige.php", function(response){
                        $("#prikazKnjiga").html(response);
                    });
                }

                prikaziKnjige();

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
                        $.post("./ajaxOperations/sortKolona.php", { kolona: kolona }, function(response) {
                            $("#prikazKnjiga").html(response);
                        });
                    }
                    

                });
            
            //DINAMICKI ISPIS DOSTUPNIH KATEGORIJA
                $.post("./ajaxOperations/opcijeKategorija.php", function(response){
                    $("#izborKategorije").html(response);
                });
            
        })

        
    </script>

    
        
    <!-- konekcija bootrstrap-ovog JS-a -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

</body>
</html>