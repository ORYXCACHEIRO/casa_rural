<?php 

include 'php-image-resize/lib/ImageResize.php';

use \Gumlet\ImageResize;

if(isset($_POST['troca']) && $_POST['troca']=="Troca"){

  $antiga = $_POST['foto_atual'];
  $nova = $_POST['foto_muda'];

  $sql_antiga=$conn->query("select * from galeria_visita where idfoto_visita='".$antiga."'")or die("Erro ao selecionar o perfil.");
  $ln_antiga=$sql_antiga->fetch_assoc();

  $foto_ant = $ln_antiga['foto'];

  $sql_nova=$conn->query("select * from galeria_visita where idfoto_visita='".$nova."'")or die("Erro ao selecionar o perfil.");
  $ln_nova=$sql_nova->fetch_assoc();

  $foto_no = $ln_nova['foto'];

  $sql_antiga2=$conn->query("Insert into swap_image (idtroca, foto) VALUES ('".$antiga."', '".$foto_ant."') ") or die("Erro ao inserir o registo");

  $sql_nova2=$conn->query("Insert into swap_image (idtroca, foto) VALUES ('".$nova."', '".$foto_no."') ") or die("Erro ao inserir o registo");

  $sql_antiga3=$conn->query("select * from swap_image where idtroca='".$antiga."'")or die("Erro ao selecionar o perfil.");
  $ln_antiga3=$sql_antiga3->fetch_assoc();

  $foto_ant3 = $ln_antiga3['foto'];

  $sql_nova3=$conn->query("select * from swap_image where idtroca='".$nova."'")or die("Erro ao selecionar o perfil.");
  $ln_nova3=$sql_nova3->fetch_assoc();

  $foto_no3 = $ln_nova3['foto'];

  $update_antiga=$conn->query("update galeria_visita set foto='".$foto_no3."' where idfoto_visita='".$antiga."'") or die("Falha o utilizador.");

  $update_antiga=$conn->query("update galeria_visita set foto='".$foto_ant3."'  where idfoto_visita='".$nova."'") or die("Falha o utilizador.");

  $delete_nova=$conn->query("delete FROM swap_image where idtroca='".$antiga."'") or die("Falha ao eliminar o utilizador.");

  $delete_antiga=$conn->query("delete FROM swap_image where idtroca='".$nova."'") or die("Falha ao eliminar o utilizador.");

  if(isset($delete_antiga)){
    
    echo "<meta http-equiv=refresh content='0; url=?pg=8&m=9'>";exit;
  }
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
  }

}
	
if(isset($_POST['delete']) && $_POST['delete']=="Delete"){

    $id = $_POST['delete_visita'];

    $sql_not=$conn->query("select foto, fotoban from visitas where idvisita='".$id."'")or die("Erro ao selecionar o perfil.");
    $ln_not=$sql_not->fetch_assoc();

    $sql_not2=$conn->query("select foto from galeria_visita where idvisita='".$id."'")or die("Erro ao selecionar o perfil.");
    while($ln_not2=$sql_not2->fetch_assoc()){
      $fotos = $ln_not2['foto'];
      unlink("../img/blog/blog-details/$fotos");
    }
    
    $foto = $ln_not['foto'];
    $fotoban = $ln_not['fotoban'];

    $delete=$conn->prepare("DELETE FROM visitas where idvisita=?") or die("Falha ao eliminar o utilizador.");
    $delete2=$conn->prepare("DELETE FROM galeria_visita where idvisita=?") or die("Falha ao eliminar o utilizador.");

    $delete->bind_param("i", $id);
    $delete2->bind_param("i", $id);

    unlink("../img/blog/$foto");
    unlink("../img/blog/blog-hero/$fotoban");

    $delete->execute();
    $delete2->execute();
    

    if($delete->error || $delete2->error ){
      echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
      $delete->close();
      $delete2->close();
		}		
		else{
      echo "<meta http-equiv=refresh content='0; url=?pg=8&m=19'>";exit;
      $delete->close();
      $delete2->close();
		}

}

