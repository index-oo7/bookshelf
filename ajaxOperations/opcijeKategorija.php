<?php
    //KONEKCIJA NA BAZU

        $database=mysqli_connect("localhost", "root", "", "bookshelf");
        mysqli_query($database, "SET NAMES utf8");

        // Provera konekcije sa bazom
        if (!$database) {
            die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }

    
    $odgovor="";

    $upit = "SELECT * FROM KATEGORIJA";
    $rezultat = mysqli_query($database, $upit);
        
    // Proveri da li je upit uspešno izvršen
    if ($rezultat) {
        // Prikaži rezultate sortiranja
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $odgovor.="<li id='{$red['ID_KATEGORIJA']}'><a class='dropdown-item'>{$red['NAZIV_KATEGORIJA']}</a></li>";
        }
    } else {
        $odgovor = "Došlo je do greške prilikom prikaza dostupnih knjiga.";
    }

    echo $odgovor;
  
    // ZATVARANJE BAZE
      mysqli_close($database);
?>