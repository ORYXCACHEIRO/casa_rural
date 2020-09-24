var modal = document.getElementById("myModal");
var modal2 = document.getElementById("myModal2");
var modal3 = document.getElementById("myModal3");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");
var btn2 = document.getElementById("myBtn2");
var btn3 = document.getElementById("myBtn3");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close2")[0];
var span3 = document.getElementsByClassName("close3")[0];

var btnclose = document.getElementById("butao-modal");
var btnclose2 = document.getElementById("butao-modal2");
var btnclose3 = document.getElementById("butao-modal3");

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

btn2.onclick = function() {
  modal2.style.display = "block";
}

btn3.onclick = function() {
  modal3.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

btnclose.onclick = function() {
  modal.style.display = "none";
}

span2.onclick = function() {
  modal2.style.display = "none";
}

btnclose2.onclick = function() {
  modal2.style.display = "none";
}

span3.onclick = function() {
  modal3.style.display = "none";
}

btnclose3.onclick = function() {
  modal3.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

window.onclick = function(event) {
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
}

window.onclick = function(event) {
  if (event.target == modal3) {
    modal3.style.display = "none";
  }
}

$( "#rotateLeft" ).click(function() {
    $basic.croppie('rotate', parseInt($(this).data('rotate')));
});

$( "#rotateRight" ).click(function() {
    $basic.croppie('rotate',parseInt($(this).data('rotate')));
});

$( "#rotateLeft2" ).click(function() {
    $uploadCrop.croppie('rotate', parseInt($(this).data('rotate')));
});

$( "#rotateRight2" ).click(function() {
    $uploadCrop.croppie('rotate',parseInt($(this).data('rotate')));
});





