<?php
    //KONEKCIJA NA BAZU
        $database = mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");

        if (!$database) {
            die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }
    // PRETRAGA
        $terminPretrage = $_POST['terminPretrage'];
        $upit = "SELECT * FROM knjiga WHERE NAZIV_KNJIGA LIKE '%$terminPretrage%' OR AUTOR_KNJIGA LIKE '%$terminPretrage%'";
        $rez = mysqli_query($database, $upit);


        $odgovor="<div class='row' style='margin: 20px;'>";
        $i=1;
        if (mysqli_num_rows($rez) > 0) {
            while($red = mysqli_fetch_assoc($rez)){
                if($i % 6 != 0){
                  $odgovor.="<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}'>
                    <div class='card'>
                      <div class='card-body'>
                        <h5 class='card-title'>{$red['NAZIV_KNJIGA']}</h5>
                        <p class='card-text'><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span></p>
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
        } else {
            $odgovor = "<p>Nema rezultata za traženi termin pretrage.</p>";
        }

        echo $odgovor;
    //ZATVARANJE BAZE
        mysqli_close($database);

?>
