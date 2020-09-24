<?php 

if(isset($_GET['util']))	$id_user=$_GET['util'];
	else $id_user=0;
	
if(isset($_POST['delete']) && $_POST['delete']=="Delete"){

  $id = $_POST['delete_util'];

  $sql_perfil2=$conn->query("select * from reservas where idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
  if($sql_perfil2->num_rows>=1){
    echo "<meta http-equiv=refresh content='0; url=?pg=1&z=4'>";exit;
  } else {

  $sql_perfil2=$conn->query("select * from avaliacoes where idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
  if($sql_perfil2->num_rows>=1){ 
    $apaga_artigo2=$conn->query("DELETE FROM avaliacoes where idutilizador='".$id."'") or die("Falha ao eliminar o utilizador.");
  }

  $apaga_artigo=$conn->query("DELETE FROM utilizadores where idutilizador='".$id."'") or die("Falha ao eliminar o utilizador.");

  if(isset($apaga_artigo)){
    echo "<meta http-equiv=refresh content='0; url=?pg=1&m=2'>";exit;
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=1&erro=1'>";exit;
  }
}

}

if(isset($_POST['block']) && $_POST['block']=="Block"){

  $id = $_POST['block_util'];

  $sql_perfil2=$conn->query("select * from avaliacoes where idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
  if($sql_perfil2->num_rows>=1){ 
    $apaga_artigo2=$conn->query("DELETE FROM avaliacoes where idutilizador='".$id."'") or die("Falha ao eliminar o utilizador.");
  }

  $sql_perfil3=$conn->query("select email from utilizadores where idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
  $row = $sql_perfil3->fetch_assoc();

  $sql_perfil=$conn->query("Insert into utilizadores_block (email) VALUES ('".$row['email']."') ") or die("Erro ao inserir o registo");

  $apaga_artigo=$conn->query("DELETE FROM utilizadores where idutilizador='".$id."'") or die("Falha ao eliminar o utilizador.");

  if(isset($apaga_artigo)){
    echo "<meta http-equiv=refresh content='0; url=?pg=1&m=25'>";exit;
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=1&erro=1'>";exit;
  }

}

if(isset($_POST['unblock']) && $_POST['unblock']=="Unblock"){

  $id = $_POST['unblock_util'];

  $apaga_artigo=$conn->query("DELETE FROM utilizadores_block where iduser_block='".$id."'") or die("Falha ao eliminar o utilizador.");

  if(isset($apaga_artigo)){
    echo "<meta http-equiv=refresh content='0; url=?pg=1&m=26'>";exit;
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=1&erro=1'>";exit;
  }

}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de utilizadores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Lista de utilizadoress</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Informação</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <?php $sql_perfil2=$conn->query("select * from utilizadores where not tipo=1")or die("Erro ao selecionar o nome.");
              if($sql_perfil2->num_rows>=1){ 
                ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telemovel</th>
                    <th>País</th>
                    <th>Data de nascimento</th>
                    <th>Tipo</th>
                    <th>Linkada com :</th>
                    <th>Email Verificado</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                <?php while($row=$sql_perfil2->fetch_assoc()){ ?>
                <tr>
                  <td>
                  <?php if($row['foto']==""){?>
                    <img src="../img/perfis/default.png" style="width: 40px; height: 40px; border-radius: 50px; margin-left: auto; margin-right: auto; display: block;">
                  <?php } else { ?>
                    <img src="../img/perfis/<?php echo $row['foto']; ?>" style="width: 40px; height: 40px; border-radius: 50px; margin-left: auto; margin-right: auto; display: block;">
                  <?php } ?>  
                  </td>
                  <td><?php echo $row['nome'];?></td>
                  <td><?php echo $row['email'];?></td>
                  <?php if($row['prefix']!="" && $row['telemovel']!="") { ?>
                  <td><?php echo $row['prefix'];?> <?php echo $row['telemovel'];?></td>
                  <?php } else { ?>
                  <td>Por defenir</td>
                  <?php } if($row['idpais']!=0){ ?>
                  <?php $sql_perfil=$conn->query("select * from pais where idpais='".$row['idpais']."'")or die("Erro ao selecionar o nome.");
                  if($sql_perfil->num_rows>=1){ 
                    $row2=$sql_perfil->fetch_assoc();
                  ?>
                  <td><?php echo $row2['paisNome'];?></td>
                  <?php } } else { ?>
                  <td>Por defenir</td>
                  <?php } ?>
                  <?php if($row['data']!="0000-00-00") { ?>
                  <td><?php echo $row['data'];?></td>
                  <?php } else { ?>
                  <td>Por defenir</td>
                  <?php } ?>
                  <td><?php if($row['tipo']==0){ ?>Cliente<?php } else { ?>Admin <?php } ?></td>
                  <td><?php if($row['google_account']==0){ ?> <img style="width: 50px; height: 50px; margin-left: auto; margin-right: auto; display: block;" src="../img/esvaziar.png"><?php } else { ?><img style="width: 50px; height: 50px; margin-left: auto; margin-right: auto; display: block;" src="../img/google.png"><?php } ?></td>
                  <td><?php if($row['verificado']==0){ ?><p class="btn btn-block btn-outline-warning btn-xs">Por verificar</p><?php } else { ?><p class="btn btn-block btn-outline-success btn-xs">Verificado</p><?php } ?></td>
                  <td>
                    <a href="?pg=2&util=<?php echo $row['idutilizador'];?>" style="padding-left: 2px; padding-right: 2px;"><i class="far fa-edit"></i></a> 
                    <button style="border: 0px; background: transparent; color: #007bff;" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idutilizador'];?>" class="view_data"><i class="far fa-trash-alt"></i></button>
                    <button style="border: 0px; background: transparent; color: #007bff;" data-toggle="modal" data-target="#modalConfirmDelete2" id="<?php echo $row['idutilizador'];?>" class="view_data2"><i class="fas fa-ban"></i></button>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
				        <tfoot>
                  <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telemovel</th>
                    <th>País</th>
                    <th>Data de nascimento</th>
                    <th>Tipo</th>
                    <th>Linkada com:</th>
                    <th>Email Verificado</th>
                    <th>Ações</th>
                    
                  </tr>
                </tfoot>
              </table>
              <?php } ?>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Lista de emails bloqueados</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <?php $sql_perfil2=$conn->query("select * from utilizadores_block")or die("Erro ao selecionar o nome.");
              if($sql_perfil2->num_rows>=1){ 
                ?>
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Email</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                <?php while($row=$sql_perfil2->fetch_assoc()){ ?>
                <tr>
                  <td><?php echo $row['email'];?></td>
                  <td style="width: 125px;">
                    <button style="margin-left: auto; margin-right: auto; display: block; border: 0px; background: transparent; color: #007bff;" data-toggle="modal" data-target="#modalConfirmDelete3" id="<?php echo $row['iduser_block'];?>" class="view_data3"><i class="far fa-trash-alt"></i></button>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
				        <tfoot>
                  <tr>
                    <th>Email</th>
                    <th>Ações</th>       
                  </tr>
                </tfoot>
              </table>
              <?php } else {  ?>
                <h2 class="card-title"><b>Sem emails bloqueados</b></h2>
              <?php } ?>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
 
  <!-- /.content-wrapper -->
 
</div>

<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" style="top: 160px; margin-left: auto; margin-right: auto;">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document" style="position: absolute; left: 50%; top: 27%;  transform: translate(-50%, -50%);">
    <!--Content-->
    <div class="modal-content text-center" >
      <!--Header-->
      <div class="modal-header d-flex justify-content-center" style="margin-left: 1px; background-color: #ff3547; color: white;">
        <p class="heading">Eliminar Utilizador</p>
      </div>

      <!--Body-->
      <div class="modal-body" >

        <i class="fas fa-times fa-4x animated rotateIn" style="color: #ff3547;"></i>
				<div>
          Tem acertezea que quer eliminar esse utilizador?
        </div>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center" id="employee_detail">
        
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>

<div class="modal fade" id="modalConfirmDelete2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" style="top: 160px; margin-left: auto; margin-right: auto;">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document" style="position: absolute; left: 50%; top: 27%;  transform: translate(-50%, -50%);">
    <!--Content-->
    <div class="modal-content text-center" >
      <!--Header-->
      <div class="modal-header d-flex justify-content-center" style="margin-left: 1px; background-color: #ff3547; color: white;">
        <p class="heading">Bloquar Utilizador</p>
      </div>

      <!--Body-->
      <div class="modal-body" >
      <i class="fas fa-ban fa-4x animated rotateIn" style="color: #ff3547;"></i>
				<div>
          Tem acertezea que quer bloquear este utilizador?
        </div>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center" id="employee_detail2">
        
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>

<div class="modal fade" id="modalConfirmDelete3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" style="top: 160px; margin-left: auto; margin-right: auto;">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document" style="position: absolute; left: 50%; top: 27%;  transform: translate(-50%, -50%);">
    <!--Content-->
    <div class="modal-content text-center" >
      <!--Header-->
      <div class="modal-header d-flex justify-content-center" style="margin-left: 0px; background-color: #28a745; color: white;">
        <p class="heading">Desbloquar Email</p>
      </div>

      <!--Body-->
      <div class="modal-body" >
      <i class="fas fa-unlock fa-4x animated rotateIn" style="color: #28a745;"></i>
				<div>
          Tem acertezea que quer desbloquear este email?
        </div>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center" id="employee_detail3">
        
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->
<script>

$(document).ready(function(){  
      $('.view_data').click(function(){  
           var idutilizador = $(this).attr("id");  
           $.ajax({  
                url:"acoes/delete_util.php",  
                method:"post",  
                data:{idutilizador:idutilizador},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#modalConfirmDelete').modal("show");  
                }  
           });  
      });  
 }); 

 $(document).ready(function(){  
      $('.view_data2').click(function(){  
           var idutilizador = $(this).attr("id");  
           $.ajax({  
                url:"acoes/block_util.php",  
                method:"post",  
                data:{idutilizador:idutilizador},  
                success:function(data){  
                     $('#employee_detail2').html(data);  
                     $('#modalConfirmDelete2').modal("show");  
                }  
           });  
      });  
 }); 

 $(document).ready(function(){  
      $('.view_data3').click(function(){  
           var iduser_block = $(this).attr("id");  
           $.ajax({  
                url:"acoes/unblock_util.php",  
                method:"post",  
                data:{iduser_block:iduser_block},  
                success:function(data){  
                     $('#employee_detail3').html(data);  
                     $('#modalConfirmDelete3').modal("show");  
                }  
           });  
      });  
 }); 

</script>
