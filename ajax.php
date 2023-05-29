<?php

$funkcija = $_GET['funkcija'];

$database = mysqli_connect("localhost", "root", "", "homelib");
mysqli_query($database, "SET NAMES utf8");

if (!$database) {
  die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
}



if (isset($_POST['terminPretrage'])) {
  $terminPretrage = $_POST['terminPretrage'];
  $upit = "SELECT * FROM knjiga WHERE NAZIV_KNJIGA LIKE '%$terminPretrage%' OR AUTOR_KNJIGA LIKE '%$terminPretrage%'";
  $rez = mysqli_query($database, $upit);

  if (mysqli_num_rows($rez) > 0) {
    echo "<ul>";
    while ($red = mysqli_fetch_assoc($rez)) {
      echo "<li>{$red['NAZIV_KNJIGA']} - {$red['AUTOR_KNJIGA']}</li>";
    }
    echo "</ul>";
  } else {
    echo "<p>Nema rezultata za traženi termin pretrage.</p>";
  }
}


if($funkcija == 'sortirajPoKoloni'){
    $kolona = $_POST['kolona'];
    $odgovor="";

    // Izvrši SQL upit za sortiranje
    $upit = "SELECT * FROM knjiga ORDER BY " . mysqli_real_escape_string($database, $kolona);
    $rezultat = mysqli_query($database, $upit);
    
    // Proveri da li je upit uspešno izvršen
    if ($rezultat) {
        // Prikaži rezultate sortiranja
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $odgovor.="<li class='list-group-item'>{$red['NAZIV_KNJIGA']}<br><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span><br></li>";
        }
    } else {
        $odgovor = "Došlo je do greške prilikom sortiranja.";
    }

    echo $odgovor;
}

if($funkcija == 'sortirajDostupno'){
    $odgovor="";

    // Izvrši SQL upit za prikaz nerezervisanih knjiga
    $upit = "SELECT * FROM knjiga WHERE ID_KNJIGA NOT IN (SELECT ID_KNJIGA FROM rezervacija)";
    $rezultat = mysqli_query($database, $upit);
    
    // Proveri da li je upit uspešno izvršen
    if ($rezultat) {
        // Prikaži rezultate sortiranja
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $odgovor.="<li class='list-group-item'>{$red['NAZIV_KNJIGA']}<br><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span><br></li>";
        }
    } else {
        $odgovor = "Došlo je do greške prilikom prikaza dostupnih knjiga.";
    }

    echo $odgovor;
}

if($funkcija == 'sortirajRezervisano'){
    $odgovor="";

    // Izvrši SQL upit za prikaz rezervisanih knjiga
    $upit = "SELECT * FROM knjiga WHERE ID_KNJIGA IN (SELECT ID_KNJIGA FROM rezervacija)";
    $rezultat = mysqli_query($database, $upit);
    
    // Proveri da li je upit uspešno izvršen
    if ($rezultat) {
        // Prikaži rezultate sortiranja
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $odgovor.="<li class='list-group-item'>{$red['NAZIV_KNJIGA']}<br><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span><br></li>";
        }
    } else {
        $odgovor = "Došlo je do greške prilikom prikaza rezervisanih knjiga.";
    }

    echo $odgovor;
}




mysqli_close($database);


?>


