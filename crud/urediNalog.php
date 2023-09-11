<?php
    //KONEKCIJA NA BAZU
        $database=mysqli_connect("localhost", "root", "", "bookshelf");
        mysqli_query($database, "SET NAMES utf8");

        // Provera konekcije sa bazom
        if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }

        session_start();


    //Kupimo vrednosti iz post zahteva
    $id_korisnik = $_SESSION['korisnik'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $lozinka = $_POST['lozinka'];
    $novaLozinka = $_POST['novaLozinka'];
    $potvrdaLozinka = $_POST['potvrdaLozinka'];

    

    if (isset($lozinka)){
        $proveriLozinku = "SELECT * FROM KORISNIK WHERE ID_KORISNIK = $id_korisnik";
        $rezultat = mysqli_query($database, $proveriLozinku);
        $red = mysqli_fetch_assoc($rezultat);
        $staraLozinka = $red['LOZINKA_KORISNIK'];
        $lozinka = hash('sha256', $lozinka, false);


        if(substr($lozinka,0,15) == $staraLozinka){

            if (isset($ime)){
                $izmeniIme = "UPDATE KORISNIK SET IME_KORISNIK = '$ime' WHERE ID_KORISNIK = $id_korisnik";
                mysqli_query($database, $izmeniIme);
                if(!mysqli_query($database, $izmeniIme)){
                    mysqli_error($database);
                }
            }

            if (isset($prezime)){
                $izmeniPrezime = "UPDATE KORISNIK SET PREZIME_KORISNIK = '$prezime' WHERE ID_KORISNIK = $id_korisnik";
                mysqli_query($database, $izmeniPrezime);
                if(!mysqli_query($database, $izmeniPrezime)){
                    mysqli_error($database);
                }
            }
            
            if($novaLozinka!=""){
                if($potvrdaLozinka!=""){
                    if($novaLozinka == $potvrdaLozinka){
                        $novaLozinka = hash('sha256', $novaLozinka, false);
                        $promenaLozinke = "UPDATE KORISNIK SET LOZINKA_KORISNIK = '$novaLozinka' WHERE ID_KORISNIK = $id_korisnik";
                        mysqli_query($database, $promenaLozinke);
                        if(mysqli_query($database, $promenaLozinke)){
                            echo("");
                        }else{mysqli_error($database);}
        
                    }else{echo(" <div class='alert alert-danger' role='alert'>
                        <p>Netacna potvrda lozinke!</p>;
                        </div>");}
                       
                      
                }else{echo(" <div class='alert alert-danger' role='alert'>
                    <p>Nije unesena potvrda lozinke!</p>;
                    </div>");}
            }


        }else{echo(" <div class='alert alert-danger' role='alert'>
            <p>Netacna lozinka!</p>;
            </div>");}

        
    }else{echo(" <div class='alert alert-danger' role='alert'>
        <p>Lozinka nije unesena!</p>;
        </div>");};


   


    // ZATVARANJE BAZE
       mysqli_close($database);   
?>