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
    echo "<meta http-equiv=refresh content='0; url=?pg=9&erro=1'>";exit;
    $delete->close();
    $delete2->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=9&m=21'>";exit;
    $delete->close();
    $delete2->close();
  }

}

if(isset($_GET['men'])){ $id_men =$_GET['men']; } else { $id_men = 0; }

if(isset($_GET['see']) && $_GET['see']==1){

  $visto = 1;

  $sql_perfil3=$conn->query("select * from mensagens where idmensagem='".$id_men."'")or die("Erro ao selecionar o nome.");
  $row=$sql_perfil3->fetch_assoc();

  if($row['visto']==0){

  $sql_up=$conn->prepare("update mensagens set visto=? where idmensagem=?") or die("Falha ao editar o pefil");
		
  $sql_up->bind_param("ii", $visto, $id_men);

  $sql_up->execute();

  if($sql_up->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=9&erro=1'>";exit;
    $sql_up->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=11&men=".$id_men."'>";exit;
    $sql_up->close();
  }

  }	
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=11&men=".$id_men."'>";exit;
  }

}

if(isset($_GET['see']) && $_GET['see']==2){

  $visto = 1;

  $sql_perfil3=$conn->query("select * from mensagens where idmensagem='".$id_men."'")or die("Erro ao selecionar o nome.");
  $row=$sql_perfil3->fetch_assoc();

  if($row['visto']==0){

  $sql_up=$conn->prepare("update mensagens set visto=? where idmensagem=?") or die("Falha ao editar o pefil");
		
  $sql_up->bind_param("ii", $visto, $id_men);

  $sql_up->execute();

  if($sql_up->error){
    echo "<meta http-equiv=refresh content='0; url=?pg=9&erro=1'>";exit;
    $sql_up->close();
  }		
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=10&men=".$id_men."'>";exit;
    $sql_up->close();
  }

  }	
  else{
    echo "<meta http-equiv=refresh content='0; url=?pg=10&men=".$id_men."'>";exit;
  }

}

?>

