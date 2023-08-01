<?php
  //KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
    
    // Provera konekcije sa bazom
    if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }



  $idZaduzenja = (int) $_POST['idZaduzenja'];

  $razduzenje = "CALL RazduziKnjigu($idZaduzenja)";
  if(mysqli_query($database, $razduzenje)){

  }else{
    echo "Greška prilikom upisa zaduženja u bazu: " . mysqli_error($database);
  }
  

  // ZATVARANJE BAZE
    mysqli_close($database);

?>
