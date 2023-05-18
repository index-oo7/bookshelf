class knjiga {
    constructor(naziv, autor, brojStrana, godinaIzdavanja, kategorija ){
        this.id;
        this.status;
        this.naziv = naziv;
        this.autor = autor;
        this.brojStrana = brojStrana;
        this.godinaIzdavanja = godinaIzdavanja;
        this.kategorija = kategorija;
    }
}

class autor{
    constructor(ime, prezime){
        this.id;
        this.ime = ime;
        this.prezime = prezime;
    }
}

class korisnik{
    constructor(ime, lozinka, uloga){
        this.id;
        this.ime = ime;
        this.lozinka = lozinka;
        this.uloga = uloga;
    }
}

class Rezervacija {
    constructor(idKorisnik, pocetakRezervacije, krajRezervacije){
        this.id;
        this.korisnik = idKorisnik;
        this.pocetakRezervacije = pocetakRezervacije;
        this.krajRezervacije = krajRezervacije;
    }
}

