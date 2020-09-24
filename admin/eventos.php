<?php 

include 'php-image-resize/lib/ImageResize.php';

use \Gumlet\ImageResize;
	
if(isset($_POST['delete']) && $_POST['delete']=="Delete"){

    $id = $_POST['delete_evento'];

    $sql_not=$conn->query("select img from eventos where idevento='".$id."'")or die("Erro ao selecionar o perfil.");
    $ln_not=$sql_not->fetch_assoc();
    
    $foto = $ln_not['img'];

    unlink("../img/blog/$foto");


    $delete=$conn->prepare("DELETE FROM eventos where idevento=?") or die("Falha ao eliminar o utilizador.");

    $delete->bind_param("i", $id);

    $delete->execute();
    

    if($delete->error){
      echo "<meta http-equiv=refresh content='0; url=?pg=6&erro=1'>";exit;
      $delete->close();
		}		
		else{
      
      echo "<meta http-equiv=refresh content='0; url=?pg=6&m=11'>";exit;
      $delete->close();
		}

}

if(isset($_POST['editar3']) && $_POST['editar3']=="Editar3"){

  $id2 = $_POST['evento'];

  $result2 = 1;
  $update=$conn->prepare("update eventos set ativo=? where idevento=?") or die("Falha o utilizador.");

  $update->bind_param("ii", $result2, $id2);

  $update->execute();

  if($update->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=6&erro=1'>";exit;
    $update->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=6&m=12'>";exit;
    $update->close();
  }
}

if(isset($_POST['editar4']) && $_POST['editar4']=="Editar4"){

  $id2 = $_POST['evento'];

  $result = 0;
  $update=$conn->prepare("update eventos set ativo=? where idevento=?") or die("Falha o utilizador.");

  $update->bind_param("ii", $result, $id2);

  $update->execute();

  if($update->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=6&erro=1'>";exit;
    $update->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=6&m=13'>";exit;
    $update->close();
  }
}


//Inserir Imagens para BD
if(isset($_POST['enviar2']) && $_POST['enviar2']=="Enviar2"){

  $foto = $_FILES['imagem']['name'];
  $link = $_POST['link'];
  $data = $_POST['data'];
  $nome = $_POST['nome'];
  
    $msg = false;
    if(isset($_FILES['imagem'])){
    $extensao= strtolower (substr($_FILES['imagem']['name'], -4));
    $novo_nome= md5(time()).$extensao;
    $diretorio="../img/blog/";
    $temporario="../img/temporario/";
    $target_file = $diretorio.$novo_nome;
    
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png");
  
    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){	

    move_uploaded_file($_FILES['imagem']['tmp_name'], $temporario.$novo_nome);

    $image = new ImageResize($temporario.$novo_nome);
    $image->resize(360, 450);
    $image->save($diretorio.$novo_nome);
      
    $foto=$novo_nome;
    $casa=1;
  
    $sql_insereregisto=$conn->prepare("Insert into eventos (nome, data, img, link) VALUES (?, ?, ?, ?) ") or die("Erro ao inserir o registo");
      
    $sql_insereregisto->bind_param("ssss", $nome, $data, $foto, $link);
  
    $sql_insereregisto->execute();
  
    if($sql_insereregisto->error){
      echo "<meta http-equiv=refresh content='0; url=?pg=6&erro=1'>";exit;
      $sql_insereregisto->close();
    }
    else{
      move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome);
      unlink($temporario.$novo_nome);
      echo "<meta http-equiv=refresh content='0; url=?pg=6&m=10'>";exit;
      $sql_insereregisto->close();
    }
  
    }
    else {
      echo "<meta http-equiv=refresh content='0; url=?pg=6&erro=1'>";exit;
    }
  }
  
}

