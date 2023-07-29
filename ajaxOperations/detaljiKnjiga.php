<?php
    //KONEKCIJA NA BAZU

        $database = mysqli_connect("localhost", "root", "", "bookshelf");
        mysqli_query($database, "SET NAMES utf8");

        if (!$database) {
            die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }
    // DETALJI O KNJIZI

        $odgovor="";
        $idModal = $_POST['idModal'];

        //ISPISIVANJE KNJIGE
            $upitKnjiga = "SELECT * FROM knjiga WHERE ID_KNJIGA LIKE '$idModal' AND STATUS_KNJIGA = TRUE";
            $rezKnjiga = mysqli_query($database, $upitKnjiga);
            $redKnjiga = mysqli_fetch_assoc($rezKnjiga);

        //ISPISIVANJE AUTORA
            $autorUpit = "SELECT a.IME_AUTOR FROM autor a
                        INNER JOIN autorizacija az ON a.ID_AUTOR = az.ID_AUTOR
                        WHERE az.ID_KNJIGA = $idModal";

            $autorRez = mysqli_query($database, $autorUpit);
            $autori = array();

            while ($autorRed = mysqli_fetch_assoc($autorRez)) {
                $autori[] = $autorRed['IME_AUTOR'];
            }

            $autoriString = implode(', ', $autori);

        //ISPISIVANJE KATEGORIJE
            $kategorijaUpit = "SELECT k.NAZIV_KATEGORIJA FROM kategorija k
                        INNER JOIN kategorizacija kz ON k.ID_KATEGORIJA = kz.ID_KATEGORIJA
                        WHERE kz.ID_KNJIGA = $idModal";

            $kategorijaRez = mysqli_query($database, $kategorijaUpit);
            $kategorije = array();

            while ($kategorijaRed = mysqli_fetch_assoc($kategorijaRez)) {
                $kategorije[] = $kategorijaRed['NAZIV_KATEGORIJA'];
            }

            $kategorijeString = implode(', ', $kategorije);
        
            $odgovor = "
            <div class='card ' style='width: 15rem; margin: 10px;'>
                <img class='card-img-top' src='{$redKnjiga['SLIKA_KNJIGA']}' alt='Card image cap'>
                <div class='card-body'>
                    <h5 class='card-title'>{$redKnjiga['NAZIV_KNJIGA']} </h5>
                    <p class='card-text'> <b>Autor/i:</b> $autoriString <br>
                    <b>Godina izdavanja:</b> {$redKnjiga['GODINA_IZDAVANJA_KNJIGA']} <br>
                    <b>Kategorija/e:</b> $kategorijeString <br> </p>
                    <b>Raspolozivo stanje:</b> {$redKnjiga['STANJE_KNJIGA']}
                </div>
            </div>";


        echo $odgovor;

    //ZATVARANJE BAZE
        mysqli_close($database);

?>