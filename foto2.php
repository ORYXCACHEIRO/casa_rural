<?php 

if(!isset($_SESSION)){ //Se ainda n?o existir a sess?o
	
	session_start(); //criar a sess?o
}

require "bd.php"; 

$data = $_POST['image'];

list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);

$data = base64_decode($data);
$imageName = time().'.jpg';


$sql_perfil3=$conn->query("select foto, idutilizador from utilizadores where idutilizador='".$_SESSION['idutilizador']."'")or die("Erro ao selecionar o nome.");
$ln_perfil3=$sql_perfil3->fetch_assoc();
$id=$ln_perfil3['idutilizador'];
$foto=$ln_perfil3['foto'];

if($foto!=""){

file_put_contents('img/perfis/'.$imageName, $data);

$sql_perfil2=$conn->query("select foto from utilizadores where idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
if($sql_perfil->num_rows>=1){ 
    $foto = $ln_perfil2['foto'];
    $ln_perfil2=$sql_perfil2->fetch_assoc();
    $sql_insereregisto=$conn->query("Insert into utilizadores (foto) VALUES ('".$imageName."') ") or die("Erro ao inserir o registo");
    
}

else {
    unlink("img/perfis/$foto.jpg");
    $sql_insereregisto=$conn->query("update utilizadores set foto='".$imageName."' where idutilizador='".$id."'") or die("Falha ao editar o pefil");
}
}



?>