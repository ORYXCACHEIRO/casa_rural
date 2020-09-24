<?php 

if(!isset($_SESSION)){ //Se ainda n?o existir a sess?o
	
	session_start(); //criar a sess?o
}

require "bd.php"; 

$data = $_POST['image'];

$foto = $_POST['file'];

$extensao = strtolower(substr($foto, -3));

if(empty($foto)){
    echo "<meta http-equiv=refresh content='0; url=?pg=7&m=3'>";exit;
}
else {

if($extensao=="jpg" || $extensao=="png" || $extensao=="jpeg"){	

list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);

$data = base64_decode($data);

$imageName = time().'.jpg';
file_put_contents('img/perfis/'.$imageName, $data);

$sql_perfil3=$conn->query("select idutilizador from utilizadores where idutilizador='".$_SESSION['idutilizador']."'")or die("Erro ao selecionar o nome.");
$ln_perfil3=$sql_perfil3->fetch_assoc();
$id=$ln_perfil3['idutilizador'];

$sql_perfil2=$conn->query("select foto from utilizadores where idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
if($sql_perfil->num_rows>=1){ 
    $ln_perfil2=$sql_perfil2->fetch_assoc();
    unlink("img/perfis/".$ln_perfil2['foto']);
    $sql_insereregisto=$conn->query("Insert into utilizadores (foto) VALUES ('".$imageName."') ") or die("Erro ao inserir o registo");
    
}

else {
    $sql_insereregisto=$conn->query("update utilizadores set foto='".$imageName."' where idutilizador='".$id."'") or die("Falha ao editar o pefil");
}
}

}

?>