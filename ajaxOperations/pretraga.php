<?php
    //KONEKCIJA NA BAZU
        $funkcija = $_GET['funkcija'];

        $database = mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");

        if (!$database) {
            die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }
    // PRETRAGA
        $terminPretrage = $_POST['terminPretrage'];
        $upit = "SELECT * FROM knjiga WHERE NAZIV_KNJIGA LIKE '%$terminPretrage%' OR AUTOR_KNJIGA LIKE '%$terminPretrage%'";
        $rez = mysqli_query($database, $upit);

        if (mysqli_num_rows($rez) > 0) {
            echo "<ul>";
            while ($red = mysqli_fetch_assoc($rez)) {
                echo "<li>{$red['NAZIV_KNJIGA']} - {$red['AUTOR_KNJIGA']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Nema rezultata za traženi termin pretrage.</p>";
        }

    //ZATVARANJE BAZE
        mysqli_close($database);

?>