const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container2');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});

$('input[name="dara"]').mask('00/00/0000');

$('input[name="dara"]').focusout(function(){
   $('input[name="data"]').val( this.value.toUpperCase());
});

