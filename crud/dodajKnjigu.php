<?php
    //KONEKCIJA NA BAZU
        $database=mysqli_connect("localhost", "root", "", "bookshelf");
        mysqli_query($database, "SET NAMES utf8");
        
        // Provera konekcije sa bazom
        if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }


    //Kupimo vrednosti iz post zahteva
        $naziv = $_POST['naziv'];
        $autor = $_POST['autor'];
        $godinaIzdavanja = $_POST['godinaIzdavanja'];
        $kategorija = $_POST['kategorija'];
        $stanje = $_POST['stanje'];

    

    // Provera i čuvanje slike
        if (isset($_FILES['slika'])) {
            $imeSlike = $_FILES['slika']['name'];
            $privremenoImeSlike = $_FILES['slika']['tmp_name'];
            $lokacijaSlike = 'slike/' . $imeSlike;

        // Premestite sliku iz privremenog foldera u odgovarajući folder na serveru
            move_uploaded_file($privremenoImeSlike, 'C:/xampp/htdocs/Projects/bookshelf/' . $lokacijaSlike);

        // Slanje upita za upis knjige u bazu
            $upit = "CALL DodajKnjigu('$naziv', '$autor', $godinaIzdavanja, '$lokacijaSlike','$kategorija', $stanje);";
            mysqli_query($database, $upit);
        }


    // ZATVARANJE BAZE
        mysqli_close($database);
    ?>