if(isset($_POST['enviar3']) && $_POST['enviar3']=="Enviar3"){

    $foto = $_FILES['imagem']['name'];
    $link = $_POST['link'];
    $data = $_POST['data'];
    $nome = $_POST['nome'];
    $id = $_POST['idevento'];

    if(empty($foto)){

      $sql_eventoupdate=$conn->prepare("update eventos set link=?, data=?, nome=? where idevento=?") or die("Erro ao inserir o registo");
      
      $sql_eventoupdate->bind_param("sssi", $link, $data, $nome, $id);

      $sql_eventoupdate->execute();

      if($sql_eventoupdate->error){
        echo "<meta http-equiv=refresh content='0; url=?pg=6&erro=1'>";exit;
        $sql_eventoupdate->close();
      }
      else{
        echo "<meta http-equiv=refresh content='0; url=?pg=6&m=14'>";exit;
        $sql_eventoupdate->close();
      }
    } else {
  
    $msg = false;
    if(isset($_FILES['imagem'])){
    $extensao= strtolower (substr($_FILES['imagem']['name'], -4));
    $novo_nome= md5(time()).$extensao;
    $diretorio="../img/blog/";
    $temporario="../img/temporario/";
    $target_file = $diretorio.$novo_nome;
    
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $extensions_arr = array("jpg","jpeg","png");
  
    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){	

    move_uploaded_file($_FILES['imagem']['tmp_name'], $temporario.$novo_nome);

    $image = new ImageResize($temporario.$novo_nome);
    $image->resize(360, 450);
    $image->save($diretorio.$novo_nome);
      
    $foto=$novo_nome;
    $casa=1;
  
    $sql_eventoupdate=$conn->prepare("update eventos set link=?, data=?, nome=?, img=? where idevento=?") or die("Erro ao inserir o registo");
      
    $sql_eventoupdate->bind_param("sssi", $link, $data, $nome, $foto, $id);
  
    $sql_eventoupdate->execute();
  
    if($sql_eventoupdate->error){
      echo "<meta http-equiv=refresh content='0; url=?pg=6&erro=1'>";exit;
      $sql_eventoupdate->close();
    }
    else{
      move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome);
      unlink($temporario.$novo_nome);
      echo "<meta http-equiv=refresh content='0; url=?pg=6&m=14'>";exit;
      $sql_eventoupdate->close();
    }
  
    }
    else {
      echo "<meta http-equiv=refresh content='0; url=?pg=6&erro=1'>";exit;
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
            <h1>Eventos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Eventos</li>
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
                  Lista de eventos
                  <button type="button" data-toggle="modal" data-target="#exampleModal2" class="btn btn-block btn-secondary btn-sm" style="background: white; color: blue; border: 0px; width: 60%; margin-top: -30px; margin-left: 140px;">
                    <i class="fas fa-plus"></i> Adicionar Evento
                  </button>
                </div>     
              </div>
              <?php $sql_perfil2=$conn->query("select * from eventos order by data desc")or die("Erro ao selecionar o nome.");
                if($sql_perfil2->num_rows>=1){ ?>
              <div class="card-body">
                <div class="row">
                  <?php while($row=$sql_perfil2->fetch_assoc()){ 
                       $sql_perfil3=$conn->query("SET lc_time_names = 'pt_PT'") or die("Erro selecionar o nome."); 
                       $sql_perfil3=$conn->query("select day('".$row['data']."') as dia, year('".$row['data']."') as ano, monthname('".$row['data']."') AS Result")or die("Erro selecionar o nome."); 
                       $row2=$sql_perfil3->fetch_assoc(); 
                      ?>
                    <div class="col-sm-3" style="position: relative;">
                    <div>
                    <?php if($row['ativo']==0 ){
                      echo "";
                    } 
                    else { ?>
                      <div style="top: 15px; left: 20px; position: absolute; z-index: 2; background: #4da6ff; width: 30px; border-radius: 50px; height: 30px;">
                        <form action="?pg=6" method="post">
                          <input type="hidden" name="evento" value="<?php echo $row['idevento'];?>">
                          <button type="submit" name="editar4" value="Editar4" style="background: transparent; border: 0px; margin-top: 3px; margin-left: 3px;">
                            <i style="color: white;" class="fas fa-times"></i>
                          </button>
                        </form>
                      </div>
                    <?php } ?>
                      <div style="width:90%; height: 27%; top: 280px; position: absolute; ">
                        <div style="height: 100%; width: 87%; float: left;">
                          <p style="margin-left: 5px; margin-top: 15px; color: white; font-size: 18px; font-weight: 500; "><?php echo $row['nome'];?><p>
                          <p style="margin-left: 5px; color: white; margin-top: -10px; font-size: 15px; font-weight: 500;"><i class="far fa-clock"></i> <?php echo $row2['dia'];?> de <?php echo $row2['Result'];?> <?php echo $row2['ano'];?><p>
                        </div>
                        <div style="float: right; width: 13%; height: 100%; ">
                            <form action="?pg=6" method="post">
                            <!-- Input com ID do evento-->
                            <input type="hidden" name="evento" value="<?php echo $row['idevento'];?>">
                            <!-- Todos os butões antes de o evento ter uma função-->
                            <?php if($row['ativo']==0){ ?>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idevento'];?>"  class="view_data" style="float: right; border: 0px; border-radius: 50px; background: #ff4d4d; width: 30px; height: 30px; color: white;"><i class="fas fa-trash"></i></button>
                            <button type="submit" name="editar3" value="Editar3" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #4da6ff; width: 30px; height: 30px; color: white;" ><i class="far fa-calendar-check"></i></button>
                            <button type="button"  data-toggle="modal" data-target="#exampleModal3" id="<?php echo $row['idevento'];?>" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #0bdad3; width: 30px; height: 30px; color: white;" class="view_data2"><i class="far fa-edit"></i></button>
                            <!-- Todos os butões depois do evento ser ativado-->
                            <?php } else if($row['ativo']==1) {  ?>
                            <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idevento'];?>" class="view_data" style="margin-top: 60%; float: right; border: 0px; border-radius: 50px; background: #ff4d4d; width: 30px; height: 30px; color: white;"><i class="fas fa-trash"></i></button>
                            <button type="button" data-toggle="modal" data-target="#exampleModal3" id="<?php echo $row['idevento'];?>" style="margin-top: 5px; float: right; border: 0px; border-radius: 50px; background: #0bdad3; width: 30px; height: 30px; color: white;" class="view_data2"><i class="far fa-edit"></i></button>
                            <?php } ?>
                            </form>
                          </div>
                        </div>
                        <img src="../img/blog/<?php echo $row['img'];?>" style="width: 100%; height: 400px;" class="img-fluid mb-2" alt="white sample"/>
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

<div class="modal fade" id="exampleModal2" style="margin-top: 13%; margin-bottom: 13%;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document" style="position: absolute;  left: 35%;  top: 0%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar Evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="?pg=6" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <div>
            <div style="width: 50% ; float: left; padding-right: 5px;">
                <label>Nome do evento</label>
                <input  type="text" name="nome" style="width: 100%;" required>
            </div>
            <div style="width: 50%; float: right; padding-left: 5px;">
                <label>Data do evento</label>
                <input type="date" name="data" style="width: 100%;" required>
            </div>
            
        </div>
        <div style=" width: 100%; margin-top: 70px;">
            <label>Link do evento</label>
            <input type="text" name="link" style="width: 100%;" required>
        </div>
        <div style=" width: 100%; margin-top: 10px;">
            <label>Foto do evento</label>
            <input type="file" name="imagem" style="width: 100%;" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="enviar2" value="Enviar2" class="btn btn-primary">Adicionar Evento</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal3"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document" style="position: absolute;  left: 35%;  top: 20%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="?pg=6" method="post" enctype="multipart/form-data">
      <div class="modal-body" id="employee_detail2">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="enviar3" value="Enviar3" class="btn btn-primary">Editar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
  aria-hidden="true" style="top: 160px; margin-left: auto; margin-right: auto;">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document" style="position: absolute;  left: 42%;  top: 10%;">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center" style="margin-left: 1px; background-color: #ff3547; color: white;">
        <p class="heading">Remoção de Evento</p>
      </div>

      <!--Body-->
      <div class="modal-body" >

        <i class="fas fa-times fa-4x animated rotateIn" style="color: #ff3547;"></i>
				<div>
          Tem acerteza que quere eliminar este evento?
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
      $('.view_data2').click(function(){  
           var idevento = $(this).attr("id");  
           $.ajax({  
                url:"acoes/edit_evento.php",  
                method:"post",  
                data:{idevento:idevento},  
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
           var idevento = $(this).attr("id");  
           $.ajax({  
                url:"acoes/delete_evento.php",  
                method:"post",  
                data:{idevento:idevento},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#modalConfirmDelete').modal("show");  
                }  
           });  
      });  
 }); 

</script>
