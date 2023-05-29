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
        <form action="login.php" method="post" class="form">
            <h1>Registracija</h1>

            <label for="ime">ime:</label>
            <input type="text" id="ime" name="ime" required>

            <label for="lozinka">lozinka:</label>
            <input type="password" id="lozinka" name="lozinka" required>

            <a href="../Login/Login.php" style="color: white; text-decoration: none;"> <button type="submit" name="btnSubmit">Registruj se</button></a>
            <div class="warning"><p>Već imate nalog? <b><a href='../Login/Login.php'>Prijavite se</a></b><br></p></div>
        </form>
    </div>
           
      <?php
        $database = mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");
        
        if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }

        if(isset($_POST['btnSubmit'])){
            if($_POST['ime']!="" and $_POST['lozika']!=""){

                $ime=$_POST['ime'];
                $lozinka=$_POST['lozinka'];
                
                
                $upit="INSERT INTO korisnik (IME_KORISNIK,LOZINKA_KORISNIK) values ('$ime','$lozinka')";
                mysqli_query($database,$upit);
            }
        }
        mysqli_close($database);
    ?>
</body>
</html>