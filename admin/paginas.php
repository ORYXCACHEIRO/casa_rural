<?php

//se o $pg for maior do que zero ele chama a página correspondente
if(isset($pg) && $pg>0){
	
	switch($pg){
		case 1: require "utilizadores.php"; break;
		case 2: require "editarutil.php"; break;
		case 3: require "sobre_casa.php"; break;
		case 4: require "contactos.php"; break;
		case 5: require "galeria.php"; break;
		case 6: require "eventos.php"; break;
		case 8: require "a_visitar.php"; break;
		case 9: require "mailbox.php"; break;
		case 10: require "compor.php"; break;
		case 11: require "ver_email.php"; break;
		case 12: require "mailbox_resposta.php"; break;
		case 13: require "editadmin.php"; break;
		case 14: require "editar_page_res.php"; break;
		case 15: require "avaliacoes.php"; break;
		case 16: require "reservas_folders.php"; break;
		case 17: require "faturas.php"; break;
		case 18: require "lista_reservas.php"; break;
	}
}
else{
	$pg=0;
	require "home.php";
} ?>
