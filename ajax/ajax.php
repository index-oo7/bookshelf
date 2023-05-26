<?php
// KUPIMO FUNKCIJU I KONEKTUJEMO SE NA BAZU
$funkcija=$_GET['funkcija'];

$database=mysqli_connect("localhost", "root", "", "homelib");
mysqli_query($database, "SET NAMES utf8");

// DEFINICIJA FUNKCIJE ZA PRIKAZ
function prikaziKnjige(){
    $odgovor="";
    $upit="SELECT * FROM knjiga";
    $rez=mysqli_query($database, $upit);
    while($red=mysqli_fetch_assoc($rez))
        $odgovor.="<li class='list-group-item'>{$red['NAZIV_KNJIGA']} <span class = 'autor'> {$red['AUTOR_KNJIGA']} </span> <br>{$red['GODINA_IZDAVANJA_KNJIGA']} {$red['KATEGORIJA']} </li> <br>";
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



if($funkcija=="prikaziKnjige") prikaziKnjige();

if($funkcija == "obrisiKnjigu") obrisiKnjigu();

// ZATVARANJE BAZE
mysqli_close($database);
?>