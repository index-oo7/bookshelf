<?php
  //KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
    
    // Provera konekcije sa bazom
    if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }


  $upit = 'SELECT k.*, u.NAZIV_ULOGA FROM korisnik k
        INNER JOIN uloga u ON k.ID_ULOGA = u.ID_ULOGA
        WHERE k.STATUS_KORISNIK = 1;';

  $rez = mysqli_query($database, $upit);
  

  $odgovor = "
    <h5>AKTIVNI KORISNICI:</h5>
    <table class='table table-striped'>
        <thead>
            <tr>
            <th scope='col'>ID</th>
            <th scope='col'>IME</th>
            <th scope='col'>PREZIME</th>
            <th scope='col'>E-MAIL</th>
            <th scope='col'>ULOGA</th>
            <th scope='col'></th>
            </tr>
        </thead>
        <tbody>";

  while($red = mysqli_fetch_assoc($rez)) {

    $odgovor.="<tr>
        <th scope='row'>{$red['ID_KORISNIK']}</th>
        <td>{$red['IME_KORISNIK']}</td>
        <td>{$red['PREZIME_KORISNIK']}</td>
        <td>{$red['EMAIL_KORISNIK']}</td>
        <td>{$red['NAZIV_ULOGA']}</td>
        <td><button class='btn btn-danger deaktiviraj' id='{$red['ID_KORISNIK']}'>Deaktiviraj</button></td>
    </tr>";
  }

  $odgovor .="
    </tbody>
  </table>";
  echo $odgovor;


  // ZATVARANJE BAZE
    mysqli_close($database);

?>
