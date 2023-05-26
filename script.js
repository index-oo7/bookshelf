
  var btnDodajKnjigu = document.getElementById("btnDodajKnjigu");
  var dodavanjeKnjige = document.getElementById("dodavanjeKnjige");
  var pozadina = document.getElementById("pozadina");
  
  btnDodajKnjigu.onclick = function() {
    dodavanjeKnjige.style.display = "block";
    pozadina.style.display = "block";
  }

  pozadina.onclick = function() {
    dodavanjeKnjige.style.display = "none";
    pozadina.style.display = "none";
    document.body.style.overflow = "auto";
  }