<?php

//se o $pg for maior do que zero ele chama a página correspondente
if(isset($pg) && $pg>0){
	
	switch($pg){
		case 1: require "casa.php"; break;
		case 2: require "galeria.php"; break;
		case 3: require "contactos.php"; break;
		case 4: require "eventos.php"; break;
		case 5: require "descdetalhes.php"; break;
		case 9: require "reservas.php"; break;
		case 10: require "descobertas.php"; break;
		case 15: require "reservas2.php"; break;	
	}
}
else{
	$pg=0;
	require "home.php";
} ?>
