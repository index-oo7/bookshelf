
  var btnAdd = document.getElementById("btnAdd");
  var adding = document.getElementById("adding");
  var background = document.getElementById("background");
  
  // btnComments.onclick = function(){
  //   comments.style.display = "block";
  //   background.style.display = "block";
  // }

  btnAdd.onclick = function() {
    adding.style.display = "block";
    background.style.display = "block";
  }

  background.onclick = function() {
    adding.style.display = "none";
    background.style.display = "none";
    document.body.style.overflow = "auto";
  }