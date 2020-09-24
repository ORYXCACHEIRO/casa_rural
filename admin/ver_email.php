
<?php 

if(isset($_POST['delete']) && $_POST['delete']=="Delete"){

  $id = $_POST['delete_mail'];
  

  $delete=$conn->prepare("DELETE FROM mensagens where idmensagem=?") or die("Falha ao eliminar o utilizador.");
  $delete2=$conn->prepare("DELETE FROM resposta_mensagm where idmensagem=?") or die("Falha ao eliminar o utilizador.");

  $delete->bind_param("i", $id);
  $delete2->bind_param("i", $id);

  $delete->execute();
  $delete2->execute();

  if($delete->error || $delete2->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=11&erro=1'>";exit;
    $delete->close();
    $delete2->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=9&m=21'>";exit;
    $delete->close();
    $delete2->close();
  }

}

?>

<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ler Mensagem</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="?pg=9">Lista de mensagens</a></li>
              <li class="breadcrumb-item active">Ler Mensagem</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <a href="?pg=9" class="btn btn-primary btn-block mb-3">Voltar para a Caixa de Entrada</a>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pastas</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item active">
                    <a href="?pg=9" class="nav-link">
                      <i class="fas fa-inbox"></i> Caixa de entrada
                      <?php
                      $sql_count=$conn->query("select count(idmensagem) as conta from mensagens where visto=0")or die("Erro ao selecionar o nome.");
                      $count=$sql_count->fetch_assoc(); 
                      
                      if($count['conta']>=1){?>
                      <span class="badge bg-primary float-right"><?php echo $count['conta'];?></span>
                      <?php } else { echo "";} ?>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="?pg=12" class="nav-link">
                      <i class="far fa-envelope"></i> Enviadas
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Ler mensagem</h3>
            </div>
            <!-- /.card-header -->
            <?php 
            $id = $_GET['men'];
            $sql_perfil=$conn->query("select * from mensagens where idmensagem='".$id."'")or die("Erro ao selecionar o nome.");
                  if($sql_perfil->num_rows>=1){ 
                    $row2=$sql_perfil->fetch_assoc();
                    $sql_perfil3=$conn->query("SET lc_time_names = 'pt_PT'") or die("Erro selecionar o nome."); 
                    $sql_perfil3=$conn->query("select day('".$row2['data_escrita']."') as dia, year('".$row2['data_escrita']."') as ano, monthname('".$row2['data_escrita']."') AS mes,  hour('".$row2['data_escrita']."') AS hora,  minute('".$row2['data_escrita']."') AS min")or die("Erro selecionar o nome."); 
                    $row3=$sql_perfil3->fetch_assoc();
            ?>
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5><b><?php echo $row2['assunto'];?></b></h5>
                <h6>De: <?php echo $row2['email'];?>
                  <span class="mailbox-read-time float-right"><?php echo $row3['hora'].':'.$row3['min'].' | '.$row3['dia'].' de '.$row3['mes'].' '.$row3['ano'];?></span></h6>
              </div>
              <!-- /.mailbox-read-info -->
              
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <?php echo $row2['mensagem'];?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->
            
            <!-- /.card-footer -->
            <div class="card-footer">
              <div class="float-right">
                <?php if($row2['respondido']==0){ ?>
                <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Responder</button>
                <?php } else { echo ""; }?>
              </div>
              <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row2['idmensagem'];?>" class="view_data btn btn-default"><i class="far fa-trash-alt"></i> Apagar</button>
            </div>
            <!-- /.card-footer -->
              <?php } ?>
          </div>
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Resposta Dada</h3>
            </div>
            <!-- /.card-header -->
            <?php 
            $id = $_GET['men'];
            $sql_perfil5=$conn->query("select * from resposta_mensagm where idmensagem='".$id."'")or die("Erro ao selecionar o nome.");
                  if($sql_perfil5->num_rows>=1){ 
                    $row5=$sql_perfil5->fetch_assoc();
                    $sql_perfil4=$conn->query("SET lc_time_names = 'pt_PT'") or die("Erro selecionar o nome."); 
                    $sql_perfil4=$conn->query("select day('".$row5['data_escrita']."') as dia, year('".$row5['data_escrita']."') as ano, monthname('".$row5['data_escrita']."') AS mes,  hour('".$row5['data_escrita']."') AS hora,  minute('".$row5['data_escrita']."') AS min")or die("Erro selecionar o nome."); 
                    $row4=$sql_perfil4->fetch_assoc();
            ?>
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5><b><?php echo $row5['assunto'];?></b></h5>
                <h6>Para: <?php echo $row2['email'];?>
                  <span class="mailbox-read-time float-right"><?php echo $row4['hora'].':'.$row4['min'].' | '.$row4['dia'].' de '.$row4['mes'].' '.$row4['ano'];?></span></h6>
              </div>
              <!-- /.mailbox-read-info -->
              
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <?php echo $row5['mensagem'];?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->
            
            <!-- /.card-footer -->
            <div class="card-footer">
              <div class="float-right">
              </div>
            </div>
            <!-- /.card-footer -->
              <?php } else { ?>
            <div class="card-body p-0">
              <div class="mailbox-read-message">
                <b>Ainda não respondeu a esta mensagem</b>
              </div>
              <div class="card-footer">
                <div class="float-right">
              </div>
              <?php } ?>
            </div>
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
  aria-hidden="true" style="top: 160px; margin-left: auto; margin-right: auto;">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document" style="position: absolute;  left: 50%;  top: 27%; transform: translate(-50%, -50%);">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center" style="margin-left: 1px; background-color: #ff3547; color: white;">
        <p class="heading">Eliminar Mensagem</p>
      </div>

      <!--Body-->
      <div class="modal-body" >

        <i class="fas fa-times fa-4x animated rotateIn" style="color: #ff3547;"></i>
				<div>
          Tem acerteza que quere eliminar esta mensagem?
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
      $('.view_data').click(function(){  
           var idmail = $(this).attr("id");  
           var pg = <?php echo $_GET['pg'];?>;  
           $.ajax({  
                url:"acoes/delete_mail.php",  
                method:"post",  
                data:{idmail:idmail, pg:pg},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#modalConfirmDelete').modal("show");  
                }  
           });  
      });  
 }); 

</script>