<div class="wrapper">
  <!-- Navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mensagens</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Mensagens</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
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
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Caixa de entrada</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <!--Futura barra de search de emails -->
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive mailbox-messages" style="padding: 20px;">
                  <?php $sql_perfil=$conn->query("select * from mensagens")or die("Erro ao selecionar o nome.");
                  if($sql_perfil->num_rows>=1){ 
                  ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Enviado por:</th>
                    <th>Email:</th>
                    <th>Assunto:</th>
                    <th>Quando Enviou:</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                <?php while($row=$sql_perfil->fetch_assoc()){ ?>
                <tr style="<?php if($row['visto']==0){ ?>background: #fff;<?php } else { ?> background: #cccccc;<?php } ?>">
                  <?php $sql_perfil2=$conn->query("select nome, email, idutilizador from utilizadores where idutilizador='".$row['idutilizador']."'")or die("Erro ao selecionar o nome.");
                  if($sql_perfil2->num_rows>=1){ 
                    $row2=$sql_perfil2->fetch_assoc();?>
                  <td class="mailbox-name"><a href="?pg=2&util=<?php echo $row2['idutilizador'];?>"><?php echo $row2['nome'];?></a></td>
                  <td><?php echo $row2['email'];?></td>
                  <?php } else { ?>
                    <td class="mailbox-name"><a href="#">Utilizador eliminado ou sem conta</a></td>
                    <td><?php echo $row['email'];?></td>
                  <?php } ?>
                  
                  <td><span style="display: inline-block; width: 350px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><b><?php echo $row['assunto'];?></b> - <?php echo $row['mensagem'];?></span></td>
                  <?php 
                    //Tempo do Servidor
                    $sql_time=$conn->query("select CURRENT_TIMESTAMP as time")or die("Erro ao selecionar o nome.");
                    $time=$sql_time->fetch_assoc();
                    $sql_time2=$conn->query("select day('".$time['time']."') as dia, month('".$time['time']."') as mes, year('".$time['time']."') as ano, minute('".$time['time']."') as min, hour('".$time['time']."') as hour")or die("Erro ao selecionar o nome.");
                    $time2=$sql_time2->fetch_assoc();
                    //Tempo em que a mensagem foi mandada
                    $sql_time_sent=$conn->query("select data_escrita from mensagens where idmensagem='".$row['idmensagem']."'")or die("Erro ao selecionar o nome.");
                    $time_sent=$sql_time_sent->fetch_assoc();
                    $sql_time_sent2=$conn->query("select day('".$time_sent['data_escrita']."') as dia, month('".$time_sent['data_escrita']."') as mes, year('".$time_sent['data_escrita']."') as ano, minute('".$time_sent['data_escrita']."') as min, hour('".$time_sent['data_escrita']."') as hour")or die("Erro ao selecionar o nome.");
                    $time_sent2=$sql_time_sent2->fetch_assoc();
                    //Calculo de datas
                    $sql_diff=$conn->query("select TIMESTAMPDIFF(HOUR, '".$time_sent['data_escrita']."', '".$time['time']."') as diff_hour, TIMESTAMPDIFF(minute, '".$time_sent['data_escrita']."', '".$time['time']."') as diff_min, TIMESTAMPDIFF(day, '".$time_sent['data_escrita']."', '".$time['time']."') as diff_day , TIMESTAMPDIFF(month, '".$time_sent['data_escrita']."', '".$time['time']."') as diff_mes, TIMESTAMPDIFF(year, '".$time_sent['data_escrita']."', '".$time['time']."') as diff_ano")or die("Erro ao selecionar o nome.");
                    $time_diff=$sql_diff->fetch_assoc();
                    ?>
                    <?php if($time_diff['diff_min']<60){ ?>
                    <td class="mailbox-date">À <?php echo  $time_diff['diff_min'];?> minuto/s</td>
                    <?php } else if($time_diff['diff_min']>=60 && $time_diff['diff_hour']<24){ ?>
                      <td class="mailbox-date">À <?php echo  $time_diff['diff_hour'];?> hora/s</td>
                    <?php } else if($time_diff['diff_hour']>=24 && $time_diff['diff_day']<31){ ?>
                      <td class="mailbox-date">À <?php echo  $time_diff['diff_day'];?> dia/s</td>
                    <?php } else if($time_diff['diff_day']>=31 && $time_diff['diff_ano']<1){ ?>
                      <td class="mailbox-date">À <?php echo  $time_diff['diff_mes'];?> mes/s</td>
                    <?php } else if($time_diff['diff_mes']>=12){ ?>
                      <td class="mailbox-date">À <?php echo  $time_diff['diff_ano'];?> ano/s</td>
                    <?php } ?>
                    <td class="mailbox-date">
                      <a href="?pg=9&men=<?php echo $row['idmensagem'];?>&see=1" style="padding-right: 5px;"><i class="far fa-eye"></i></a>
                      <?php if($row['respondido']==0){ ?> 
                      <a href="?pg=9&men=<?php echo $row['idmensagem'];?>&see=2" style="padding-right: 5px;"><i class="fas fa-reply"></i></a>  
                      <?php } else { echo ""; } ?>
                      <button type="button" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idmensagem'];?>" class="view_data" style=" border: 0px; background: transparent; color: #007bff;">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
				        <tfoot>
                  <tr>
                    <th>Enviado por:</th>
                    <th>Email:</th>
                    <th>Assunto:</th>
                    <th>Quando Enviou:</th>
                    <th>Ações:</th>
                  </tr>
                </tfoot>
              </table>
                <?php } ?>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
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
  </div>
  <!-- /.content-wrapper -->
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Page Script -->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
  aria-hidden="true" style="top: 160px; margin-left: auto; margin-right: auto;">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document" style="position: absolute;  left: 50%;  top: 30%; transform: translate(-50%, -50%);">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center" style="margin-left: 1px; background-color: #ff3547; color: white;">
        <p class="heading">Eliminar Mnesagem</p>
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