if(isset($_POST['editar3']) && $_POST['editar3']=="Editar3"){

  $id2 = $_POST['visita'];

  $result2 = 1;
  $update=$conn->prepare("update visitas set ativo=? where idvisita=?") or die("Falha o utilizador.");

  $update->bind_param("ii", $result2, $id2);

  $update->execute();

  if($update->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
    $update->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=8&m=12'>";exit;
    $update->close();
  }
}

if(isset($_POST['editar4']) && $_POST['editar4']=="Editar4"){

  $id2 = $_POST['visita'];

  $result = 0;
  $update=$conn->prepare("update visitas set ativo=? where idvisita=?") or die("Falha o utilizador.");

  $update->bind_param("ii", $result, $id2);

  $update->execute();

  if($update->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
    $update->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=8&m=13'>";exit;
    $update->close();
  }
}


//Inserir Imagens para BD
if(isset($_POST['enviar2']) && $_POST['enviar2']=="Enviar2"){

  $foto = $_FILES['fotop']['name'];
  $fotos = $_FILES['fotos']['name'];
  $fotoban = $_FILES['fotoban']['name'];
  $pt = addslashes($_POST['editor1']);
  $es = addslashes($_POST['editor2']);
  $en = addslashes($_POST['editor3']);
  $nome = addslashes($_POST['nome']);
  $proximo = false;

  if( empty(trim($_POST['editor1'])) || empty(trim($_POST['editor2'])) || empty(trim($_POST['editor3'])) || empty(trim($_POST['nome']))){
    echo "<meta http-equiv=refresh content='0; url=?pg=8&z=1'>";exit;
  } else {
  
    $msg = false;
    if(isset($_FILES['fotop'])){
    $extensao= strtolower (substr($_FILES['fotop']['name'], -4));
    $novo_nome= md5(time()+1000).$extensao;
    $diretorio="../img/blog/";
    $temporario="../img/temporario/";
    $target_file = $diretorio.$novo_nome;
    
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png");
  
    // Check extension
    if( in_array($imageFileType,$extensions_arr)){	

    move_uploaded_file($_FILES['fotop']['tmp_name'], $temporario.$novo_nome);

    $image = new ImageResize($temporario.$novo_nome);
    $image->resize(360, 450);
    $image->save($diretorio.$novo_nome);
      
    $foto=$novo_nome;
    $casa=1;
  
    $sql_insereregisto=$conn->prepare("Insert into visitas (nome, texto_pt, texto_en, texto_es, foto) VALUES (?, ?, ?, ?, ?) ") or die("Erro ao inserir o registo");
      
    $sql_insereregisto->bind_param("sssss", $nome, $pt, $en, $es, $foto);
  
    $sql_insereregisto->execute();
  
    if($sql_insereregisto->error){
      
      $sql_insereregisto->close();
    }
    else{
      move_uploaded_file($_FILES['fotop']['tmp_name'], $diretorio.$novo_nome);
      unlink($temporario.$novo_nome);
      
      $sql_insereregisto->close();
      $proximo = true;
    }
  
    }
    else {
      echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
    }
  }

  if(isset($_FILES['fotos']) && $proximo){

    $targetDir = "../img/blog/blog-details/"; 
    $temporario="../img/temporario/";
    $allowTypes = array('jpg','png','jpeg'); 
    $proximo2 = false;
     
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
    $fileNames = array_filter($_FILES['fotos']['name']); 

    if(!empty($fileNames)){ 
      foreach($_FILES['fotos']['name'] as $key=>$val){ 
          // File upload path 
          $nome = strtolower (substr($_FILES['fotos']['name'][$key], 5));
          $extensao = strtolower (substr($_FILES['fotos']['name'][$key], -4));
          $fileName = md5($nome.time()).$extensao;
          $targetFilePath = $targetDir . $fileName; 
          $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

          move_uploaded_file($_FILES['fotos']['tmp_name'][$key], $temporario.$fileName);
          $image = new ImageResize($temporario.$fileName);
          $image->resize(317, 240);
          $image->save($targetDir.$fileName);

          $insert2 = $conn->query("select idvisita, foto from visitas order by idvisita desc limit 1")or die("Erro"); 
          $row=$insert2->fetch_assoc();
          $foto = $row['foto'];
           
          // Check whether file type is valid 
          
          if(in_array($fileType, $allowTypes)){ 
              // Upload file to server 
              
              $insert = $conn->query("insert into galeria_visita (foto, idvisita, ext) VALUES ('".$fileName."', '".$row['idvisita']."' , '".$extensao."')")or die("Erro2"); 
              if($insert){ 
                  move_uploaded_file($_FILES["fotos"]["tmp_name"][$key], $targetFilePath);
                  unlink($temporario.$fileName);
              } else {
                unlink("../img/blog/$foto");
                $delete=$conn->prepare("DELETE FROM visitas where idvisita='".$row['idvisita']."'") or die("Falha ao eliminar o utilizador.");
                echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
              }
          }
          else{ ~
              unlink("../img/blog/$foto");
              $delete=$conn->prepare("DELETE FROM visitas where idvisita='".$row['idvisita']."'") or die("Falha ao eliminar o utilizador.");
              echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
          } 
      }
      $proximo2 = true;
       
    }

  }

  if(isset($_FILES['fotoban']) && $proximo2){

      if(isset($_FILES['fotoban'])){
      $extensao= strtolower (substr($_FILES['fotoban']['name'], -4));
      $novo_nome= md5(time()+1000).$extensao;
      $diretorio="../img/blog/blog-hero/";
      $temporario="../img/temporario/";
      $target_file = $diretorio.$novo_nome;
      
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $extensions_arr = array("jpg","jpeg","png");
      
      $insert2 = $conn->query("select idvisita, foto from visitas order by idvisita desc limit 1")or die("Erro"); 
      $row=$insert2->fetch_assoc();
      $foto_ant = $row['foto'];

        if( in_array($imageFileType,$extensions_arr)){	

          move_uploaded_file($_FILES['fotoban']['tmp_name'], $temporario.$novo_nome);

            $image = new ImageResize($temporario.$novo_nome);
            $image->resize(1900, 530);
            $image->save($diretorio.$novo_nome);

            $foto=$novo_nome;

            $insert = $conn->query("Update visitas set fotoban='".$foto."' where idvisita='".$row['idvisita']."'")or die("Erro2"); 
            if($insert){ 
              move_uploaded_file($_FILES['fotoban']['tmp_name'], $diretorio.$novo_nome);
              unlink($temporario.$novo_nome);
              echo "<meta http-equiv=refresh content='0; url=?pg=8&m=18'>";exit;
            } else {
              $insert3 = $conn->query("select foto from galeria_visita where idvisita='".$row['idvisita']."'")or die("Erro"); 
              while($row2=$insert3->fetch_assoc()){
                unlink("../img/blog/blog-details/$fotos");
              }
              $delete=$conn->prepare("DELETE FROM galeria_visita where idvisita='".$row['idvisita']."'") or die("Falha ao eliminar o utilizador.");
              unlink("../img/blog/$foto_ant");
              $delete=$conn->prepare("DELETE FROM visitas where idvisita='".$row['idvisita']."'") or die("Falha ao eliminar o utilizador.");
              echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
            }

        } else {

          $insert3 = $conn->query("select foto from galeria_visita where idvisita='".$row['idvisita']."'")or die("Erro"); 
          while($row2=$insert3->fetch_assoc()){
            unlink("../img/blog/blog-details/$fotos");
          }
          $delete=$conn->prepare("DELETE FROM galeria_visita where idvisita='".$row['idvisita']."'") or die("Falha ao eliminar o utilizador.");
          unlink("../img/blog/$foto_ant");
          $delete=$conn->prepare("DELETE FROM visitas where idvisita='".$row['idvisita']."'") or die("Falha ao eliminar o utilizador.");
          echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;

        }
      }

  }

  }
  
}



