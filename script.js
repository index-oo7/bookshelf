
  //Dugmad
  var btnDodajKnjigu = document.getElementById("btnDodajKnjigu");
  var btnIzmeniKnjigu = document.getElementById("btnIzmeniKnjigu");
  var btnObrisiKnjigu = document.getElementById("btnObrisiKnjigu");
  var btnRezervisiKnjigu = document.getElementById("btnRezervisiKnjigu");

  //Sekcije
  var izmenaKnjige = document.getElementById("izmenaKnjige");
  var brisanjeKnjige = document.getElementById("brisanjeKnjige");
  var dodavanjeKnjige = document.getElementById("dodavanjeKnjige");
  var rezervacijaKnjige = document.getElementById("rezervacijaKnjige");

  //Pozadina
  var pozadina = document.getElementById("pozadina");
  

  btnRezervisiKnjigu.onclick = function() {
    rezervacijaKnjige.style.display = "block";
    pozadina.style.display = "block";
  }

  btnObrisiKnjigu.onclick = function() {
    brisanjeKnjige.style.display = "block";
    pozadina.style.display = "block";
  }

  btnIzmeniKnjigu.onclick = function() {
    izmenaKnjige.style.display = "block";
    pozadina.style.display = "block";
  }

  btnDodajKnjigu.onclick = function() {
    dodavanjeKnjige.style.display = "block";
    pozadina.style.display = "block";
  }

  pozadina.onclick = function() {
    rezervacijaKnjige.style.display = "none";
    brisanjeKnjige.style.display = "none";
    izmenaKnjige.style.display = "none";
    dodavanjeKnjige.style.display = "none";
    pozadina.style.display = "none";
    document.body.style.overflow = "auto";
  }