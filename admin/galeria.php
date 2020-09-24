<?php 

include 'php-image-resize/lib/ImageResize.php';

use \Gumlet\ImageResize;

if(isset($_POST['enviar3']) && $_POST['enviar3']=="Enviar3"){

    $antiga = $_POST['foto_atual'];
    $nova = $_POST['foto_muda'];

    $sql_antiga=$conn->query("select * from galeria where idfoto='".$antiga."'")or die("Erro ao selecionar o perfil.");
    $ln_antiga=$sql_antiga->fetch_assoc();

    $foto_ant = $ln_antiga['foto'];

    $sql_nova=$conn->query("select * from galeria where idfoto='".$nova."'")or die("Erro ao selecionar o perfil.");
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

    $update_antiga=$conn->query("update galeria set foto='".$foto_no3."' where idfoto='".$antiga."'") or die("Falha o utilizador.");

    $update_antiga=$conn->query("update galeria set foto='".$foto_ant3."'  where idfoto='".$nova."'") or die("Falha o utilizador.");

    $delete_nova=$conn->query("delete FROM swap_image where idtroca='".$antiga."'") or die("Falha ao eliminar o utilizador.");

    $delete_antiga=$conn->query("delete FROM swap_image where idtroca='".$nova."'") or die("Falha ao eliminar o utilizador.");

    if(isset($delete_antiga)){
      
      echo "<meta http-equiv=refresh content='0; url=?pg=5&m=9'>";exit;
    }
    else{
      echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
    }

}

if(isset($_POST['enviar']) && $_POST['enviar']=="Enviar"){

  $foto = $_FILES['imagem']['name'];

  $msg = false;
  if(isset($_FILES['imagem'])){
  $extensao= strtolower (substr($_FILES['imagem']['name'], -4));
  $novo_nome= md5(time()).$extensao;
  $diretorio="../img/gallery/";
  $temporario="../img/temporario/";
  $target_file = $diretorio.$novo_nome;
  
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $extensions_arr = array("jpg","jpeg","png");

  // Check extension
  if( in_array($imageFileType,$extensions_arr) ){	

  move_uploaded_file($_FILES['imagem']['tmp_name'], $temporario.$novo_nome);

  $image = new ImageResize($temporario.$novo_nome);
  $image->resize(2560, 1536);
  $image->save($diretorio.$novo_nome);
    
  $foto=$novo_nome;
  $banner=1;

  $sql_insereregisto=$conn->prepare("Insert into galeria (foto, banner) VALUES (?,?) ") or die("Erro ao inserir o registo");
		
  $sql_insereregisto->bind_param("si", $foto,$banner);

  $sql_insereregisto->execute();

  if($sql_insereregisto->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
    $sql_insereregisto->close();
  }
  else{
    move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome);
    unlink($temporario.$novo_nome);
    echo "<meta http-equiv=refresh content='0; url=?pg=5&m=4'>";exit;
    $sql_insereregisto->close();
  }

  }
  else {
    echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
  }
  }

} 
	
if(isset($_POST['delete']) && $_POST['delete']=="Delete"){

    $id = $_POST['delete_foto'];

    $sql_not=$conn->query("select foto, galeria_principal from galeria where idfoto='".$id."'")or die("Erro ao selecionar o perfil.");
    $ln_not=$sql_not->fetch_assoc();
    
    $foto = $ln_not['foto'];
    $gal = $ln_not['galeria_principal'];

    if($gal==1){
      unlink("../img/about/$foto");
    }
    else{
      unlink("../img/gallery/$foto");
    }

    $delete=$conn->prepare("DELETE FROM galeria where idfoto=?") or die("Falha ao eliminar o utilizador.");

    $delete->bind_param("i", $id);

    $delete->execute();
    

    if($delete->error){
      echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
      $delete->close();
		}		
		else{
      
      echo "<meta http-equiv=refresh content='0; url=?pg=5&m=5'>";exit;
      $delete->close();
		}

  }

  if(isset($_POST['editar']) && $_POST['editar']=="Editar"){

    $id2 = $_POST['foto'];

    $result = 1;
    $update=$conn->prepare("update galeria set ativo=? where idfoto=?") or die("Falha o utilizador.");

    $update->bind_param("ii", $result, $id2);

    $update->execute();

    if($update->error){
      echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
      $update->close();
      $foto->close();
    }		
    else{
      echo "<meta http-equiv=refresh content='0; url=?pg=5&m=6'>";exit;
      $update->close();
      $foto->close();
    }

  }