if(isset($_POST['editfban']) && $_POST['editfban']=="Editfban"){

  $fotoban2 = $_FILES['fotoban']['name'];
  $id = $_POST['idvisita'];

  if(empty($fotoban2)){
    echo "<meta http-equiv=refresh content='0; url=?pg=8&z=1'>";exit;
  } else {
    $extensao= strtolower (substr($_FILES['fotoban']['name'], -4));
    $novo_nome= md5(time()).$extensao;
    $diretorio="../img/blog/blog-hero/";
    $temporario="../img/temporario/";
    $target_file = $diretorio.$novo_nome;
    
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png");

    if( in_array($imageFileType,$extensions_arr) ){	

      move_uploaded_file($_FILES['fotoban']['tmp_name'], $temporario.$novo_nome);
  
      $image = new ImageResize($temporario.$novo_nome);
      $image->resize(1920, 530);
      $image->save($diretorio.$novo_nome);
        
      $foto=$novo_nome;
      $casa=1;

      $foto_delete = $conn->query("select fotoban from visitas where idvisita='".$id."'")or die("Erro"); 
      if($foto_delete->num_rows>=1){
        $row=$foto_delete->fetch_assoc();
        $foto2 = $row['fotoban'];
        unlink("../img/blog/blog-hero/$foto2");
      }
    
      $sql_eventoupdate=$conn->prepare("update visitas set fotoban=? where idvisita=?") or die("Erro ao inserir o registo");
        
      $sql_eventoupdate->bind_param("si",$foto, $id);
    
      $sql_eventoupdate->execute();
    
      if($sql_eventoupdate->error){
        echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
        $sql_eventoupdate->close();
      }
      else{
        move_uploaded_file($_FILES['fotoban']['tmp_name'], $diretorio.$novo_nome);
        unlink($temporario.$novo_nome);
        echo "<meta http-equiv=refresh content='0; url=?pg=8&m=20'>";exit;
        $sql_eventoupdate->close();
      }
    
      }
      else {
        echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
      }

  }

}

