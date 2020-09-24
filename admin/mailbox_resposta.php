

<div class="wrapper">
  <!-- Navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mensagens Enviadas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Mensagens Enviadas</li>
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
              <div class="table-responsive mailbox-messages"  style="padding: 20px;">
              <?php $sql_perfil=$conn->query("select * from resposta_mensagm")or die("Erro ao selecionar o nome.");
                if($sql_perfil->num_rows>=1){ 
                ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Respondeu a:</th>
                    <th>Assunto:</th>
                    <th>Quando Respondeu:</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                <?php while($row=$sql_perfil->fetch_assoc()){ ?>
                <tr>
                <?php 
                $sql_perfil2=$conn->query("select idutilizador from mensagens where idmensagem='".$row['idmensagem']."'")or die("Erro ao selecionar o nome.");    
                $row2=$sql_perfil2->fetch_assoc();
                $sql_perfil7=$conn->query("select nome, idutilizador from utilizadores where idutilizador='".$row2['idutilizador']."'")or die("Erro ao selecionar o nome.");    
                if($sql_perfil7->num_rows>=1){ 
                    $row7=$sql_perfil7->fetch_assoc();?>
                <td class="mailbox-name"><a href="?pg=2&util=<?php echo $row7['idutilizador'];?>"><?php echo $row7['nome'];?></a></td>
                <?php } else { ?>
                    <td class="mailbox-name"><a href="#">Utilizador eliminado</a></td>
                <?php } ?>
                  <td><b style="display: inline-block;"><?php echo $row['assunto'];?></b></td>
                  <?php 
                    //Tempo do Servidor
                    $sql_time=$conn->query("select CURRENT_TIMESTAMP as time")or die("Erro ao selecionar o nome.");
                    $time=$sql_time->fetch_assoc();
                    $sql_time2=$conn->query("select day('".$time['time']."') as dia, month('".$time['time']."') as mes, year('".$time['time']."') as ano, minute('".$time['time']."') as min, hour('".$time['time']."') as hour")or die("Erro ao selecionar o nome.");
                    $time2=$sql_time2->fetch_assoc();
                    //Tempo em que a mensagem foi mandada
                    $sql_time_sent=$conn->query("select data_escrita from resposta_mensagm where idmensagem='".$row['idmensagem']."'")or die("Erro ao selecionar o nome.");
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
                      <a href="?pg=11&men=<?php echo $row['idmensagem'];?>" style="padding-right: 5px;"><i class="far fa-eye"></i></a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
				<tfoot>
                  <tr>
                    <th>Respondeu a:</th>
                    <th>Assunto:</th>
                    <th>Quando Respondeu:</th>
                    <th>Ações:</th>
                  </tr>
                </tfoot>
              </table>
                <?php } ?>
              </div>
            </div>        
            </div>
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