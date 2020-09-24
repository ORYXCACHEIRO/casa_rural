
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Faturações (Por ano)</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Lista de Faturações</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12" style="padding: 130px;">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Informação</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
                $atual=$conn->query("select CURDATE() as atual")or die("Erro ao selecionar o nome.");
                $data_at=$atual->fetch_assoc();

                $ano=$conn->query("select YEAR('".$data_at['atual']."') as ano, MONTH('".$data_at['atual']."') as mes")or die("Erro ao selecionar o nome.");
                $ano2=$ano->fetch_assoc();

                $insere_ano=$conn->query("select * from reservas_anos where ano='".$ano2['ano']."'")or die("Erro ao selecionar o nome.");
                if($insere_ano->num_rows>=1){ 
                    //Não insere
                } else {

                    $sql_insereregisto=$conn->prepare("Insert into reservas_anos (ano) VALUES (?) ") or die("Erro ao inserir o registo");

                    $sql_insereregisto->bind_param("i", $ano2['ano']);
                
                    $sql_insereregisto->execute();
                }

                $sql_perfil2=$conn->query("select * from reservas_anos")or die("Erro ao selecionar o nome.");
                  if($sql_perfil2->num_rows>=1){ 
                  
              ?>
              <form action="?pg=4" method="post">
                <div class="card-body" style="padding: 50px;">
                <?php while($row=$sql_perfil2->fetch_assoc()){ 
                  $meses=['Sem mês', 'Janeiro', 'Fvereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
                  if($row['ano']==2020){ $mes = 7; } else { $mes=1; }?>
                    <div class="form-group">
                        <div style="width: 100%;">
                            <div class="btn-group" style="width: 100%;">
                                <button class="btn btn-primary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ano <?php echo $row['ano'];?>
                                </button>
                                <div class="dropdown-menu" style="width:100%;">
                                  <?php while($mes<=12){ ?>
                                  <?php if($mes>$ano2['mes'] || $row['ano']>$ano2['ano']){ ?>
                                  <a href="#" class="dropdown-item" style="text-align: center; font-size: 18px; background: #d9d9d9;" disabled><?php echo $meses["$mes"];?> <i class="fas fa-lock"></i></a>
                                  <?php } else { ?>
                                    <a href="?pg=17&ano=<?php echo $row['ano'];?>&mes=<?php echo $mes;?>" class="dropdown-item" style="text-align: center; font-size: 18px;"><?php echo $meses["$mes"];?></a>
                                  <?php } ?>
                                  <?php $mes += 1; } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
                <!-- /.card-body -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    </div>

<script type="text/javascript">


$('input[name="tele"]').mask('(+351) 000 000 000');

$('input[name="tele"]').focusout(function(){
$('input[name="tele"]').val( this.value.toUpperCase());
});
</script>