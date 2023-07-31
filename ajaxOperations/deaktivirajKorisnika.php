<?php
  //KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
    
    // Provera konekcije sa bazom
    if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }

  $id_korisnik = $_POST['idKorisnika'];
  $upit = "UPDATE korisnik SET STATUS_KORISNIK = 0 WHERE ID_KORISNIK = $id_korisnik";
  mysqli_query($database, $upit);



  // ZATVARANJE BAZE
    mysqli_close($database);

?>
