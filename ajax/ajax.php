<?php


// KUPIMO FUNKCIJU I KONEKTUJEMO SE NA BAZU
$funkcija=$_GET['funkcija'];

$database=mysqli_connect("localhost", "root", "", "homelib");
mysqli_query($database, "SET NAMES utf8");


// Provera konekcije
if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
}



// ZATVARANJE BAZE
mysqli_close($database);
?>