<?php
  //KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
    
    // Provera konekcije sa bazom
    if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }


  $upit = 'SELECT REZERVACIJA.*, KORISNIK.EMAIL_KORISNIK, KNJIGA.NAZIV_KNJIGA
  FROM REZERVACIJA
  JOIN KORISNIK ON REZERVACIJA.ID_KORISNIK = KORISNIK.ID_KORISNIK
  JOIN KNJIGA ON REZERVACIJA.ID_KNJIGA = KNJIGA.ID_KNJIGA
  WHERE REZERVACIJA.STATUS_REZERVACIJA = 1;';

  $rez = mysqli_query($database, $upit);
  

  $odgovor = "<br><br>
    <h5>REZERVACIJE:</h5>
    <table class='table table-striped'>
        <thead>
            <tr>
            <th scope='col'>KORISNICKO IME</th>
            <th scope='col'>NAZIV KNJIGE</th>
            <th scope='col'>POCETAK REZERVACIJE</th>
            <th scope='col'>KRAJ REZERVACIJE</th>
            <th scope='col'></th>
            </tr>
        </thead>
        <tbody>";

  while($red = mysqli_fetch_assoc($rez)) {

    $odgovor.="<tr>
        <th scope='row'>{$red['EMAIL_KORISNIK']}</th>
        <td>{$red['NAZIV_KNJIGA']}</td>
        <td>{$red['POCETAK_REZERVACIJA']}</td>
        <td>{$red['KRAJ_REZERVACIJA']}</td>
        <td><button class='btn btn-danger zaduzi' id='{$red['ID_REZERVACIJA']}'>Zaduzi knjigu</button></td>
    </tr>";
  }

  $odgovor .="
    </tbody>
  </table>";
  echo $odgovor;


  // ZATVARANJE BAZE
    mysqli_close($database);

?>
