<?php
class Database{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $name = "homelib";

    function connect(){
        return mysqli_connect($this->host, $this->user, $this->pass, $this->name); 
    }
}


class knjiga {
    public function __construct($naziv, $autor, $brojStrana, $godinaIzdavanja, $kategorija ){
        $this->id;
        $this->status;
        $this->naziv = $naziv;
        $this->autor = $autor;
        $this->brojStrana = $brojStrana;
        $this->godinaIzdavanja = $godinaIzdavanja;
        $this->kategorija = $kategorija;
    }
}

class autor{
    public function __construct($ime, $prezime){
        $this->id;
        $this->ime = $ime;
        $this->prezime = $prezime;
    }
}

class korisnik{
    public function __construct($ime, $lozinka, $uloga){
        $this->id;
        $this->ime = $ime;
        $this->lozinka = $lozinka;
        $this->uloga = $uloga;
    }
}

class Rezervacija {
    public function __construct($idKorisnik, $pocetakRezervacije, $krajRezervacije){
        $this->id;
        $this->korisnik = $idKorisnik;
        $this->pocetakRezervacije = $pocetakRezervacije;
        $this->krajRezervacije = $krajRezervacije;
    }
}

?>