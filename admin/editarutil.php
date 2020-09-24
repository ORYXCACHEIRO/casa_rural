<?php

if(isset($_GET['util']))	$id_util=$_GET['util'];
  else $id_util=0;
  
  if(isset($_POST['editar']) && $_POST['editar']=="Editar"){

    $nome = Addslashes($_POST['nome']);
    $email = $_POST['email'];
    $pais = (int)$_POST['pais'];
    $data = $_POST['data'];
    $prefix = (int)$_POST['prefix'];
    if(isset($_POST['telemovel'])){ $tele=$_POST['telemovel']; } else { $tele = ""; }
    $prefixx = "";
    $id = (int)$_GET['util'];
    $verificado = 1;

    if( empty(trim($_POST['nome'])) || empty(trim($_POST['email'])) || isset($_POST['telemovel']) && !is_numeric(str_replace(" ", "", $_POST['telemovel']))){
      echo "<meta http-equiv='refresh' content='0; url=?pg=2&util=".$id."&z=1'>";exit;
    } else {

      $verig=$conn->prepare("select google_account from utilizadores where idutilizador = ?") or die ("erro");

      $verig->bind_param("i",$id);

      $verig->execute();

      $verig->store_result();

      $verig->bind_result($google);
      
      $verig->fetch();

      if($prefix=="7000" || $prefix==""){
				
      } else {

      $sql_perfil3=$conn->prepare("select telemovel from pais where idpais=?")or die("Erro ao selecionar o nome.");

      $sql_perfil3->bind_param("i", $prefix);
  
      $sql_perfil3->execute();
  
      $sql_perfil3->store_result();
  
      $sql_perfil3->bind_result($prefixx);

      if($sql_perfil3->num_rows>=1){
  
        $sql_perfil3->fetch();

      } else {
        $prefixx = "";
        $tele = "";
      }
  
      }

      if(empty(trim($_POST['data']))){
        $data = "0000-00-00";
      }

      if($pais=="777" || $pais==""){
        $pais = 0;
      } else { 
  
      $sql_perfil6=$conn->query("select idpais from pais where idpais='".$pais."'")or die("Erro ao selecionar o nome.");
      if($sql_perfil6->num_rows>=1){
        $ln_perfil6=$sql_perfil6->fetch_assoc();
        $pais=$ln_perfil6['idpais'];
      } else {
        $pais = 0;
      }
  
      }

    $veri5=$conn->prepare("select email from utilizadores where idutilizador= ?") or die ("erro2");

    $veri5->bind_param("i", $id);

    $veri5->execute();

    $veri5->store_result();

    $veri5->bind_result($email2);

    $veri5->fetch();

    if($email!=$email2){
      $verificado = 0;
    } else $verificado = 1;
    
    $sql_perfil7=$conn->query("select email from utilizadores where email='".$email."' and idutilizador <>'".$id."' ")or die("Erro ao selecionar o nome.");
    if($sql_perfil7->num_rows>=1){
      echo "<meta http-equiv=refresh content='0; url=?pg=2&util=".$id."&erro=1'>";exit;
    } else {

    $sql_perfil8=$conn->query("select email from utilizadores_block where email='".$email."'")or die("Erro ao selecionar o nome.");
    if($sql_perfil8->num_rows>=1){
      echo "<meta http-equiv=refresh content='0; url=?pg=2&util=".$id."&z=3'>";exit;
    } else {

    $sql_perfil=$conn->prepare("update utilizadores set nome=?, email=?, data=?, idpais=?, telemovel=?, prefix=?, verificado=? where idutilizador=?") or die("Falha ao editar o pefil");
		
    $sql_perfil->bind_param("sssissii", $nome,  $email, $data, $pais, $tele, $prefixx, $verificado, $id);  

    $sql_perfil->execute();
    
    if($sql_perfil->error){
      $sql_perfil->close();
      $sql_perfil3->close();
      $verig->close();
      $veri5->close();
			echo "<meta http-equiv=refresh content='0; url=?pg=2&util=".$id."&erro=1'>";exit;
		}		
		else{
      //se correu mal redireciona com a mensagem de erro m=2
      $sql_perfil->close();
      $sql_perfil3->close();
      $verig->close();
      $veri5->close();
			echo "<meta http-equiv=refresh content='0; url=?pg=1&m=1'>";exit;
    }
  }
  }
  }

}

?> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar Utilizador</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><a href="?pg=1">Utilizadores</a></li>
              <li class="breadcrumb-item active">Editar Utilizador</li>
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
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Informação</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
                $id = $_GET['util'];

                $sql_perfil5=$conn->query("select idpais from utilizadores where idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
                  $row5=$sql_perfil5->fetch_assoc();
                   
                if($row5['idpais']==0){
                  $sql_perfil2=$conn->query("select * from utilizadores where idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
                } else { 
                  $sql_perfil2=$conn->query("select utilizadores.*,pais.paisNome as pais from utilizadores, pais where pais.idpais=utilizadores.idpais AND utilizadores.idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
                }
                if($sql_perfil2->num_rows>=1){ 
                    $row=$sql_perfil2->fetch_assoc();

                  
              ?>
              <form action="?pg=2<?php echo "&util=".$_GET["util"];?>" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <div style="width: 47%; float: right; ">
                      <label for="exampleInputEmail1">Email *</label>
                      <input type="email" name="email" value="<?php echo $row['email'];?>" class="form-control"  placeholder="ex: email@email.com">
                    </div>
                    <div style="width: 47%; float left;">
                      <label for="exampleInputEmail1">Nome *</label>
                      <input type="text" name="nome" value="<?php echo $row['nome'];?>" class="form-control" placeholder="ex: Nome">
                    </div>
                  </div>
                  <div class="form-group">
                    <div style="width: 47%; float: right; ">
                      <label for="exampleInputEmail1">País</label>
                      <select  name="pais" class="form-control">
                      <?php if($row['idpais']!=0){ ?>
                      <option value="777">Escolha um país</option>
                      <option value="<?php echo $row['idpais'];?>" selected><?php echo $row['pais'];?> (selecionado)</option>
                      <?php } else {  ?>
                      <option value="777">Escolha um país</option>
                      <?php } ?>
                      <?php $sql_perfil=$conn->query("select * from pais")or die("Erro ao selecionar o nome.");
                      if($sql_perfil->num_rows>=1){ 
                        while($row2=$sql_perfil->fetch_assoc()){ ?>
                          <option value="<?php echo $row2['idpais'];?>"><?php echo $row2['paisNome'];?></option>
                      <?php } } ?>
                      </select>
                    </div>
                    <div style="width: 47%; float left;">
                      <label for="exampleInputEmail1">Data</label>
                      <?php if($row['data']!="0000-00-00") { ?>
                      <input type="date" name="data" value="<?php echo $row['data'];?>" class="form-control" >
                      <?php } else { ?>
                        <input type="date" name="data" class="form-control" >
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div style="width: 47%; float: right; " id="telemovell">
                      <label for="exampleInputEmail1">Telémovel</label>
                      <?php if($row['telemovel']!="") { ?>
                      <input type="text" name="telemovel" datamask="<?php echo $row['telemovel']?>" value="<?php echo $row['telemovel']?>" class="form-control"  requiured placeholder="00/00/0000">
                      <script>
                        $('input[name="telemovel"]').mask('<?php echo $row['telemovel']?>');

                        $('input[name="telemovel"]').focusout(function(){
                        $('input[name="telemovel"]').val( this.value.toUpperCase());
                        });
                      </script>
                      <?php } else { ?>
                        <input type="text" class="form-control"  readonly placeholder="Escolha um prefixo primeiro">
                      <?php } ?>
                    </div>
                    <div style="width: 47%; float left;">
                    <label for="exampleInputEmail1">Prefixo</label>
                      <select  name="prefix" id="codd" class="form-control" >
                      <?php 
                      if($row['prefix']!=""){ 
                      $sql_perfil4=$conn->query("select * from pais where telemovel='".$row['prefix']."'")or die("Erro ao selecionar o nome.");
                        if($sql_perfil4->num_rows>=1){ 
                        $row4=$sql_perfil4->fetch_assoc(); ?>
                        <option value="<?php echo $row4['idpais'];?>" selected><?php echo $row4['telemovel'];?> <?php echo $row4['ISO'];?> (selecionado)</option>
                      <?php } } else { ?>
                        <option value="777" selected>Escolha um prefixo</option>
                      <?php } ?>
                      <?php $sql_perfil3=$conn->query("select * from pais order by ISO")or die("Erro ao selecionar o nome.");
                            if($sql_perfil3->num_rows>=1){ 
                            while($row3=$sql_perfil3->fetch_assoc()){ ?>
                              <option value="<?php echo $row3['idpais']?>"><?php echo $row3['telemovel']?> <?php echo $row3['ISO']?></option>
                      <?php } } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="editar" value="Editar" class="btn btn-primary">Editar</button>
                  <a href="?pg=1" class="btn btn-primary">Voltar atrás</a>
                </div>
              </form>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    </div>

<script type="text/javascript">

$(document).ready(function(){
    $('#codd').on('change', function(){
        var idpais = $(this).val();
        var idutil = <?php echo $_GET['util']; ?>;
        if(idpais){
            $.ajax({
                type:'post',
                url:'getId.php',
                data:{'idpais':idpais, "idutil":idutil},
                success:function(html){
                    $('#telemovell').html(html);
                }
            }); 
		}
    });
    
});

</script>