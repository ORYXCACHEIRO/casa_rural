<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Home</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <?php $sql_casa2=$conn->query("select count(*) as total from utilizadores where not tipo=1")or die("Erro ao selecionar o nome."); 
              if($sql_casa2->num_rows>=1){
                $row = $sql_casa2->fetch_assoc();?>
                <h3><?php echo $row['total'];?></h3>
              <?php } else { ?>
                <h3>Sem utlizadores</h3>
              <?php } ?>
                <p>Nº de utlizadores</p>
              </div>
              <div class="icon">
              <i class="fas fa-users"></i>
              </div>
              <a href="?pg=1" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <?php $sql_casa2=$conn->query("select count(*) as total from avaliacoes")or die("Erro ao selecionar o nome."); 
              if($sql_casa2->num_rows>=1){
                $row = $sql_casa2->fetch_assoc();?>
                <h3><?php echo $row['total'];?></h3>
              <?php } else { ?>
                <h3>Sem nenhuma avaliação</h3>
              <?php } ?>
                <p>Avaliações</p>
              </div>
              <div class="icon">
              <i class="far fa-star"></i>
              </div>
              <a href="?pg=15" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <?php $atual=$conn->query("select CURDATE() as atual")or die("Erro ao selecionar o nome.");
                $data_at=$atual->fetch_assoc();

                $sql_perfil4=$conn->query("select data_pagamento from reservas")or die("Erro ao selecionar o nome.");
              if($sql_perfil4->num_rows>=1){ 
                $row3=$sql_perfil4->fetch_assoc();
                
                $sql_perfil3=$conn->query("select count(*) as total from reservas where MONTH('".$row3['data_pagamento']."')='".$data_at['atual']."' and YEAR('".$row3['data_pagamento']."')='".$data_at['atual']."' and estadia_conc=0 and data_pagamento<=now()")or die("Erro ao selecionar o nome.");
              if($sql_perfil3->num_rows>=1){ 
                $row4 = $sql_perfil3->fetch_assoc();?>
                <h3><?php echo $row4['total'];?></h3>
              <?php } else{ echo "<h3>0</h3>"; } } else { ?>
                <h3>0</h3>
              <?php } ?>
                <p>Reservas a decorrer este mês</p>
              </div>
              <div class="icon">
              <i class="fas fa-book"></i>
              </div>
              <a href="?pg=18" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php $sql_casa2=$conn->query("select count(*) as total from mensagens where visto=0")or die("Erro ao selecionar o nome."); 
              if($sql_casa2->num_rows>=1){
                $row = $sql_casa2->fetch_assoc();?>
                <h3><?php echo $row['total'];?></h3>
              <?php } else { ?>
                <h3>0</h3>
              <?php } ?>
                <p>Mensagens por ver</p>
              </div>
              <div class="icon">
              <i class="far fa-bell"></i>
              </div>
              <a href="?pg=9" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>