<?php
  //KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
    
    // Provera konekcije sa bazom
    if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }


  $idRezervacije = $_POST['idRezervacije'];


  //Definisanje datuma pocetka zaduzenja i kraja zaduzenja
  $pocetakZaduzenja = date("Y-m-d");
  $krajZaduzenja = strtotime("+30 days");
  $krajZaduzenja = date("Y-m-d", $krajZaduzenja);

  
  $upit = "SELECT ID_KNJIGA, ID_KORISNIK FROM REZERVACIJA WHERE ID_REZERVACIJA = '$idRezervacije';";
  $rez = mysqli_query($database, $upit);


  while($red = mysqli_fetch_assoc($rez)){
    $idKnjiga = $red['ID_KNJIGA'];
    $idKorisnik = $red['ID_KORISNIK'];
  }
  $zaduzenje = "INSERT INTO ZADUZENJE (ID_KNJIGA, ID_KORISNIK, POCETAK_ZADUZENJE, KRAJ_ZADUZENJE, STATUS_ZADUZENJE)
            VALUES ($idKnjiga, $idKorisnik, '$pocetakZaduzenja', '$krajZaduzenja', 1);";

  $rezZaduzenje = mysqli_query($database, $zaduzenje);

  
  $azuriranje = "UPDATE REZERVACIJA SET STATUS_REZERVACIJA = 0 WHERE ID_REZERVACIJA = '$idRezervacije';";
  $rezAzuriranje = mysqli_query($database, $azuriranje);

  // ZATVARANJE BAZE
    mysqli_close($database);

?>
