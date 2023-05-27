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
      //Dodajemo globalnu promenljivu
      global $database; 

      $odgovor="";
  
      // Izvršavanje upita za čitanje podataka iz tabele
      $upit="SELECT * FROM knjiga";
      $rez=mysqli_query($database, $upit);
    
      // Provera rezultata upita
      if (mysqli_num_rows($rez) > 0) {
          // Iteriranje kroz svaki red rezultata
          while($red=mysqli_fetch_assoc($rez)){
              // Prikazivanje podataka iz reda
              $odgovor.="<li class='list-group-item'>{$red['ID_KNJIGA']}: {$red['NAZIV_KNJIGA']} <span class = 'autor'> {$red['AUTOR_KNJIGA']} </span> <br>{$red['GODINA_IZDAVANJA_KNJIGA']} {$red['KATEGORIJA']} </li> <br>";
          }
      } else {
          $odgovor = "Nema podataka u tabeli.";
      }
      
      echo $odgovor;
  }





                                                                // DEFINICIJA FUNKCIJE ZA DODAVANJE
function dodajKnjigu(){

    //Dodajemo globalnu promenljivu
    global $database; 

    //Kupimo vrednosti iz post zahteva
    $admin = $_GET['admin'];
    $naziv = $_GET['naziv'];
    $autor = $_GET['autor'];
    $godinaIzdavanja = $_GET['godinaIzdavanja'];
    $kategorija = $_GET['kategorija'];

    $upit = "INSERT INTO knjiga (ID_ADMIN, NAZIV_KNJIGA, AUTOR_KNJIGA, GODINA_IZDAVANJA_KNJIGA, KATEGORIJA) 
    VALUES ({$admin}, '{$naziv}', '{$autor}', {$godinaIzdavanja}, '{$kategorija}')";
    mysqli_query($database, $upit);

    

    return prikaziKnjige();
}





                                                                // DEFINICIJA FUNKCIJE ZA BRISANJE
function obrisiKnjigu(){

    //Dodajemo globalnu promenljivu
    global $database; 

    $odgovor="";
    $id_knjiga = $_POST['id_knjiga'];
    $upit = "DELETE FROM knjiga WHERE ID = '{$id_knjiga}' ;";
    mysqli_query($database, $upit);
    
    
    return prikaziKnjige();
}



if($funkcija == "prikaziKnjige") {
    return prikaziKnjige();
}
  

if($funkcija == "dodajKnjigu") {
   return dodajKnjigu();
}

if($funkcija == "obrisiKnjigu") {
    return obrisiKnjigu();
}








// ZATVARANJE BAZE
mysqli_close($database);
?>