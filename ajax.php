<?php
// KUPIMO FUNKCIJU I KONEKTUJEMO SE NA BAZU
$funkcija=$_GET['funkcija'];

$database=mysqli_connect("localhost", "root", "", "pva");
mysqli_query($database, "SET NAMES utf8");


// DEFINICIJA FUNKCIJE ZA PRIKAZ
if($funkcija=="prikaziKnjige"){
    $odgovor="";
    $upit="SELECT * FROM korisnici";
    $rez=mysqli_query($db, $upit);
    while($red=mysqli_fetch_assoc($rez))
        $odgovor.="<div>{$red['id']}: {$red['ime']} {$red['prezime']} ({$red['status']}) - <font color='red'>{$red['lozinka']}</font></div>";
    echo $odgovor;
}

// ZATVARANJE BAZE
mysqli_close($db);
?>