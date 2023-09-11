<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <title>Registracija</title>
    </head>
    <body>
        <div class="container">
            <form method="post" class="form">
                <h1>Registracija</h1>

                <label for="ime">Ime:</label>
                <input type="text" id="ime" name="ime" required>

                <label for="prezime">Prezime:</label>
                <input type="text" id="prezime" name="prezime" required>

                <label for="mail">E-Mail:</label>
                <input type="text" id="mail" name="mail" required>

                <label for="lozinka">Lozinka:</label>
                <input type="password" id="lozinka" name="lozinka" required>

                <label for="potvrda">Potvrda lozinke:</label>
                <input type="password" id="potvrda" name="potvrda" required>

                <a href='../Login/Login.php'><button type="submit" name="btnSubmit">Registruj se</button></a>

                <br><br><div class="warning"><p>Već imate nalog? <b><a href='../Login/Login.php'>Prijavite se</a></b><br></p></div>
                <br><div class="notification"><p>Nastavite kao <b><a href='../index.php'>Gost</a></b><br></p></div>
                <div id = "greska"></div>
            </form>
        </div>
        <?php
            $database = mysqli_connect("localhost", "root", "", "bookshelf");
            mysqli_query($database, "SET NAMES utf8");
            
            if (!$database) {
                die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
            }

            if(isset($_POST['btnSubmit'])){
                if($_POST['ime']!="" and $_POST['prezime']!="" and $_POST['mail']!="" and $_POST['lozinka']!="" and $_POST['potvrda']!=""){

                    $ime=$_POST['ime'];
                    $prezime=$_POST['prezime'];
                    $mail=$_POST['mail'];
                    $lozinka=$_POST['lozinka'];
                    $potvrda=$_POST['potvrda'];
                    

                    if($lozinka == $potvrda){
                        $lozinka = hash('sha256', $lozinka, false);
                        $upit="CALL DodajKorisnika('$ime', '$prezime', '$mail', '$lozinka', 3)"; // prosledjujemo 3 jer se uvek radi o korisniku
                        
                        if(mysqli_query($database,$upit)){
                            echo "
                            <script>
                            let greska = document.getElementById('greska');
                            greska.innerHTML += `<br><p class = 'notification'>Uspesna registracija, prijavite se <b><a href='../indexUser.php'>ovde</a></b> </p>`
                            </script>";
                        }

                    }else{
                        echo "
                        <script>
                        let greska = document.getElementById('greska');
                        greska.innerHTML += `<br><p class = 'warning'>Pogresna potvrda lozinke, pokusajte ponovo.</p>`
                        </script>";
                    }
                    
                }
            }
            mysqli_close($database);
        ?>
    </body>
</html>