<?php
    //KONEKCIJA NA BAZU

        $database=mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");

        // Provera konekcije sa bazom
        if (!$database) {
            die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }

    //Dinamicki prikaz dostupnih knjiga u okviru izborne liste kod rezervacije
    $odgovor="";

    // Izvrši SQL upit za prikaz nerezervisanih knjiga
    $upit = "SELECT DISTINCT KATEGORIJA FROM knjiga";
    $rezultat = mysqli_query($database, $upit);
        
    // Proveri da li je upit uspešno izvršen
    if ($rezultat) {
        // Prikaži rezultate sortiranja
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $odgovor.="<li id='{$red['KATEGORIJA']}'><a class='dropdown-item'>{$red['KATEGORIJA']}</a></li>";
        }
    } else {
        $odgovor = "Došlo je do greške prilikom prikaza dostupnih knjiga.";
    }

    echo $odgovor;
  
    // ZATVARANJE BAZE
      mysqli_close($database);
?>