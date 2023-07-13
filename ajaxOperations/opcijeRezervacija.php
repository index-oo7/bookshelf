<?php
    //KONEKCIJA NA BAZU
        $funkcija = $_GET['funkcija'];

        $database=mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");

        // Provera konekcije sa bazom
        if (!$database) {
            die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }

    //Dinamicki prikaz dostupnih knjiga u okviru izborne liste kod rezervacije
    if($funkcija == 'dostupno'){


        // blok koji se izvrsava kada god izlistavamo dostupno i rezervisano da proverimo kojoj knjizi je rezervacija istekla
        $trenutniDatum = date("Y-m-d H:i:s");
        $upitBrisanje = "DELETE FROM rezervacija WHERE KRAJ_REZERVACIJA < '$trenutniDatum'";
        mysqli_query($database, $upitBrisanje);





        $odgovor="";

        // Izvrši SQL upit za prikaz nerezervisanih knjiga
        $upit = "SELECT * FROM knjiga WHERE ID_KNJIGA NOT IN (SELECT ID_KNJIGA FROM rezervacija)";
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
    }

    // ZATVARANJE BAZE
      mysqli_close($database);
?>