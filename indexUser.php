<?php
    session_start();
    if($_SESSION['uloga'] != '3'){
        header("Location: ./login/login.php");
    }
?>
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

                    <p class="ime"><?php echo $_SESSION['korime'];?></p>

                    <!-- uredjivanje naloga -->
                    <button name="btnEdit" id="btnEdit" type="button" class="btn btn-secondary">Uredi nalog</button>

                    <!-- rezervacija knjige -->
                        <button name="btnRezervisiKnjigu" id="btnRezervisiKnjigu" type="button" class="btn btn-secondary">Rezervisi knjigu</button>

                    <!-- pregled rezervacija -->
                        <button name="btnPregledaj" id="btnPregledaj" type="button" class="btn btn-secondary">Rezervacije</button>

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
                                <li id="sortDostupno"><a class="dropdown-item">Dostupno</a></li>
                                <li id="sortZauzeto"><a class="dropdown-item">Zauzeto</a></li>
                            </ul>
                        </div>
                    
                    <!-- kategorija -->
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="true" name="btnKategorija" id="btnKategorija">
                                Kategorije
                            </button>
                            <ul class="dropdown-menu" name="izborKategorije" id="izborKategorije"></ul>
                        </div>

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
        function prikaziVlastiteRezervacije() {
            $.post("./crud/prikaziVlastiteRezervacije.php", function(response){
                    $("#prikazKnjiga").html(response);
            });
        }

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
        // UPIS REZERVACIJE IZ DETALJA
            $(document).on('click', '#btnRezervisiDetalji', function() {
                let izborRezervacije = $(this).val();
                $.post("./ajaxOperations/rezervacija.php?",{izborRezervacije:izborRezervacije});
                alert("Uspešno ste rezervisali!"); // alert o uspesnoj rezervaciji
            });

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
                $.post("./ajaxOperations/opcijeRezervacija.php", function(response){
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
                        $.post("./ajaxOperations/sortKolona.php", { kolona: kolona }, function(response) {
                            $("#prikazKnjiga").html(response);
                        });
                    }
                    
                    // dostupne knjige
                    if (kriterijum === "Dostupno") {
                        $.post("./ajaxOperations/sortDostupno.php", function(response) {
                            $("#prikazKnjiga").html(response);
                        });
                    }
                    // rezervisane
                    if (kriterijum === "Zauzeto") {
                        $.post("./ajaxOperations/sortZauzeto.php", function(response) {
                            $("#prikazKnjiga").html(response);
                        });
                    }

                });
            
            // DINAMICKI ISPIS DOSTUPNIH KATEGORIJA
                $.post("./ajaxOperations/opcijeKategorija.php", function(response){
                    $("#izborKategorije").html(response);
                });

            // ALERT O USPESNOJ REZERVACIJI
                $("#btnRezervisi").click(function() {
                    alert("Uspešno ste rezervisali!");
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

            // PRIKAZ VLASTITIH REZERVACIJA
            $("#btnPregledaj").click(function() {
                prikaziVlastiteRezervacije();
                });
        })

        
    </script>

    
        
    <!-- konekcija bootrstrap-ovog JS-a -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

</body>
</html>