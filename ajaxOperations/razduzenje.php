<?php
  //KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
    
    // Provera konekcije sa bazom
    if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }



  $idZaduzenja = (int) $_POST['idZaduzenja'];

  echo "id zaduzenja je: " . $idZaduzenja;

  // Provera da li postoji zaduženje sa datim ID-om
  $upitProvera = "SELECT COUNT(*) AS broj_zaduzenja FROM ZADUZENJE WHERE ID_ZADUZENJA = $idZaduzenja";
  $rezultatProvera = mysqli_query($database, $upitProvera);
  $redProvera = mysqli_fetch_assoc($rezultatProvera);
  $brojZaduzenja = $redProvera['broj_zaduzenja'];

  if ($brojZaduzenja > 0) {

    // Pokupi ID knjige koja se razdužuje
    $upitPokupiIDKnjige = "SELECT ID_KNJIGA FROM ZADUZENJE WHERE ID_ZADUZENJA = $idZaduzenja";
    $rezultatIDKnjige = mysqli_query($database, $upitPokupiIDKnjige);
    $redIDKnjige = mysqli_fetch_assoc($rezultatIDKnjige);
    $idKnjige = $redIDKnjige['ID_KNJIGA'];
    echo "id knjige je: ". $idKnjige;

    // Azuriraj status_zaduzenje na 0
    $upitAzurirajStatus = "UPDATE ZADUZENJE SET STATUS_ZADUZENJE = 0 WHERE ID_ZADUZENJA = $idZaduzenja";
    mysqli_query($database, $upitAzurirajStatus);

    // Povecaj stanje knjige za 1
    $upitPovecajStanje = "UPDATE KNJIGA SET STANJE_KNJIGA = STANJE_KNJIGA + 1 WHERE ID_KNJIGA = $idKnjige";
    mysqli_query($database, $upitPovecajStanje);

  } else {
      // Zaduženje ne postoji
      echo "Zaduženje sa datim ID-om ne postoji.";
  }

  // ZATVARANJE BAZE
    mysqli_close($database);

?>