if(isset($_POST['enviar3']) && $_POST['enviar3']=="Enviar3"){

    $foto = $_FILES['fotop']['name'];
    $pt = addslashes($_POST['editor4']);
    $es = addslashes($_POST['editor5']);
    $en = addslashes($_POST['editor6']);
    $nome = addslashes($_POST['nome']);
    $id = (int)$_POST['idvisita'];

    if( empty(trim($_POST['editor5'])) || empty(trim($_POST['editor4'])) || empty(trim($_POST['editor6'])) || empty(trim($_POST['nome']))){
      echo "<meta http-equiv=refresh content='0; url=?pg=8&z=1'>";exit;
    } else {

    if(empty($foto)){

      $sql_eventoupdate=$conn->prepare("update visitas set nome=?, texto_pt=?, texto_es=?, texto_en=? where idvisita=?") or die("Erro ao inserir o registo");
      
      $sql_eventoupdate->bind_param("ssssi", $nome, $pt, $es, $en, $id);

      $sql_eventoupdate->execute();

      if($sql_eventoupdate->error){
        echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
        $sql_eventoupdate->close();
      }
      else{
        echo "<meta http-equiv=refresh content='0; url=?pg=8&m=20'>";exit;
        $sql_eventoupdate->close();
      }
    } else {
  
    $msg = false;
    if(isset($_FILES['fotop'])){
    $extensao= strtolower (substr($_FILES['fotop']['name'], -4));
    $novo_nome= md5(time()).$extensao;
    $diretorio="../img/blog/blog-details/";
    $temporario="../img/temporario/";
    $target_file = $diretorio.$novo_nome;
    
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png");
  
    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){	

    move_uploaded_file($_FILES['fotop']['tmp_name'], $temporario.$novo_nome);

    $image = new ImageResize($temporario.$novo_nome);
    $image->resize(360, 450);
    $image->save($diretorio.$novo_nome);
      
    $foto=$novo_nome;
    $casa=1;
  
    $sql_eventoupdate=$conn->prepare("update visitas set nome=?, texto_pt=?, texto_es=?, texto_en=?, foto=? where idevento=?") or die("Erro ao inserir o registo");
      
    $sql_eventoupdate->bind_param("sssssi", $nome, $pt, $es, $en, $foto, $id);
  
    $sql_eventoupdate->execute();
  
    if($sql_eventoupdate->error){
      echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
      $sql_eventoupdate->close();
    }
    else{
      move_uploaded_file($_FILES['fotop']['tmp_name'], $diretorio.$novo_nome);
      unlink($temporario.$novo_nome);
      echo "<meta http-equiv=refresh content='0; url=?pg=8&m=20'>";exit;
      $sql_eventoupdate->close();
    }
  
    }
    else {
      echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
    }
    }
  }
  }
  
}