if(isset($_POST['editar2']) && $_POST['editar2']=="Editar2"){

  $id2 = $_POST['foto'];

  $result = 0;
  $update=$conn->prepare("update galeria set ativo=? where idfoto=?") or die("Falha o utilizador.");

  $update->bind_param("ii", $result, $id2);

  $update->execute();

  if($update->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
    $update->close();
    $foto->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=5&m=7'>";exit;
    $update->close();
    $foto->close();
  }
}

if(isset($_POST['editar3']) && $_POST['editar3']=="Editar3"){

  $id2 = $_POST['foto'];

  $result = 1;
  $result2 = 0;
  $update=$conn->prepare("update galeria set ativo=?, casa=?, galeria=? where idfoto=?") or die("Falha o utilizador.");

  $update->bind_param("iiii", $result, $result, $result2, $id2);

  $update->execute();

  if($update->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
    $update->close();
    $foto->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=5&m=8'>";exit;
    $update->close();
    $foto->close();
  }
}

if(isset($_POST['editar4']) && $_POST['editar4']=="Editar4"){

  $id2 = $_POST['foto'];

  $result = 0;
  $update=$conn->prepare("update galeria set ativo=?, casa=?, galeria=? where idfoto=?") or die("Falha o utilizador.");

  $update->bind_param("iiii", $result, $result, $result,$id2);

  $update->execute();

  if($update->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
    $update->close();
    $foto->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=5&m=7'>";exit;
    $update->close();
    $foto->close();
  }
}

if(isset($_POST['editar5']) && $_POST['editar5']=="Editar5"){

  $id2 = $_POST['foto'];

  $result = 1;
  $result2 = 0;
  $update=$conn->prepare("update galeria set ativo=?, casa=?, galeria=? where idfoto=?") or die("Falha o utilizador.");

  $update->bind_param("iiii", $result, $result2, $result, $id2);

  $update->execute();

  if($update->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
    $update->close();
    $foto->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=5&m=8'>";exit;
    $update->close();
    $foto->close();
  }
}

if(isset($_POST['enviar2']) && $_POST['enviar2']=="Enviar2"){

  $foto = $_FILES['imagem']['name'];
  
    $msg = false;
    if(isset($_FILES['imagem'])){
    $extensao= strtolower (substr($_FILES['imagem']['name'], -4));
    $novo_nome= md5(time()).$extensao;
    $diretorio="../img/about/";
    $temporario="../img/temporario/";
    $target_file = $diretorio.$novo_nome;
    
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png");
  
    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){	

    move_uploaded_file($_FILES['imagem']['tmp_name'], $temporario.$novo_nome);

    $image = new ImageResize($temporario.$novo_nome);
    $image->resize(360, 560);
    $image->save($diretorio.$novo_nome);
      
    $foto=$novo_nome;
    $casa=1;
  
    $sql_insereregisto=$conn->prepare("Insert into galeria (foto, galeria_principal) VALUES (?,?) ") or die("Erro ao inserir o registo");
      
    $sql_insereregisto->bind_param("si", $foto, $casa);
  
    $sql_insereregisto->execute();
  
    if($sql_insereregisto->error){
      echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
      $sql_insereregisto->close();
    }
    else{
      move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome);
      unlink($temporario.$novo_nome);
      echo "<meta http-equiv=refresh content='0; url=?pg=5&m=4'>";exit;
      $sql_insereregisto->close();
    }
  
    }
    else {
      echo "<meta http-equiv=refresh content='0; url=?pg=5&erro=1'>";exit;
    }
  }
  
}

