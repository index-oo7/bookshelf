<?php

$database=mysqli_connect("localhost", "root", "", "homelib");
mysqli_query($database, "SET NAMES utf8");


// Provera konekcije
if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
}


    //Kupimo vrednosti iz post zahteva
    $admin = $_POST['admin'];
    $naziv = $_POST['naziv'];
    $autor = $_POST['autor'];
    $godinaIzdavanja = $_POST['godinaIzdavanja'];
    $kategorija = $_POST['kategorija'];

    $upit = "INSERT INTO knjiga (ID_ADMIN, NAZIV_KNJIGA, AUTOR_KNJIGA, GODINA_IZDAVANJA_KNJIGA, KATEGORIJA) 
    VALUES ({$admin}, '{$naziv}', '{$autor}', {$godinaIzdavanja}, '{$kategorija}')";
    mysqli_query($database, $upit);

    // Nakon 
    header("Location: index.php");


// ZATVARANJE BAZE
mysqli_close($database);
?>