if(isset($_POST['editf']) && $_POST['editf']=="Editf"){

  $id = $_POST['idfoto_visita'];
  $foto = $_FILES['foto']['name'];

  if(empty($foto)){
      echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
  } else {

  $msg = false;
  if(isset($_FILES['foto'])){
  $extensao= strtolower (substr($_FILES['foto']['name'], -4));
  $novo_nome= md5(time()).$extensao;
  $diretorio="../img/blog/blog-details/";
  $temporario="../img/temporario/";
  $target_file = $diretorio.$novo_nome;
  
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $extensions_arr = array("jpg","jpeg","png");

  // Check extension
  if( in_array($imageFileType,$extensions_arr) ){	

  move_uploaded_file($_FILES['foto']['tmp_name'], $temporario.$novo_nome);

  $image = new ImageResize($temporario.$novo_nome);
  $image->resize(317, 240);
  $image->save($diretorio.$novo_nome);
    
  $foto=$novo_nome;
  $casa=1;

  $foto_delete = $conn->query("select foto from galeria_visita where idfoto_visita='".$id."'")or die("Erro"); 
  if($foto_delete->num_rows>=1){
    $row=$foto_delete->fetch_assoc();
    $foto2 = $row['foto'];
    unlink("../img/blog/blog-details/$foto2");
  }

  $sql_eventoupdate=$conn->prepare("update galeria_visita set foto=? where idfoto_visita=?") or die("Erro ao inserir o registo");
    
  $sql_eventoupdate->bind_param("si", $foto, $id);

  $sql_eventoupdate->execute();

  if($sql_eventoupdate->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
    $sql_eventoupdate->close();
  }
  else{
    move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome);
    unlink($temporario.$novo_nome);
    echo "<meta http-equiv=refresh content='0; url=?pg=8&m=20'>";exit;
    $sql_eventoupdate->close();
  }

  }
  else {
    echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
  }
  }
}

}
//Fim de Inserção de imagem

