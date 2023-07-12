<?php
    //KONEKCIJA NA BAZU
        $database=mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");

        // Provera konekcije sa bazom
        if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }



    //Kupimo vrednosti iz post zahteva
    $izborIzmene = $_POST['izborIzmene'];
    $naziv = $_POST['naziv'];
    $autor = $_POST['autor'];
    $godinaIzdavanja = $_POST['godinaIzdavanja'];
    $kategorija = $_POST['kategorija'];

    
    // Slanje upita za upis knjige u bazu
    $upit = "CALL IzmeniKnjigu('$naziv', '$autor', $godinaIzdavanja, '$kategorija', $izborIzmene)";
    mysqli_query($database, $upit);

    // ZATVARANJE BAZE
       mysqli_close($database);   
?>