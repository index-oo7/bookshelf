<?php
// KUPIMO FUNKCIJU I KONEKTUJEMO SE NA BAZU
$funkcija=$_GET['funkcija'];

$database=mysqli_connect("localhost", "root", "", "homelib");
mysqli_query($database, "SET NAMES utf8");

// Provera konekcije
if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
}

// DEFINICIJA FUNKCIJE ZA PRIKAZ
function prikaziKnjige(){
    $odgovor="";

    // Izvršavanje upita za čitanje podataka iz tabele
    $upit="SELECT * FROM knjiga";
    $rez=mysqli_query($database, $upit);

    // Provera rezultata upita
    if (mysqli_num_rows($rez) > 0) {
        // Iteriranje kroz svaki red rezultata
        while($red=mysqli_fetch_assoc($rez)){
            // Prikazivanje podataka iz reda
            $odgovor.="<li class='list-group-item'>{$red['NAZIV_KNJIGA']} <span class = 'autor'> {$red['AUTOR_KNJIGA']} </span> <br>{$red['GODINA_IZDAVANJA_KNJIGA']} {$red['KATEGORIJA']} </li> <br>";
        }
    } else {
        $odgovor = "Nema podataka u tabeli.";
    }
    
    return $odgovor;
}

// DEFINICIJA FUNKCIJE ZA BRISANJE
function obrisiKnjigu(){
    $odgovor='';
    $id_knjiga = $_POST['id_knjiga']
    $upit = "DELETE FROM knjige WHERE ID = ('{$id_knjiga}') ;";
    $rez = mysqli_query($database, $upit);

    prikaziKnjige()
}




if($funkcija == "prikaziKnjige") prikaziKnjige();

if($funkcija == "dodajKnjigu") dodajKnjigu();

if($funkcija == "obrisiKnjigu") obrisiKnjigu();

if($funkcija == "izmeniKnjigu") izmeniKnjigu();



// ZATVARANJE BAZE
mysqli_close($database);
?>