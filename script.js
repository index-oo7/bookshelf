
  var btnDodajKnjigu = document.getElementById("btnDodajKnjigu");
  var DodavanjeKnjige = document.getElementById("DodavanjeKnjige");
  var pozadina = document.getElementById("pozadina");
  
  btnDodajKnjigu.onclick = function() {
    DodavanjeKnjige.style.display = "block";
    pozadina.style.display = "block";
  }

  pozadina.onclick = function() {
    DodavanjeKnjige.style.display = "none";
    pozadina.style.display = "none";
    document.body.style.overflow = "auto";
  }