?>
<div class="wrapper">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Galeria </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Galeria</li>
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
           
              <div class="card-header">
                <div class="card-title">
                  Galeria de fotos do Banner
                  <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-block btn-secondary btn-sm" style="background: white; color: blue; border: 0px; width: 60%; margin-top: -30px; margin-left: 200px;">
                    <i class="fas fa-plus"></i> Adicionar Foto
                  </button>
                </div>
              </div>
              <?php $sql_perfil2=$conn->query("select * from galeria where banner=1")or die("Erro ao selecionar o nome.");
                if($sql_perfil2->num_rows>=1){ ?>
              <div class="card-body">
                <div class="row">
                  <?php while($row=$sql_perfil2->fetch_assoc()){ ?>
                  <div class="col-sm-3" style="position: relative;">
                    <div>
                    <?php if($row['ativo']==0){
                      echo "";
                    } else { ?>
                      <div style="top: 15px; left: 20px; position: absolute; z-index: 2; background: #00cc00; width: 30px; border-radius: 50px; height: 30px;">
                        <form action="?pg=5" method="post">
                          <input type="hidden" name="foto" value="<?php echo $row['idfoto'];?>">
                          <button type="submit" name="editar2" value="Editar2" style="background: transparent; border: 0px; margin-top: 3px; margin-left: 3px;">
                            <i style="color: white;" class="fas fa-times"></i>
                          </button>
                        </form>
                      </div>
                    <?php } ?>
                    <div style=" top: 15px; position: absolute; z-index: 1; width: 90%;  height: 30px;">
                        <form action="?pg=5" method="post" style="margin-top: -2px; width: 30px; float: right;">
                          <button type="button" data-toggle="modal" data-target="#exampleModal3" id="<?php echo $row['idfoto'];?>" class="view_data3" style=" float: right; border: 0px; border-radius: 50px; background: #404040; width: 30px; height: 30px; color: white;"><i class="fas fa-exchange-alt"></i></button>
                          <p style="color: white; background: #404040; text-align: center; float: right; border: 0px; border-radius: 50px; width: 30px; height: 30px; margin-top: 4px; font-size: 19px; font-weight: 500;"><?php echo $row['idfoto'];?></p>
                        </form>
                      </div>
                      <div style="width:90%; height: 39%; top: 120px; position: absolute; ">
                        <div style="float: right; width: 12%; height: 100%;">
                            
                            <form action="?pg=5" method="post">
                            <?php if($row['ativo']==0){ ?>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idfoto'];?>"  class="view_data" style="float: right; border: 0px; border-radius: 50px; background: #ff4d4d; width: 30px; height: 30px; color: white;"><i class="fas fa-trash"></i></button>
                            <input type="hidden" name="foto" value="<?php echo $row['idfoto'];?>">
                            <button type="submit" name="editar" value="Editar" style="margin-top: 5px;  float: right; border: 0px; border-radius: 50px; background: #4da6ff; width: 30px; height: 30px; color: white;"><i class="far fa-plus-square"></i></button>
                            <?php } else {  ?>    
                            <button type="button"data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idfoto'];?>"  class="view_data" style="margin-top: 30px; float: right; border: 0px; border-radius: 50px; background: #ff4d4d; width: 30px; height: 30px; color: white;"><i class="fas fa-trash"></i></button>
                            <?php } ?>
                            </form>
                          </div>
                        </div>
                        <img src="../img/gallery/<?php echo $row['foto'];?>" style="width: 100%; height: 200px;" class="img-fluid mb-2" alt="white sample"/>
                      </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="card card-primary">
              <div class="card-header" style="position: relative;">
                <div class="card-title">
                  Galeria Principal
                  <button type="button" data-toggle="modal" data-target="#exampleModal2" class="btn btn-block btn-secondary btn-sm" style="background: white; color: blue; border: 0px; width: 60%; margin-top: -30px; margin-left: 140px;">
                    <i class="fas fa-plus"></i> Adicionar Foto
                  </button>
                </div>     
              </div>
              <?php $sql_perfil2=$conn->query("select * from galeria where galeria_principal=1 or galeria_principal=1 and casa=1 or galeria_principal=1 and galeria=1 order by casa desc")or die("Erro ao selecionar o nome.");
                if($sql_perfil2->num_rows>=1){ ?>
              <div class="card-body">
                <div class="row">
                  <?php while($row=$sql_perfil2->fetch_assoc()){ ?>
                    <div class="col-sm-3" style="position: relative;">
                    <div>
                    <?php if($row['ativo']==0 ){
                      echo "";
                    } 
                    else if($row['ativo']==1 && $row['casa']==1) { ?>
                      <div style="top: 15px; left: 20px; position: absolute; z-index: 2; background: #4da6ff; width: 30px; border-radius: 50px; height: 30px;">
                        <form action="?pg=5" method="post">
                          <input type="hidden" name="foto" value="<?php echo $row['idfoto'];?>">
                          <button type="submit" name="editar4" value="Editar4" style="background: transparent; border: 0px; margin-top: 3px; margin-left: 3px;">
                            <i style="color: white;" class="fas fa-times"></i>
                          </button>
                        </form>
                      </div>
                    <?php } else if($row['ativo']==1 && $row['galeria']==1) { ?>
                      <div style="top: 15px; left: 20px; position: absolute; z-index: 2; background: #aa00ff; width: 30px; border-radius: 50px; height: 30px;">
                        <form action="?pg=5" method="post">
                          <input type="hidden" name="foto" value="<?php echo $row['idfoto'];?>">
                          <button type="submit" name="editar4" value="Editar4" style="background: transparent; border: 0px; margin-top: 3px; margin-left: 3px;">
                            <i style="color: white;" class="fas fa-times"></i>
                          </button>
                        </form>
                      </div>
                    <?php } ?>
                      <div style=" top: 15px; position: absolute; z-index: 1; width: 90%;  height: 30px;">
                        <form action="?pg=5" method="post" style="margin-top: -2px; width: 30px; float: right;">
                          <button type="button" data-toggle="modal" data-target="#exampleModal3" id="<?php echo $row['idfoto'];?>" class="view_data2" style=" float: right; border: 0px; border-radius: 50px; background: #404040; width: 30px; height: 30px; color: white;"><i class="fas fa-exchange-alt"></i></button>
                          <p style="color: white; background: #404040; text-align: center; float: right; border: 0px; border-radius: 50px; width: 30px; height: 30px; margin-top: 4px; font-size: 19px; font-weight: 500;"><?php echo $row['idfoto'];?></p>
                        </form>
                      </div>
                      <div style="width:90%; height: 27%; top: 280px; position: absolute; ">
                     
                        <div style="float: right; width: 13%; height: 100%; ">
                            <form action="?pg=5" method="post">
                            <!-- Input com ID da foto-->
                            <input type="hidden" name="foto" value="<?php echo $row['idfoto'];?>">
                            <!-- Todos os butões antes de a imagem ter uma função-->
                            <?php if($row['ativo']==0){ ?>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idfoto'];?>"  class="view_data" style="float: right; border: 0px; border-radius: 50px; background: #ff4d4d; width: 30px; height: 30px; color: white;"><i class="fas fa-trash"></i></button>
                            <button type="submit" name="editar3" value="Editar3" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #4da6ff; width: 30px; height: 30px; color: white;"><i class="fas fa-home"></i></button>
                            <button type="submit" name="editar5" value="Editar5" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #aa00ff; width: 30px; height: 30px; color: white;"><i class="far fa-images"></i></button>
                            <!-- Todos os butões depois de a imagem ser selecionada para a página Casa-->
                            <?php } else if($row['ativo']==1 && $row['casa']==1) {  ?>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idfoto'];?>" class="view_data" style="margin-top: 60%; float: right; border: 0px; border-radius: 50px; background: #ff4d4d; width: 30px; height: 30px; color: white;"><i class="fas fa-trash"></i></button>
                            <button type="submit" name="editar5" value="Editar5" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #aa00ff; width: 30px; height: 30px; color: white;"><i class="far fa-images"></i></button>
                           <!-- Todos os butões depois de a imagem ser selecionada para a página Galeria-->
                            <?php } else if($row['ativo']==1 && $row['galeria']==1) { ?>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idfoto'];?>" class="view_data" style="margin-top: 60%; float: right; border: 0px; border-radius: 50px; background: #ff4d4d; width: 30px; height: 30px; color: white;"><i class="fas fa-trash"></i></button>
                            <button type="submit" name="editar3" value="Editar3" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #4da6ff; width: 30px; height: 30px; color: white;"><i class="fas fa-home"></i></button>
                            <?php } ?>
                            </form>
                          </div>
                        </div>
                        <img src="../img/about/<?php echo $row['foto'];?>" style="width: 100%; height: 400px;" class="img-fluid mb-2" alt="white sample"/>
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

<div class="modal fade" id="exampleModal" style="overflow: auto; position: absolute;  left: 50%;  top: 60%; transform: translate(-50%, -50%);" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar Imagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="?pg=5" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <input type="file" name="imagem" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="enviar" value="Enviar" class="btn btn-primary">Adicionar Imagem</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal2" style="overflow: auto; position: absolute;  left: 50%;  top: 60%; transform: translate(-50%, -50%);" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar Foto à Galeria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="?pg=5" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <input type="file" name="imagem" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="enviar2" value="Enviar2" class="btn btn-primary">Adicionar Imagem</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal3" style="overflow: auto; position: absolute;  left: 50%;  top: 60%; transform: translate(-50%, -50%);" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Trocar foto de posição</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="?pg=5" method="post" enctype="multipart/form-data">
      <div class="modal-body" id="employee_detail2">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="enviar3" value="Enviar3" class="btn btn-primary">Trocar Imagem</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
  aria-hidden="true" style="top: 160px; margin-left: auto; margin-right: auto;">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document" style="overflow: auto; position: absolute;  left: 50%;  top: 30%; transform: translate(-50%, -50%);">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center" style="margin-left: 1px; background-color: #ff3547; color: white;">
        <p class="heading">Remoção de fotografia</p>
      </div>

      <!--Body-->
      <div class="modal-body" >

        <i class="fas fa-times fa-4x animated rotateIn" style="color: #ff3547;"></i>
				<div>
          Tem acerteza que quere eliminar esta foto?
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

$(document).ready(function(){  
      $('.view_data3').click(function(){  
           var idfoto2 = $(this).attr("id");  
           $.ajax({  
                url:"acoes/troca_foto_banner.php",  
                method:"post",  
                data:{idfoto2:idfoto2},  
                success:function(data){  
                     $('#employee_detail2').html(data);  
                     $('#exampleModal3').modal("show");  
                }  
           });  
      });  
 }); 

</script>

<script>

$(document).ready(function(){  
      $('.view_data2').click(function(){  
           var idfoto2 = $(this).attr("id");  
           $.ajax({  
                url:"acoes/troca_foto.php",  
                method:"post",  
                data:{idfoto2:idfoto2},  
                success:function(data){  
                     $('#employee_detail2').html(data);  
                     $('#exampleModal3').modal("show");  
                }  
           });  
      });  
 }); 

</script>

<script>

$(document).ready(function(){  
      $('.view_data').click(function(){  
           var idfoto = $(this).attr("id");  
           $.ajax({  
                url:"acoes/delete_foto.php",  
                method:"post",  
                data:{idfoto:idfoto},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#modalConfirmDelete').modal("show");  
                }  
           });  
      });  
 }); 

</script>
