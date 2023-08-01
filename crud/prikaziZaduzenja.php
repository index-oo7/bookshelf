<?php
  //KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
    
    // Provera konekcije sa bazom
    if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }


  $upit = 'SELECT ZADUZENJE.*, KORISNIK.EMAIL_KORISNIK, KNJIGA.NAZIV_KNJIGA
  FROM ZADUZENJE
  JOIN KORISNIK ON ZADUZENJE.ID_KORISNIK = KORISNIK.ID_KORISNIK
  JOIN KNJIGA ON ZADUZENJE.ID_KNJIGA = KNJIGA.ID_KNJIGA
  WHERE ZADUZENJE.STATUS_ZADUZENJE = 1;';

  $rez = mysqli_query($database, $upit);
  

  $odgovor = "<br><br>
    <h5>ZADUZENJA:</h5>
    <table class='table table-striped'>
        <thead>
            <tr>
            <th scope='col'>KORISNICKO IME</th>
            <th scope='col'>NAZIV KNJIGE</th>
            <th scope='col'>POCETAK ZADUZENJA</th>
            <th scope='col'>KRAJ ZADUZENJA</th>
            <th scope='col'></th>
            </tr>
        </thead>
        <tbody>";

  while($red = mysqli_fetch_assoc($rez)) {

    $odgovor.="<tr>
        <th scope='row'>{$red['EMAIL_KORISNIK']}</th>
        <td>{$red['NAZIV_KNJIGA']}</td>
        <td>{$red['POCETAK_ZADUZENJE']}</td>
        <td>{$red['KRAJ_ZADUZENJE']}</td>
        <td><button class='btn btn-danger razduzi' id='{$red['ID_ZADUZENJA']}'>Razduzi knjigu</button></td>
    </tr>";
  }

  $odgovor .="
    </tbody>
  </table>";
  echo $odgovor;


  // ZATVARANJE BAZE
    mysqli_close($database);

?>
