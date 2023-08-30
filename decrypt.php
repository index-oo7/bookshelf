<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>decrypt</title>
    </head>
    <body>
        <form method="post">
            <input type="text" name = "mail" placeholder = "mail"><br>
            <input type="text" name = "password" placeholder = "password"><br><br>

            <button name = "dugme">dugme</button>

        </form>
    </body>
</html>


<?php

    $database = mysqli_connect("localhost", "root", "", "bookshelf");
    mysqli_query($database, "SET NAMES utf8");
            
    if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
    }

    if(isset($_POST['dugme'])){

        $mail = $_POST['mail'];
        $password = $_POST['password'];

        $upit = "SELECT * FROM KORISNIK WHERE EMAIL_KORISNIK = '$mail'";
        $rezultat = mysqli_query($database, $upit);

        while ($red = mysqli_fetch_assoc($rezultat)) {
           
            $string = hash('sha256', $password, false);

            echo("uneta lozinka: " . $password . "<BR>");
            echo("lozinka u bazi: " . $red['LOZINKA_KORISNIK'] . "<BR>");
            echo("hesovana lozinka: " . $string. "<BR>");

            if(substr($string,0,15) == $red['LOZINKA_KORISNIK']){
                var_dump($red['IME_KORISNIK']);
            }else{
                echo("pogresno");
            }
        }
    }

        
    mysqli_close($database);
?>