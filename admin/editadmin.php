<?php

if(isset($_SESSION['idutilizador']))	$id_util=$_SESSION['idutilizador'];
  else $id_util=0;
  
  if(isset($_POST['editar']) && $_POST['editar']=="Editar"){

    $nome = Addslashes($_POST['nome']);
    $email = $_POST['email'];
    $pais = (int)$_POST['pais'];
    $data = $_POST['data'];
    $prefix = (int)$_POST['prefix'];
    if(isset($_POST['telemovel'])){ $tele=$_POST['telemovel']; } else { $tele = ""; }
    $prefixx = "";
    $verificado = 1;

    if( empty(trim($_POST['nome'])) || empty(trim($_POST['email'])) || isset($_POST['telemovel']) && !is_numeric(str_replace(" ", "", $_POST['telemovel']))){
      echo "<meta http-equiv=refresh content='0; url=?pg=13&z=1'>";exit;
    } else {

      $verig=$conn->prepare("select google_account from utilizadores where idutilizador = ?") or die ("erro");

      $verig->bind_param("i",$id_util);

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
    
    $sql_perfil7=$conn->query("select email from utilizadores where email='".$email."' and idutilizador <>'".$id_util."' ")or die("Erro ao selecionar o nome.");
    if($sql_perfil7->num_rows>=1){
      echo "<meta http-equiv=refresh content='0; url=?pg=13&erro=1>";exit;
    } else {

    $sql_perfil=$conn->prepare("update utilizadores set nome=?, email=?, data=?, idpais=?, telemovel=?, prefix=?, verificado=? where idutilizador=?") or die("Falha ao editar o pefil");
		
    $sql_perfil->bind_param("sssissii", $nome,  $email, $data, $pais, $tele, $prefixx, $verificado, $id_util);  

    $sql_perfil->execute();
    
    if($sql_perfil->error){
      $sql_perfil->close();
      $sql_perfil3->close();
      $verig->close();
			echo "<meta http-equiv=refresh content='0; url=?pg=13&erro=1>";exit;
		}		
		else{
      //se correu mal redireciona com a mensagem de erro m=2
      $sql_perfil->close();
      $sql_perfil3->close();
      $verig->close();
			echo "<meta http-equiv=refresh content='0; url=?pg=13&m=1'>";exit;
    }
  }
  }

}

if(isset($_POST['enviar']) && $_POST['enviar']=="Editar"){
	$password_ant=$_POST['password_at'];
	$password1=$_POST['password1'];
  $password2=$_POST['password2'];
  
  $sql_perfil3=$conn->prepare("select password from utilizadores where idutilizador=?")or die("Erro ao selecionar o nome.");

  $sql_perfil3->bind_param("i", $id_util);

  $sql_perfil3->execute();

  $sql_perfil3->store_result();

  $sql_perfil3->bind_result($pass);

  $sql_perfil3->fetch();
	
	if(password_verify($password_ant, $pass)==0 || $password1!=$password2 || empty(trim($_POST['password1'])) || empty(trim($_POST['password2']))){
	echo"<meta http-equiv=refresh content='0; url=?pg=13&z=1'>";exit;
	} 
	else if($password1==$password2){

	$hash = password_hash($password2, PASSWORD_DEFAULT);
	
	$sql_uti=$conn->prepare("update utilizadores set password=? where idutilizador=?");

	$sql_uti->bind_param("si", $hash, $_SESSION['idutilizador']);

	$sql_uti->execute();
	
	if($sql_uti->error){  
    $sql_perfil3->close();
	echo"<meta http-equiv=refresh content='0; url=?pg=13&erro=1'>";exit;
	} 
	else {
    $sql_perfil3->close();
		echo"<meta http-equiv=refresh content='0; url=?pg=13&m=23'>";exit;
	}
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
            <h1>Perfil do Admin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Perfil do Admin</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Perfil</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <?php 
                    $id = $_SESSION['idutilizador'];

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
                  <div class="active tab-pane" id="activity">
                    <form action="?pg=13" method="post" class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" value="<?php echo $row['nome'];?>" name="nome" placeholder="Name" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" value="<?php echo $row['email'];?>" name="email" placeholder="Email" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Data de Nascimento</label>
                        <div class="col-sm-10">
                        <?php if($row['data']!="0000-00-00") { ?>
                        <input type="date" name="data" value="<?php echo $row['data'];?>" class="form-control" >
                        <?php } else { ?>
                          <input type="date" name="data" class="form-control" >
                        <?php } ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">País</label>
                        <div class="col-sm-10">
                        <select  name="pais" class="form-control">
                          <?php if($row['idpais']!=0){ ?>
                          <option value="<?php echo $row['idpais'];?>" selected><?php echo $row['pais'];?> (selecionado)</option>
                          <option value="777">Escolha um país</option>
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
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Telémovel</label>
                        <div class="col-sm-5">
                          <select  name="prefix" id="codd" class="form-control" >
                            <?php 
                            if($row['prefix']!=""){ 
                            $sql_perfil4=$conn->query("select * from pais where telemovel='".$row['prefix']."'")or die("Erro ao selecionar o nome.");
                              if($sql_perfil4->num_rows>=1){ 
                              $row4=$sql_perfil4->fetch_assoc(); ?>
                              <option value="777" selected>Escolha um prefixo</option>
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
                        <div class="col-sm-5" id="telemovell">
                        <?php if($row['telemovel']!="") { ?>
                        <input type="text" name="telemovel" datamask="<?php echo $row['telemovel']?>" value="<?php echo $row['telemovel']?>" class="form-control"  requiured placeholder="<?php echo $row['telemovel']?>">
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
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit"  name="editar" value="Editar" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                    <?php } ?>
                  <!-- /.tab-pane -->
                  

                  <div class="tab-pane" id="settings">
                    <form action="?pg=13" method="post" class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Password Atual</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="password_at" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Password Nova</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="password1" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Repita a Password Nova</label>
                        <div class="col-sm-10">
                        <input type="password" class="form-control" name="password2" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="enviar" value="Editar" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">

$(document).ready(function(){
    $('#codd').on('change', function(){
        var idpais = $(this).val();
        var idutil = <?php echo $id; ?>;
        if(idpais){
            $.ajax({
                type:'post',
                url:'acoes/getId2.php',
                data:{'idpais':idpais, "idutil":idutil},
                success:function(html){
                    $('#telemovell').html(html);
                }
            }); 
		}
    });
    
});

</script>
