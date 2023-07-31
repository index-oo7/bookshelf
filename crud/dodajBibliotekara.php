<?php
//KONEKCIJA NA BAZU
    $database=mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");

    // Provera konekcije sa bazom
    if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }
    
    if($_POST['ime']!="" and $_POST['prezime']!="" and $_POST['mail']!="" and $_POST['lozinka']!="" and $_POST['potvrda']!=""){

        $ime=$_POST['ime'];
        $prezime=$_POST['prezime'];
        $mail=$_POST['mail'];
        $lozinka=$_POST['lozinka'];
        $potvrda=$_POST['potvrda'];
            

        if($lozinka == $potvrda){
            $upit="CALL DodajKorisnika('$ime', '$prezime', '$mail', '$lozinka', 2)"; // prosledjujemo 2 jer se uvek radi o bibliotekaru
            mysqli_query($database,$upit); 
            
        }else{
            echo "
            <script>
            let greska = document.getElementById('greska');
            greska.innerHTML += `<p class = 'warning'>Pogresna potvrda lozinke, pokusajte ponovo.</p>`
            </script>";
        }
            
    }
    

// ZATVARANJE BAZE
    mysqli_close($database);
    ?>
