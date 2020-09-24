<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <?php  $meses=['Sem mês', 'Janeiro', 'Fvereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']; ?>
            <h1>Lista de Faturas do Mês de <?php echo $meses[$_GET['mes']];?> de <?php echo $_GET['ano'];?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="?pg=16">Lista de faturas (por ano)</a></li>
              <li class="breadcrumb-item active">Lista de Faturas</li>
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
                <?php $sql_perfil4=$conn->query("select data_pagamento from reservas")or die("Erro ao selecionar o nome.");
              if($sql_perfil4->num_rows>=1){ 
                $row3=$sql_perfil4->fetch_assoc();

                $sql_perfil3=$conn->query("select * from reservas where MONTH('".$row3['data_pagamento']."')='".$_GET['mes']."' and YEAR('".$row3['data_pagamento']."')='".$_GET['ano']."' and estadia_conc<>0")or die("Erro ao selecionar o nome.");
              if($sql_perfil3->num_rows>=1){ 
                ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Número de Adultos</th>
                    <th>Número de Crianças</th>
                    <th>Preço Total + (Taxa 3.4% + 0.47€)</th>
                    <th>Data de Pagamento</th>
                    <th>Estado</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                <?php while($row2=$sql_perfil3->fetch_assoc()){ ?>
                <input type="hidden" name="reserva" value="<?php echo $row2['idreserva'];?>">
                <input type="hidden" name="ano" value="<?php echo $_GET['ano'];?>">
                <input type="hidden" name="mes" value="<?php echo $_GET['mes'];?>">
                <tr>
                  <td>
                  <?php $sql_perfil2=$conn->query("select * from utilizadores where not tipo=1 and idutilizador='".$row2['idutilizador']."'")or die("Erro ao selecionar o nome."); 
                    if($sql_perfil2->num_rows>=1){ $row=$sql_perfil2->fetch_assoc(); if($row['foto']==""){ ?>
                    <img src="../img/perfis/default.png" style="width: 40px; height: 40px; border-radius: 50px; margin-left: auto; margin-right: auto; display: block;">
                  <?php } else { ?>
                    <img src="../img/perfis/<?php echo $row['foto']; ?>" style="width: 40px; height: 40px; border-radius: 50px; margin-left: auto; margin-right: auto; display: block;">
                  <?php } } else { ?>  
                    <img src="../img/perfis/default.png" style="width: 40px; height: 40px; border-radius: 50px; margin-left: auto; margin-right: auto; display: block;">
                  <?php } ?>
                  </td>
                  <td><?php echo $row2['nome_final'];?></td>
                  <td><?php echo $row2['email_final'];?></td>
                  <td><?php echo $row2['datai'];?></td>
                  <td><?php echo $row2['dataf'];?></td>
                  <td style="text-align: center; font-size: 24px;"><?php echo $row2['num_adults'];?></td>
                  <td style="text-align: center; font-size: 24px;"><?php echo $row2['num_child'];?></td>
                  <td style="text-align: center; font-size: 24px;"><?php echo $row2['preco_total'];?> €</td>
                  <td><?php echo $row2['data_pagamento'];?></td>
                  <td>
                    <?php if($row2['estadia_conc']==0){ ?> 
                    <p class="btn btn-block btn-outline-warning btn-xs">Em Progresso/Reservada</p>
                    <?php } else if($row2['estadia_conc']==1){ ?>
                    <p class="btn btn-block btn-outline-success btn-xs">Concluida</p></td>
                    <?php } else { ?>
                      <p class="btn btn-block btn-outline-danger btn-xs">Cancelada</p></td>
                    <?php } ?>
                  <td>
                  <form action="acoes/faturas2.php?res=<?php echo $row2['idreserva'];?>" target="_blank" method="post">
                    <button type="submit" value="Create_pdf" name="create_pdf" style="border: 0px; background: transparent; color:#007bff ; margin-left: auto; margin-right: auto; display: block; font-size: 22px;"><i class="far fa-file-pdf"></i></button> 
                    </form>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
				          <tfoot>
                    <tr>
                      <th>Foto</th>
                      <th>Nome</th>
                      <th>Email</th>
                      <th>Check-In</th>
                      <th>Check-Out</th>
                      <th>Número de Adultos</th>
                      <th>Número de Crianças</th>
                      <th>Preço Total + (Taxa 3.4% + 0.47€)</th>
                      <th>Data de Pagamento</th>
                      <th>Estado</th>
                      <th>Ações</th>
                    </tr>
                </tfoot>
              </table>
              <?php } else { echo "<h5>Sem reservas efetuadas neste mês</h5>"; } } else { ?>
              <h2>Sem reservas efetuadas neste mês</h2>
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



<!--Modal: modalConfirmDelete-->
