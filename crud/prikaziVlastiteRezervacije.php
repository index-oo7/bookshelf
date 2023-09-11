<?php
  //KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
    
    // Provera konekcije sa bazom
    if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }

    session_start();

    $id_korisnik = $_SESSION['korisnik'];

    $upit = "SELECT REZERVACIJA.*, KNJIGA.NAZIV_KNJIGA
    FROM REZERVACIJA
    JOIN KNJIGA ON REZERVACIJA.ID_KNJIGA = KNJIGA.ID_KNJIGA
    WHERE REZERVACIJA.STATUS_REZERVACIJA = 1 AND REZERVACIJA.ID_KORISNIK = $id_korisnik";

    $rez = mysqli_query($database, $upit);
    

    $odgovor = "<br><br>
        <h5>AKTIVNE REZERVACIJE:</h5>
        <table class='table table-striped'>
            <thead>
                <tr>
                <th scope='col'>NAZIV KNJIGE</th>
                <th scope='col'>POCETAK REZERVACIJE</th>
                <th scope='col'>KRAJ REZERVACIJE</th>
                <th scope='col'></th>
                </tr>
            </thead>
            <tbody>";

    while($red = mysqli_fetch_assoc($rez)) {

        $odgovor.="<tr>
            <th scope='row'>{$red['NAZIV_KNJIGA']}</th>
            <td>{$red['POCETAK_REZERVACIJA']}</td>
            <td>{$red['KRAJ_REZERVACIJA']}</td>
        </tr>";
    }

    $odgovor .="
        </tbody>
    </table>";
    echo $odgovor;


  // ZATVARANJE BAZE
    mysqli_close($database);

?>
