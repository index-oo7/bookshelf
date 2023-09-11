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

    $odgovor = ['status' => 'prazno'];
    

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
                }else{
                    $odgovor = array('status' => 'uspeh', 'poruka' => 'Uspesno uredjivanje naloga!');
                }

            }

            if (isset($prezime)){
                $izmeniPrezime = "UPDATE KORISNIK SET PREZIME_KORISNIK = '$prezime' WHERE ID_KORISNIK = $id_korisnik";
                mysqli_query($database, $izmeniPrezime);
                if(!mysqli_query($database, $izmeniPrezime)){
                    mysqli_error($database);
                }else{
                    $odgovor = array('status' => 'uspeh', 'poruka' => 'Uspesno uredjivanje naloga!');
                }
            }
            
            if($novaLozinka!=""){
                if($potvrdaLozinka!=""){
                    if($novaLozinka == $potvrdaLozinka){
                        $novaLozinka = hash('sha256', $novaLozinka, false);
                        $promenaLozinke = "UPDATE KORISNIK SET LOZINKA_KORISNIK = '$novaLozinka' WHERE ID_KORISNIK = $id_korisnik";
                        mysqli_query($database, $promenaLozinke);

                            $odgovor = array('status' => 'uspeh', 'poruka' => 'Uspesno uredjivanje naloga!');

                    }else{$odgovor = array('status' => 'greska', 'poruka' => 'Došlo je do greške prilikom uredjivanja naloga.');}
                       
                      
                }else{$odgovor = array('status' => 'greska', 'poruka' => 'Došlo je do greške prilikom uredjivanja naloga.');}
            }


        }else{$odgovor = array('status' => 'greska', 'poruka' => 'Došlo je do greške prilikom uredjivanja naloga.');}

        
    }else{$odgovor = array('status' => 'greska', 'poruka' => 'Došlo je do greške prilikom uredjivanja naloga.');}

    

    echo json_encode($odgovor);
   


    // ZATVARANJE BAZE
       mysqli_close($database);   
?>