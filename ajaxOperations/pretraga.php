<?php
    //KONEKCIJA NA BAZU
        $database = mysqli_connect("localhost", "root", "", "bookshelf");
        mysqli_query($database, "SET NAMES utf8");

        if (!$database) {
            die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }
    // PRETRAGA
        $terminPretrage = $_POST['terminPretrage'];
        $upit = "SELECT *
        FROM knjiga
        LEFT JOIN autorizacija ON knjiga.ID_KNJIGA = autorizacija.ID_KNJIGA
        LEFT JOIN autor ON autorizacija.ID_AUTOR = autor.ID_AUTOR
        WHERE LOWER(knjiga.NAZIV_KNJIGA) LIKE LOWER('%{$terminPretrage}%') OR LOWER(autor.IME_AUTOR) LIKE LOWER('%{$terminPretrage}%') 
        AND STATUS_KNJIGA = 1 AND STATUS_AUTOR = 1";
        $rez = mysqli_query($database, $upit);


        $odgovor="<div class='row' style='margin: 20px;'>";
        $i = 1;

  while ($red = mysqli_fetch_assoc($rez)) {
      // Dohvatanje svih autora za datu knjigu
      $knjigaID = $red['ID_KNJIGA'];
      $autorUpit = "SELECT a.IME_AUTOR FROM autor a
                    INNER JOIN autorizacija az ON a.ID_AUTOR = az.ID_AUTOR
                    WHERE az.ID_KNJIGA = $knjigaID";

      $autorRez = mysqli_query($database, $autorUpit);
      $autori = array();

      while ($autorRed = mysqli_fetch_assoc($autorRez)) {
          $autori[] = $autorRed['IME_AUTOR'];
      }

      $autoriString = implode(', ', $autori);

      if ($i % 6 != 0) {
          $odgovor .= "<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}'>
                          <div class='card'>
                              <img src='{$red['SLIKA_KNJIGA']}' class='card-img-top'>
                              <div class='card-body'>
                                  <h5 class='card-title'>{$red['NAZIV_KNJIGA']}</h5>
                                  <p class='card-text'><span class='autor'>$autoriString</span></p>
                              </div>
                          </div>
                      </div>";
      } else {
          $odgovor .= "<div class='col-md-2 knjiga' id='{$red['ID_KNJIGA']}'>
                          <div class='card'>
                          <img src='{$red['SLIKA_KNJIGA']}' class='card-img-top'>
                              <div class='card-body'>
                                  <h5 class='card-title'>{$red['NAZIV_KNJIGA']}</h5>
                                  <p class='card-text'><span class='autor'>$autoriString</span></p>
                              </div>
                          </div>
                      </div>
                      </div>"; // postoji jos jedan div koji zatvara red jer je 6. knjiga prikazana
          $odgovor .= "<div class='row'  style='margin: 20px;'>";
      }

      $i++;
  }

            if($i % 6 != 0) $odgovor.="</div>";

        echo $odgovor;
    //ZATVARANJE BAZE
        mysqli_close($database);

?>
