<?php
    //KONEKCIJA NA BAZU

        $database=mysqli_connect("localhost", "root", "", "bookshelf");
        mysqli_query($database, "SET NAMES utf8");

        // Provera konekcije sa bazom
        if (!$database) {
            die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }

    //Dinamicki prikaz dostupnih knjiga u okviru izborne liste kod rezervacije
    $odgovor="";

    // Izvrši SQL upit za prikaz nerezervisanih knjiga
    $upit = "SELECT * FROM knjiga WHERE STATUS_KNJIGA = 1";
    $rezultat = mysqli_query($database, $upit);
        
    // Proveri da li je upit uspešno izvršen
    if ($rezultat) {
        // Prikaži rezultate sortiranja
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $odgovor.="<option value='{$red['ID_KNJIGA']}'>{$red['NAZIV_KNJIGA']}</option>";
        }
    } else {
        $odgovor = "Došlo je do greške prilikom prikaza dostupnih knjiga.";
    }

    echo $odgovor;
  
    // ZATVARANJE BAZE
      mysqli_close($database);
?>