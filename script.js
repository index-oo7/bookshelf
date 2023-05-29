
  //Dugme
  var btnRezervisiKnjigu = document.getElementById("btnRezervisiKnjigu");

  //Sekcija
  var rezervacijaKnjige = document.getElementById("rezervacijaKnjige");

  //Pozadina
  var pozadina = document.getElementById("pozadina");
  

  btnRezervisiKnjigu.onclick = function() {
    rezervacijaKnjige.style.display = "block";
    pozadina.style.display = "block";
  }

  pozadina.onclick = function() {
    rezervacijaKnjige.style.display = "none";
    pozadina.style.display = "none";
    document.body.style.overflow = "auto";
  }