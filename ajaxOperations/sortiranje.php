<?php
    //KONEKCIJA NA BAZU
        $funkcija = $_GET['funkcija'];

        $database = mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");

        if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }



    // SORTIRANJE
        if($funkcija == 'sortirajPoKoloni'){
            $kolona = $_POST['kolona'];
            $odgovor="<div class='row' style='margin: 20px;'>";

            // Izvrši SQL upit za sortiranje
            $upit = "SELECT * FROM knjiga ORDER BY " . mysqli_real_escape_string($database, $kolona);
            $rezultat = mysqli_query($database, $upit);
            
            $i=1;
            // Proveri da li je upit uspešno izvršen
            if ($rezultat) {
                // Prikaži rezultate sortiranja
                while ($red = mysqli_fetch_assoc($rezultat)) {
                    if($i % 6 != 0){
                        $odgovor.="<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}' data-toggle='modal' data-target='#exampleModalCenter'>
                          <div class='card'>
                            <div class='card-body'>
                              <h5 class='card-title'>{$red['NAZIV_KNJIGA']}</h5>
                              <p class='card-text'><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span></p>
                            </div>
                          </div>
                        </div>";
                      }else{
                        $odgovor.="<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}' data-toggle='modal' data-target='#exampleModalCenter'>
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
                $odgovor = "Došlo je do greške prilikom sortiranja.";
            }

            echo $odgovor;
        }

        if($funkcija == 'sortirajDostupno'){


            // blok koji se izvrsava kada god izlistavamo dostupno i rezervisano da proverimo kojoj knjizi je rezervacija istekla
            $trenutniDatum = date("Y-m-d H:i:s");
            $upitBrisanje = "DELETE FROM rezervacija WHERE KRAJ_REZERVACIJA < '$trenutniDatum'";
            mysqli_query($database, $upitBrisanje);





            $odgovor="<div class='row' style='margin: 20px;'>";
            $i = 1;
            // Izvrši SQL upit za prikaz nerezervisanih knjiga
            $upit = "SELECT * FROM knjiga WHERE ID_KNJIGA NOT IN (SELECT ID_KNJIGA FROM rezervacija)";
            $rezultat = mysqli_query($database, $upit);
            
            // Proveri da li je upit uspešno izvršen
            if ($rezultat) {
                // Prikaži rezultate sortiranja
                while ($red = mysqli_fetch_assoc($rezultat)) {
                    if($i % 6 != 0){
                        $odgovor.="<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}' data-toggle='modal' data-target='#exampleModalCenter'>
                          <div class='card'>
                            <div class='card-body'>
                              <h5 class='card-title'>{$red['NAZIV_KNJIGA']}</h5>
                              <p class='card-text'><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span></p>
                            </div>
                          </div>
                        </div>";
                      }else{
                        $odgovor.="<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}' data-toggle='modal' data-target='#exampleModalCenter'>
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
                $odgovor = "Došlo je do greške prilikom prikaza dostupnih knjiga.";
            }

            echo $odgovor;
        }

        if($funkcija == 'sortirajRezervisano'){
            

            // blok koji se izvrsava kada god izlistavamo dostupno i rezervisano da proverimo kojoj knjizi je rezervacija istekla
            $trenutniDatum = date("Y-m-d H:i:s");
            $upitBrisanje = "DELETE FROM rezervacija WHERE KRAJ_REZERVACIJA < '$trenutniDatum'";
            mysqli_query($database, $upitBrisanje);

            // test rezervacije kada prodje pet dana
            // $trenutniDatum = date("Y-m-d H:i:s", strtotime("+6 days"));

            

            $odgovor="<div class='row' style='margin: 20px;'>";
            $i=1;

            // Izvrši SQL upit za prikaz rezervisanih knjiga
            $upit = "SELECT * FROM knjiga WHERE ID_KNJIGA IN (SELECT ID_KNJIGA FROM rezervacija)";
            $rezultat = mysqli_query($database, $upit);

            //SQL upit koji treba da nam prikaze vreme vazenja rezervacije
            $upitRezervacija = "SELECT * FROM rezervacija";
            $rezultatRezervacija = mysqli_query($database, $upitRezervacija);
            
            
            // Proveri da li je upit uspešno izvršen
            if ($rezultat and $rezultatRezervacija) {
                // Prikaži rezultate sortiranja
                while ($red = mysqli_fetch_assoc($rezultat)) {
                    while($redRezervacija = mysqli_fetch_assoc($rezultatRezervacija)){
                        if($i % 6 != 0){
                            $odgovor.="<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}' data-toggle='modal' data-target='#exampleModalCenter'>
                              <div class='card'>
                                <div class='card-body'>
                                  <h5 class='card-title'>{$red['NAZIV_KNJIGA']}</h5>
                                  <p class='card-text'><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span><br>
                                  Rezervacija vazi do: {$redRezervacija['KRAJ_REZERVACIJA']}</p>
                                </div>
                              </div>
                            </div>";
                          }else{
                            $odgovor.="<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}' data-toggle='modal' data-target='#exampleModalCenter'>
                              <div class='card'>
                                <div class='card-body'>
                                  <h5 class='card-title'>{$red['NAZIV_KNJIGA']}</h5>
                                  <p class='card-text'><span class = 'autor'>{$red['AUTOR_KNJIGA']}</span><br>
                                  Rezervacija vazi do: {$redRezervacija['KRAJ_REZERVACIJA']}</p>
                                </div>
                              </div>
                            </div>
                            </div>"; // postoji jos jedan div koji zatvara red jer je 6. knjiga prikazana
                            $odgovor.="<div class='row'  style='margin: 20px;'>";
                          }
                          $i++;
                    }
                }
                if($i % 6 != 0) $odgovor.="</div>";
            } else {
                $odgovor = "Došlo je do greške prilikom prikaza rezervisanih knjiga.";
            }

            echo $odgovor;
        }

    //ZATVARANJE BAZE
        mysqli_close($database);

?>