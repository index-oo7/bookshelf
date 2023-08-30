<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>encrypt</title>
    </head>
    <body>
        <form method="post">
            <input type="number" name = "id">
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
        $id = $_POST['id'];
        $upit = "SELECT LOZINKA_KORISNIK FROM KORISNIK where ID_KORISNIK = $id";
        $rezultat = mysqli_query($database, $upit);

        while ($red = mysqli_fetch_assoc($rezultat)) {
           
            $string = $red['LOZINKA_KORISNIK'];

            $enkriptovano = hash('sha256', $string, false);

            $enkripcija = "UPDATE KORISNIK SET LOZINKA_KORISNIK = '$enkriptovano' WHERE ID_KORISNIK = $id";

            $enkriptuj = mysqli_query($database, $enkripcija);

        }
    }

        
    mysqli_close($database);
?>