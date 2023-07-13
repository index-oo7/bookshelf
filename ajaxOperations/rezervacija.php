<?php
    //KONEKCIJA NA BAZU
        $database=mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");

        // Provera konekcije sa bazom
        if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }
  
    
    $idKnjiga = $_POST['izborRezervacije'];
    $idKorisnik = $_SESSION['korisnik'];//sesija korisnika

    // formiranje datuma za pocetak i kraj rezervacije
    $pocetakRezervacije = strtotime("now");
    $krajRezervacije = $pocetakRezervacije + (24*60*60*5);

    $pocetak = date("Y-m-d H:i:s", $pocetakRezervacije);
    $kraj = date("Y-m-d H:i:s", $krajRezervacije);

    // Provera da li se id_knjiga nalazi u tabeli rezervacija (sprecavanje ponovnog unosa pri refresovanju)
    $upit = "SELECT * FROM rezervacija WHERE id_knjiga = $idKnjiga";
    $rezultat = mysqli_query($database, $upit);

    if (mysqli_num_rows($rezultat) > 0) {
        // Id_knjiga se nalazi u tabeli rezervacija i nece ga upisati ponovo
        die();
    } else {
        $upit = "INSERT INTO rezervacija (ID_KORISNIK, ID_KNJIGA, POCETAK_REZERVACIJA, KRAJ_REZERVACIJA) VALUES ($idKorisnik, $idKnjiga, '$pocetak', '$kraj')";
        mysqli_query($database, $upit);
    }
    
    
  // ZATVARANJE BAZE
    mysqli_close($database);
?>