<?php
    //KONEKCIJA NA BAZU
        $funkcija = $_GET['funkcija'];

        $database = mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");

        if (!$database) {
            die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }
    // DETALJI O KNJIZI

        $odgovor="";
        $idModal = $_POST['idModal'];
        $upit = "SELECT * FROM knjiga WHERE ID_KNJIGA LIKE '$idModal'";
        $rez = mysqli_query($database, $upit);
        $red = mysqli_fetch_assoc($rez);
        
        $odgovor = "
        <div class='card detalji' style='width: 18rem;'>
            <img class='card-img-top' src='https://www.vulkani.rs/files/thumbs/files/images/slike_proizvoda/thumbs_1200/28528_1200_1200px.jpg' alt='Card image cap'>
            <div class='card-body'>
                <h5 class='card-title'>{$red['NAZIV_KNJIGA']} </h5>
                <p class='card-text'> {$red['AUTOR_KNJIGA']} <br>
                        {$red['GODINA_IZDAVANJA_KNJIGA']} <br>
                        {$red['KATEGORIJA']} <br> </p>
            </div>
        </div>";


        echo $odgovor;

    //ZATVARANJE BAZE
        mysqli_close($database);

?>