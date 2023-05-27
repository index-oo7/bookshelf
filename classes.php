<?php

class knjiga {
    public $id;
    public $naziv;
    public $autor;
    public $godinaIzdavanja;
    public $kategorija;

    public function __construct($naziv, $autor, $godinaIzdavanja, $kategorija ){
        $this->id;
        $this->naziv = $naziv;
        $this->autor = $autor;
        $this->godinaIzdavanja = $godinaIzdavanja;
        $this->kategorija = $kategorija;
    }
}

class admin{
    public $id;
    public $ime;
    public $lozinka;

    public function __construct($ime, $lozinka){
        $this->id;
        $this->ime = $ime;
        $this->lozinka = $lozinka;
    }
}

class korisnik{
    public $id;
    public $ime;
    public $lozinka;

    public function __construct($ime, $lozinka){
        $this->id;
        $this->ime = $ime;
        $this->lozinka = $lozinka;
    }
}

class Rezervacija {
    public $idKorisnik;
    public $idKnjiga;
    public $pocetakRezervacije;
    public $krajRezervacije;

    public function __construct($idKorisnik, $idKnjiga, $pocetakRezervacije, $krajRezervacije){
        $this->id;
        $this->korisnik = $idKorisnik;
        $this->pocetakRezervacije = $pocetakRezervacije;
        $this->krajRezervacije = $krajRezervacije;
    }
}

?>