<?php
    //KONEKCIJA NA BAZU
        $database=mysqli_connect("localhost", "root", "", "bookshelf");
        mysqli_query($database, "SET NAMES utf8");

        // Provera konekcije sa bazom
        if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }



    //Kupimo vrednosti iz post zahteva
    $id_knjiga = $_POST['izborIzmene'];
    $naziv = $_POST['naziv'];
    $godinaIzdavanja = $_POST['godinaIzdavanja'];
    $stanje = $_POST['stanje'];

    var_dump($id_knjiga);
    var_dump($naziv);
    var_dump($godinaIzdavanja);
    var_dump($stanje);


    $folder = '../slike/';


    if (isset($_FILES['slika'])) {
        $imeSlike = $_FILES['slika']['name'];
        $privremenaLokacija = $_FILES['slika']['tmp_name'];
        $lokacijaSlike = $folder . $imeSlike;

        // Premestite sliku iz privremenog foldera u odgovarajući folder na serveru
        move_uploaded_file($privremenaLokacija, $lokacijaSlike);

        // Upit za azuriranje slike u bazi
        $izmeniSliku = "UPDATE KNJIGA SET SLIKA_KNJIGA = 'slike/$imeSlike' WHERE ID_KNJIGA = $id_knjiga";
        if(!mysqli_query($database, $izmeniSliku)){
            mysqli_error($database);
        }
    }
        
    if (isset($naziv)){
        $izmeniNaziv = "UPDATE KNJIGA SET NAZIV_KNJIGA = '$naziv' WHERE ID_KNJIGA = $id_knjiga";
        mysqli_query($database, $izmeniNaziv);
        if(!mysqli_query($database, $izmeniNaziv)){
            mysqli_error($database);
        }
    }

    if (isset($godinaIzdavanja)){
        $izmeniGodinu = "UPDATE KNJIGA SET GODINA_IZDAVANJA_KNJIGA = $godinaIzdavanja WHERE ID_KNJIGA = $id_knjiga";
        mysqli_query($database, $izmeniGodinu);
        if(!mysqli_query($database, $izmeniGodinu)){
            mysqli_error($database);
        }
    }

    if (isset($stanje)){
        $izmeniStanje = "UPDATE KNJIGA SET STANJE_KNJIGA = $stanje WHERE ID_KNJIGA = $id_knjiga";
        mysqli_query($database, $izmeniStanje);
        if(!mysqli_query($database, $izmeniStanje)){
            mysqli_error($database);
        }
    }

    if (isset($_POST['autori'])) {
        // Brisemo sve dotadasnje redove autorizacije za tu knjigu
        $brisanjeAutorizacija = "CALL ObrisiAutorizaciju($id_knjiga)";
        mysqli_query($database, $brisanjeAutorizacija);

        $autoriString = $_POST['autori'];
        $autori = explode(',', $autoriString); // Razdvajamo string na osnovu zareza i razmaka
        // Trimovanje elemenata niza
        $autori = array_map('trim', $autori);
        for($i=0; $i <  count($autori); $i++){
            $autor = $autori[$i];
            $upitAutor = "CALL PoveziAutorizaciju($id_knjiga, '$autor');";
            mysqli_query($database, $upitAutor);
            do {
                if ($rezultat = mysqli_store_result($database)) {
                    mysqli_free_result($rezultat);
                }
            } while (mysqli_next_result($database));
        }

    }

    if (isset($_POST['kategorije'])) {
        // Brisemo sve dotadasnje redove kategorizacije za tu knjigu
        $brisanjeKategorizacija = "CALL ObrisiKategorizaciju($id_knjiga)";
        mysqli_query($database, $brisanjeKategorizacija);

        $kategorijeString = $_POST['kategorije'];
        $kategorije = explode(',', $kategorijeString); // Razdvajamo string na osnovu zareza i razmaka
        // Trimovanje elemenata niza
        $kategorije = array_map('trim', $kategorije);
        for($i=0; $i <  count($kategorije); $i++){
            $kategorija = $kategorije[$i];
            $upitKategorija = "CALL PoveziKategoriju($id_knjiga, '$kategorija');";
            mysqli_query($database, $upitKategorija);
            do {
                if ($rezultat = mysqli_store_result($database)) {
                    mysqli_free_result($rezultat);
                }
            } while (mysqli_next_result($database));
        }
    }


    // ZATVARANJE BAZE
       mysqli_close($database);   
?>