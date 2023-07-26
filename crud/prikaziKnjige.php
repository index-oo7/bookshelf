<?php
  //KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
    
    // Provera konekcije sa bazom
    if (!$database) {
    die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }


  $odgovor="<div class='row' style='margin: 20px;'>";
  $upit = 'SELECT * FROM knjiga';
  $rez = mysqli_query($database, $upit);
  $i=1;
  while($red = mysqli_fetch_assoc($rez)){
    if($i % 6 != 0){
      $odgovor.="<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}'>
        <div class='card'>
          <img src='{$red['SLIKA_KNJIGA']}' class='card-img-top'>
          <div class='card-body'>
            <h5 class='card-title'>{$red['NAZIV_KNJIGA']}</h5>
            <p class='card-text'><span class = 'autor'>AUTOR</span></p>
          </div>
        </div>
      </div>";
    }else{
      $odgovor.="<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}'>
        <div class='card'>
          <div class='card-body'>
            <h5 class='card-title'>{$red['NAZIV_KNJIGA']}</h5>
            <p class='card-text'><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span></p>
          </div>
        </div>
      </div>
      </div>"; // postoji jos jedan div koji zatvara red jer je 6. knjiga prikazana
      $odgovor.="<div class='row'  style='margin: 20px;'>";
    }
    $i++;
  }
  if($i % 6 != 0) $odgovor.="</div>";

  echo $odgovor;

  // ZATVARANJE BAZE
    mysqli_close($database);

?>
<!-- {$red['AUTOR_KNJIGA']} -->