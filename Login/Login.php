<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Prijava</title>
    </head>
    <body>
        <div class="container">
            <form method="post" class="form">
                <h1>Prijava</h1>

                <label for="mail">Mail:</label>
                <input type="text" id="mail" name="mail" required>

                <label for="lozinka">Lozinka:</label>
                <input type="password" id="lozinka" name="lozinka" required>

                <button type="submit" name="btnSubmit">Uloguj se</button>

                <br><br><div class="warning"><p>Nemas nalog?  <b><a href='../SignUp/SignUp.php'>Kreiraj nalog ovde</a></b><br></p></div>
            </form>

            
        </div>

        <!-- PHP -->
        <?php
            $database = mysqli_connect("localhost", "root", "", "bookshelf");
            mysqli_query($database, "SET NAMES utf8");
            
            if (!$database) {
                die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
            }

        if(isset($_POST['btnSubmit'])){
                $mail = $_POST['mail'];
                $lozinka = $_POST['lozinka'];

                $provera = "SELECT * FROM KORISNIK WHERE EMAIL_KORISNIK LIKE '$mail' AND LOZINKA_KORISNIK LIKE '$lozinka' AND STATUS_KORISNIK = 1";
                $rezultat = mysqli_query($database, $provera);
                $red = mysqli_fetch_assoc($rezultat);

                $zabrana = "SELECT * FROM KORISNIK WHERE EMAIL_KORISNIK LIKE '$mail' AND LOZINKA_KORISNIK LIKE '$lozinka' AND STATUS_KORISNIK = 0";
                $rezultatZabrane = mysqli_query($database, $zabrana);
                $redZabrane = mysqli_fetch_assoc($rezultatZabrane);

                if($red!=null){
                    

                    $_SESSION['korisnik'] = $red['ID_KORISNIK']; //ako korisnik postoji, odmah otvaram sesiju sa id-jem koji ce posle biti koriscen za rezervaciju
                    $_SESSION['uloga'] = $red['ID_ULOGA'];
                    $_SESSION['korime'] = $red['EMAIL_KORISNIK'];
                    
                    $id_uloga = $red['ID_ULOGA'];

                    switch ($id_uloga){
                        case 1:
                            header('Location: ../indexAdmin.php');//korisnik
                            exit;
                        case 2:
                            header('Location: ../indexBibliotekar.php');//korisnik
                            exit;
                        case 3:
                            header('Location: ../indexUser.php');//korisnik
                            exit;
                    }
                }else if($rezultatZabrane!=null){
                    echo "<script>
                    let warning = document.querySelector('.warning');
                    warning.innerHTML = `<p>Nalog je suspendovan.</p>`;
                    </script>";
                }else{
                    echo "<script>
                    let warning = document.querySelector('.warning');
                    warning.innerHTML += `<br><br><p>Nalog ne postoji ili je lozinka pogrešna. Registrujte se <b><a href='../SignUp/SignUp.php'>ovde</a></b><br></p>`;
                    </script>";
                }
            }
        
        mysqli_close($database);
        ?>


    </body>
</html>