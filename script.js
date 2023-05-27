
  //Dugmad
  var btnDodajKnjigu = document.getElementById("btnDodajKnjigu");
  var btnIzmeniKnjigu = document.getElementById("btnIzmeniKnjigu");
  var btnObrisiKnjigu = document.getElementById("btnObrisiKnjigu");

  //Sekcije
  var izmenaKnjige = document.getElementById("izmenaKnjige");
  var brisanjeKnjige = document.getElementById("brisanjeKnjige");
  var dodavanjeKnjige = document.getElementById("dodavanjeKnjige");

  //Pozadina
  var pozadina = document.getElementById("pozadina");
  


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
    brisanjeKnjige.style.display = "none";
    izmenaKnjige.style.display = "none";
    dodavanjeKnjige.style.display = "none";
    pozadina.style.display = "none";
    document.body.style.overflow = "auto";
  }