?>
<div class="wrapper">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>A visitar | listagem</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">A visitar | listagem</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
        <div class="row">
          <div class="col-12">
            
            <div class="card card-primary">
              <div class="card-header" style="position: relative;">
                <div class="card-title">
                  Informações
                  <button type="button" data-toggle="modal" data-target="#exampleModal2" class="btn btn-block btn-secondary btn-sm" style="background: white; color: blue; border: 0px; width: 60%; margin-top: -30px; margin-left: 140px;">
                    <i class="fas fa-plus"></i> Adicionar Página de Visitas
                  </button>
                </div>     
              </div>
              <?php $sql_perfil2=$conn->query("select * from visitas")or die("Erro ao selecionar o nome.");
                if($sql_perfil2->num_rows>=1){ ?>
              <div class="card-body">
                <div class="row">
                  <?php while($row=$sql_perfil2->fetch_assoc()){ ?>
                    <div class="col-sm-3" style="position: relative;">
                    <div>
                    <?php if($row['ativo']==0 ){
                      echo "";
                    } 
                    else { ?>
                      <div style="top: 15px; left: 20px; position: absolute; z-index: 2; background: #4da6ff; width: 30px; border-radius: 50px; height: 30px;">
                        <form action="?pg=8" method="post">
                          <input type="hidden" name="visita" value="<?php echo $row['idvisita'];?>">
                          <button type="submit" name="editar4" value="Editar4" style="background: transparent; border: 0px; margin-top: 3px; margin-left: 3px;">
                            <i style="color: white;" class="fas fa-times"></i>
                          </button>
                        </form>
                      </div>
                    <?php } ?>
                      <div style="width:90%; height: 43%; top: 210px; position: absolute;">
                        <div style="height: 72%; width: 87%; float: left;  margin-top: 20px;">
                          <p style="margin-left: 5px; margin-top: 30px; color: white; font-size: 18px; font-weight: 500; "><?php echo $row['nome'];?><p>
                        </div>
                        <div style="float: right; width: 13%; height: 100%;">
                            <form action="?pg=8" method="post">
                            <!-- Input com ID da visita-->
                            <input type="hidden" name="visita" value="<?php echo $row['idvisita'];?>">
                            <!-- Todos os butões antes da visita ter uma função-->
                            <?php if($row['ativo']==0){ ?>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idvisita'];?>"  class="view_data" style="float: right; border: 0px; border-radius: 50px; background: #ff4d4d; width: 30px; height: 30px; color: white;"><i class="fas fa-trash"></i></button>
                            <button type="submit" name="editar3" value="Editar3" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #4da6ff; width: 30px; height: 30px; color: white;" ><i class="far fa-calendar-check"></i></button>
                            <button type="button" data-toggle="modal" data-target="#exampleModal7" id="<?php echo $row['idvisita'];?>" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #f78b07; width: 30px; height: 30px; color: white;" class="view_data4"><i class="far fa-image"></i></button>
                            <button type="button"  data-toggle="modal" data-target="#exampleModal3" id="<?php echo $row['idvisita'];?>" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #0bdad3; width: 30px; height: 30px; color: white;" class="view_data2"><i class="far fa-edit"></i></button>
                            <button type="button"  data-toggle="modal" data-target="#exampleModal4" id="<?php echo $row['idvisita'];?>" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #cccc00; width: 30px; height: 30px; color: white;" class="view_data3"><i class="fas fa-images"></i></button>
                            
                            <!-- Todos os butões depois da visita ser ativado-->
                            <?php } else if($row['ativo']==1) {  ?>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idvisita'];?>" class="view_data" style="margin-top: 20px; float: right; border: 0px; border-radius: 50px; background: #ff4d4d; width: 30px; height: 30px; color: white;"><i class="fas fa-trash"></i></button>
                            <button type="button" data-toggle="modal" data-target="#exampleModal7" id="<?php echo $row['idvisita'];?>" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #f78b07; width: 30px; height: 30px; color: white;" class="view_data4"><i class="far fa-image"></i></button>
                            <button type="button" data-toggle="modal" data-target="#exampleModal3" id="<?php echo $row['idvisita'];?>" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #0bdad3; width: 30px; height: 30px; color: white;" class="view_data2"><i class="far fa-edit"></i></button>
                            <button type="button"  data-toggle="modal" data-target="#exampleModal4" id="<?php echo $row['idvisita'];?>" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #cccc00; width: 30px; height: 30px; color: white;" class="view_data3"><i class="fas fa-images"></i></button>
                            <?php } ?>
                            </form>
                          </div>
                        </div>
                        <img src="../img/blog/<?php echo $row['foto'];?>" style="width: 100%; height: 400px;" class="img-fluid mb-2" alt="white sample"/>
                      </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.control-sidebar -->
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document" style="position: absolute;  left: 40%;  top: 43%; transform: translate(-50%, -50%);">
    <div class="modal-content" style="width: 1000px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar a visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <form action="?pg=8" method="post" id="form1" enctype="multipart/form-data">
            <div class="modal-body">
                <div>
                  <div style="width: 50% ; float: left; padding-right: 5px;">
                    <label>Titulo da Descoberta</label>
                    <input  type="text" name="nome" style="width: 100%;" required>
                  </div>
                  <div style="width: 50%; float: right; padding-left: 5px;">
                    <label>Foto para banner na página de detalhes</label>
                    <input type="file" name="fotoban" style="width: 100%;" required>
                  </div>
                </div>
                <div style="width: 100%; padding-top: 10px;" >
                  <label>Descrição</label>
                  <ul class="nav nav-pills" style="padding-bottom: 10px;">
                    <li class="nav-item" style="padding-right: 5px;"><button type="button" id="pt" onclick="showDiv1()" style="border: 0px;" class="nav-link active">Português</button></li>
                    <li class="nav-item" style="padding-right: 5px;"><button type="button" id="es" onclick="showDiv2()" style="border: 0px;" class="nav-link">Espanhol</button></li>
                    <li class="nav-item"><button type="button" onclick="showDiv3()" id="en" style="border: 0px;" class="nav-link">Inglês</button></li>
                  </ul>
                  <div id="welcomeDiv1">
                    <input type="hidden" onkeyup="count_down(this);" >
                    <textarea class="ckeditor" id="editor" name="editor1" required>
                      
                    </textarea>
                  </div>
                  <div id="welcomeDiv2" style="display: none;">
                    <textarea id="editor2" name="editor2" required></textarea>
                  </div>
                  <div id="welcomeDiv3" style="display: none;">
                    <textarea id="editor3" name="editor3" required></textarea>
                  </div>
                </div>
                <div>
                  <div style="width: 50%; float: left; padding-right: 5px; padding-top: 5px; padding-bottom: 10px;">
                    <label>Foto da Visita</label>
                    <input type="file" name="fotop" style="width: 100%;" required>
                  </div>
                  <div style="width: 50%; float: right; padding-left: 5px;  padding-top: 5px; padding-bottom: 10px;">
                    <label>Fotos para acompanhar texto(3 fotos)</label>
                    <input type="file" id="image_upload" name="fotos[]" style="width: 100%;" required multiple>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button id="submit" type="submit" name="enviar2" value="Enviar2" class="btn btn-primary">Adicionar</button>
              </div>
          </form> 
      </div>
  </div>
</div>

<div class="modal fade" id="exampleModal3"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document" style="position: absolute;  left: 40%;  top: 43%; transform: translate(-50%, -50%);">
    <div class="modal-content" style="width: 1000px; ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="?pg=8" method="post" enctype="multipart/form-data">
      <div class="modal-body" id="employee_detail2" style="margin-top: -10px;">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="enviar3" value="Enviar3" class="btn btn-primary">Editar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal4"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document" style="position: absolute;  left: 40%;  top: 43%; transform: translate(-50%, -50%);">
    <div class="modal-content" style="width: 1000px; ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Mini Galeria do Artigo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="employee_detail3" style="margin-top: -10px;">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal5" style="margin-left: 3%; margin-top: 15%;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document" style="position: absolute;  left: 50%;  top: 13%; transform: translate(-50%, -50%);">
    <div class="modal-content" style="width: 500px; ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Trocar Imagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="employee_detail4" style="margin-top: 10px;">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal6" style="margin-left: 3%; margin-top: 15%;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 500px; ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Foto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="?pg=8" method="post" enctype="multipart/form-data">
      <div class="modal-body" id="employee_detail5" style="margin-top: 10px;">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="editf" value="Editf"  class="btn btn-primary">Editar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal7"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document" style="position: absolute;  left: 45%;  top: 43%; transform: translate(-50%, -50%);">
    <div class="modal-content" style="width: 740px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Banner</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="employee_detail6" style="margin-top: 10px;">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal8"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document" style="position: absolute;  left: 45%;  top: 43%; transform: translate(-50%, -50%);">
    <div class="modal-content" style="width: 740px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Banner</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="?pg=8" method="post" enctype="multipart/form-data">
      <div class="modal-body" id="employee_detail7" style="margin-top: 10px;">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="editfban" value="Editfban"  class="btn btn-primary">Editar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
  aria-hidden="true" style="top: 160px; margin-left: auto; margin-right: auto;">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document" style="position: absolute;  left: 50%;  top: 30%; transform: translate(-50%, -50%);">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center" style="margin-left: 1px; background-color: #ff3547; color: white;">
        <p class="heading">Remoção de Página de Visita</p>
      </div>

      <!--Body-->
      <div class="modal-body" >

        <i class="fas fa-times fa-4x animated rotateIn" style="color: #ff3547;"></i>
				<div>
          Tem acerteza que quere eliminar esta página?
        </div>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center" id="employee_detail">
        
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>

<script>

$(function() {

var // Define maximum number of files.
    max_file_number = 3,
    // Define your form id or class or just tag.
    $form = $('#form1'), 
    // Define your upload field class or id or tag.
    $file_upload = $('#image_upload', $form), 
    // Define your submit class or id or tag.
    $button = $('#submit', $form); 

// Disable submit button on page ready.
$button.prop('disabled', 'disabled');

$file_upload.on('change', function () {
  var number_of_images = $(this)[0].files.length;
  if (number_of_images > max_file_number || number_of_images < max_file_number ) {
    alert(` Tem que dar upload de ${max_file_number} fotos.`);
    $(this).val('');
    $button.prop('disabled', 'disabled');
  } 
  else {
    $button.prop('disabled', false);
  }
});
});

    CKEDITOR.replace( 'editor1',
    {
    toolbar : 'standard',
    uiColor : '#007bff',
    enterMode : CKEDITOR.ENTER_BR
    });
    CKEDITOR.replace( 'editor2',
    {
    toolbar : 'standard',
    uiColor : '#007bff',
    enterMode : CKEDITOR.ENTER_BR
    });
    CKEDITOR.replace( 'editor3',
    {
    toolbar : 'standard',
    uiColor : '#007bff',
    enterMode : CKEDITOR.ENTER_BR
    });
    
    function showDiv1() {
      document.getElementById('welcomeDiv1').style.display = "block";
      document.getElementById('welcomeDiv2').style.display = "none";     
      document.getElementById('welcomeDiv3').style.display = "none";
      document.getElementById("pt").classList.add('active');
      document.getElementById("en").classList.remove('active');  
      document.getElementById("es").classList.remove('active');  

    }
    function showDiv11() {
      document.getElementById('welcomeDiv11').style.display = "block";
      document.getElementById('welcomeDiv22').style.display = "none";     
      document.getElementById('welcomeDiv33').style.display = "none";  
      document.getElementById("pt2").classList.add('active');
      document.getElementById("en2").classList.remove('active');  
      document.getElementById("es2").classList.remove('active');  

    }
    function showDiv2() {
      document.getElementById('welcomeDiv1').style.display = "none";
      document.getElementById('welcomeDiv2').style.display = "block";     
      document.getElementById('welcomeDiv3').style.display = "none"; 
      document.getElementById("es").classList.add('active');
      document.getElementById("en").classList.remove('active');  
      document.getElementById("pt").classList.remove('active');
    }
    function showDiv22() {
      document.getElementById('welcomeDiv11').style.display = "none";
      document.getElementById('welcomeDiv22').style.display = "block";     
      document.getElementById('welcomeDiv33').style.display = "none";    
      document.getElementById("es2").classList.add('active');
      document.getElementById("en2").classList.remove('active');  
      document.getElementById("pt2").classList.remove('active');    
    }
    function showDiv3() {
      document.getElementById('welcomeDiv1').style.display = "none";
      document.getElementById('welcomeDiv2').style.display = "none";     
      document.getElementById('welcomeDiv3').style.display = "block";
      document.getElementById("en").classList.add('active');
      document.getElementById("es").classList.remove('active');  
      document.getElementById("pt").classList.remove('active'); 
      
    }
    function showDiv33() {
      document.getElementById('welcomeDiv11').style.display = "none";
      document.getElementById('welcomeDiv22').style.display = "none";     
      document.getElementById('welcomeDiv33').style.display = "block";   
      document.getElementById("en2").classList.add('active');
      document.getElementById("es2").classList.remove('active');  
      document.getElementById("pt2").classList.remove('active');      
      
    }

</script>
        
<script>

$(document).ready(function(){  
      $('.view_data2').click(function(){  
           var idvisita = $(this).attr("id");  
           $.ajax({  
                url:"acoes/edit_visita.php",  
                method:"post",  
                data:{idvisita:idvisita},  
                success:function(data){  
                     $('#employee_detail2').html(data);  
                     $('#exampleModal3').modal("show");  
                }  
           });  
      });  
 }); 

 $(document).ready(function(){  
      $('.view_data3').click(function(){  
           var idvisita = $(this).attr("id");  
           $.ajax({  
                url:"acoes/foto_visita.php",  
                method:"post",  
                data:{idvisita:idvisita},  
                success:function(data){  
                     $('#employee_detail3').html(data);  
                     $('#exampleModal4').modal("show");  
                }  
           });  
      });  
 }); 

 $(document).ready(function(){  
      $('.view_data4').click(function(){  
           var idvisita = $(this).attr("id");  
           $.ajax({  
                url:"acoes/foto_visita_banner.php",  
                method:"post",  
                data:{idvisita:idvisita},  
                success:function(data){  
                     $('#employee_detail6').html(data);  
                     $('#exampleModal7').modal("show");  
                }  
           });  
      });  
 });



</script>

<script>

$(document).ready(function(){  
      $('.view_data').click(function(){  
           var idvisita = $(this).attr("id");  
           $.ajax({  
                url:"acoes/delete_visita.php",  
                method:"post",  
                data:{idvisita:idvisita},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#modalConfirmDelete').modal("show");  
                }  
           });  
      });  
 }); 

</script>
