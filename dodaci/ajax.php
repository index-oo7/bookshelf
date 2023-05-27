<?php


// KUPIMO FUNKCIJU I KONEKTUJEMO SE NA BAZU
$funkcija=$_GET['funkcija'];

$database=mysqli_connect("localhost", "root", "", "homelib");
mysqli_query($database, "SET NAMES utf8");


// Provera konekcije
if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
}



$odgovor="";
$funkcija = $_GET['funkcija'];

if($funkcija == 'izmeniKnjigu'){
    $odgovor="";
    $identifikator = $_POST['identifikator'];
    $naziv = $_POST['naziv'];
    $autor = $_POST['autor'];
    $godinaIzdavanja = $_POST['godinaIzdavanja'];
    $kategorija = $_POST['kategorija'];

    $upit = "UPDATE knjiga 
    SET NAZIV_KNJIGA = '{$naziv}', AUTOR_KNJIGA = '{$autor}', GODINA_IZDAVANJA_KNJIGA = '{$godinaIzdavanja}', KATEGORIJA = '{$kategorija}'
    WHERE ID_KNJIGA = '{$identifikator}' ";
    mysqli_query($database, $upit);

}






                                                                // DEFINICIJA FUNKCIJE ZA BRISANJE
// function obrisiKnjigu(){

//     //Dodajemo globalnu promenljivu
//     global $database; 

//     $odgovor="";
//     $id_knjiga = $_POST['id_knjiga'];
//     $upit = "DELETE FROM knjiga WHERE ID = '{$id_knjiga}' ;";
//     mysqli_query($database, $upit);
    
    
//     return prikaziKnjige();
// }


// if($funkcija == "obrisiKnjigu") {
//     return obrisiKnjigu();
// }








// ZATVARANJE BAZE
mysqli_close($database);
?>