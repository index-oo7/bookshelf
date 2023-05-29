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
        <form action="login.php" method="post" class="form">
            <h1>Prijava</h1>

            <label for="ime">ime:</label>
            <input type="text" id="ime" name="ime" required>

            <label for="lozinka">lozinka:</label>
            <input type="password" id="lozinka" name="lozinka" required>

            <label for="izbor">Izaberite ulogu:</label>
            <select name="izbor" id="izbor">
                <option value="korisnik">Korisnik</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" name="btnSubmit">Uloguj se</button>
        </form>
    </div>

      <!-- PHP -->
    <?php
        $database = mysqli_connect("localhost", "root", "", "homelib");
        mysqli_query($database, "SET NAMES utf8");
        
        if (!$database) {
        die("Greška prilikom povezivanja sa bazom podataka: " . mysqli_connect_error());
        }


       if(isset($_POST['btnSubmit'])){
        
        if(isset($_POST['ime']) and isset($_POST['lozinka']) and $_POST['izbor'] == 'korisnik'){
            $ime=$_POST['ime'];
            $lozinka=$_POST['lozinka'];

            $upit="SELECT ID_KORISNIK FROM korisnik where IME_KORISNIK like '$ime' and LOZINKA_KORISNIK='$lozinka'";
            $rez=mysqli_query($database,$upit);
            if(mysqli_num_rows($rez)==0){
                echo "<script>
                let warning = document.querySelector('.form');
                warning.innerHTML += `<br><br><div class='warning'><p>Nalog ne postoji ili je lozinka pogrešna. Registrujte se <b><a href='../SignUp/SignUp.php'>ovde</a></b><br></p></div>`;
                </script>";
            }else{
                $red = mysqli_fetch_assoc($rez);
                $_SESSION['korisnik'] = $red['ID_KORISNIK'];
                header('Location: ../index.php');//korisnik
                exit;
            }
       }

       if(isset($_POST['ime']) and isset($_POST['lozinka']) and $_POST['izbor'] == 'admin'){
        $ime=$_POST['ime'];
        $lozinka=$_POST['lozinka'];

        $upit="SELECT ID_ADMIN FROM admin where IME_ADMIN like '$ime' and LOZINKA_ADMIN='$lozinka'";
        $rez=mysqli_query($database,$upit);
        if(mysqli_num_rows($rez)==0){
            echo "<script>
            let warning = document.querySelector('.form');
            warning.innerHTML += `<br><br><div class='warning'><p>Nalog ne postoji ili je lozinka pogrešna. Registrujte se <b><a href='../SignUp/SignUp.php'>ovde</a></b><br></p></div>`;
            </script>";
        }else{
            $red = mysqli_fetch_assoc($rez);
            $_SESSION['admin'] = $red['ID_ADMIN'];
            header('Location: ../indexAdmin.php');//admin
            exit;
        }
   }
    }
    
    mysqli_close($database);
    ?>


</body>
</html>