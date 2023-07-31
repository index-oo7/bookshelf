<?php
    session_start();
    //KONEKCIJA NA BAZU
        $database=mysqli_connect("localhost", "root", "", "bookshelf");
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

    $pocetak = date("Y-m-d", $pocetakRezervacije);
    $kraj = date("Y-m-d", $krajRezervacije);

    $rezervacija = "CALL DodajRezervaciju($idKorisnik, $idKnjiga, '$pocetak', '$kraj')";
    mysqli_query($database,$rezervacija);

   
    
    
  // ZATVARANJE BAZE
    mysqli_close($database);
?>