<?php
//KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");

    // Provera konekcije sa bazom
    if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }

// Kupimo vrednosti iz post zahteva
    $naziv = $_POST['naziv'];
    $godinaIzdavanja = $_POST['godinaIzdavanja'];
    $stanje = $_POST['stanje'];

    $folder = '../slike/';

// Provera i čuvanje slike
    if (isset($_FILES['slika'])) {
        $imeSlike = $_FILES['slika']['name'];
        $privremenaLokacija = $_FILES['slika']['tmp_name'];
        $lokacijaSlike = $folder . $imeSlike;

        // Premestite sliku iz privremenog foldera u odgovarajući folder na serveru
        move_uploaded_file($privremenaLokacija, $lokacijaSlike);

        // Slanje upita za upis knjige u bazu
        $upit = "CALL DodajKnjigu('$naziv', $godinaIzdavanja, $stanje, 'slike/$imeSlike');";
        $rezultat = mysqli_query($database, $upit);
        if ($rezultat) {
            $red = mysqli_fetch_assoc($rezultat);
            $id_knjiga = $red['ID_KNJIGA'];

            do {
                if ($rezultat = mysqli_store_result($database)) {
                    mysqli_free_result($rezultat);
                }
            } while (mysqli_next_result($database));

            // Povezivanje autora sa knjigom
            if (isset($_POST['autori'])) {
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

            // Povezivanje kategorija sa knjigom
            if (isset($_POST['kategorije'])) {
                $kategorijeString = $_POST['kategorije'];
                $kategorije = explode(', ', $kategorijeString); // Razdvajamo string na osnovu zareza i razmaka
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
        } else {
            // Ukoliko upit nije uspeo, ispisuje se greška
            echo "Greška prilikom izvršavanja upita: " . mysqli_error($database);
    }
}

// ZATVARANJE BAZE
    mysqli_close($database);
    ?>
