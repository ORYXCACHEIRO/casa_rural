<?php 

if(isset($_POST['pt']) && $_POST['pt']=="PT"){

  $banner_tittlept = Addslashes($_POST['banner_tittlept']);
  $banner_textpt = Addslashes($_POST['banner_textpt']);
  $sobreh_tittlept = Addslashes($_POST['sobreh_tittlept']);
  $sobreh_textpt = Addslashes($_POST['sobreh_textpt']);

  if( empty(trim($_POST['banner_tittlept'])) || empty(trim($_POST['banner_textpt'])) || empty(trim($_POST['sobreh_tittlept'])) || empty(trim($_POST['sobreh_textpt']))){
    echo "<meta http-equiv=refresh content='0; url=?pg=3&z=1'>";exit;
  } else {
  
  $sql_perfil=$conn->prepare("update banner_text set tittle_pt=?, text_pt=?") or die("Falha ao editar o pefil");

  $sql_perfil2=$conn->prepare("update sobre_home set tittle_pt=?, text_pt=?") or die("Falha ao editar o pefil");
  
  $sql_perfil->bind_param("ss", $banner_tittlept, $banner_textpt);

  $sql_perfil2->bind_param("ss",$sobreh_tittlept, $sobreh_textpt);

  $sql_perfil->execute();

  $sql_perfil2->execute();
  
  if($sql_perfil->error || $sql_perfil2->error ){
    echo "<meta http-equiv=refresh content='0; url=?pg3&erro=1>";exit;
  }		
  else{
    //se correu mal redireciona com a mensagem de erro m=2
    $sql_perfil->close();
    $sql_perfil2->close();
    echo "<meta http-equiv=refresh content='0; url=?pg=3&m=3'>";exit;
  }
}
}

if(isset($_POST['es']) && $_POST['es']=="ES"){

  $banner_tittlees = Addslashes($_POST['banner_tittlees']);
  $banner_textes = Addslashes($_POST['banner_textes']);
  $sobreh_tittlees = Addslashes($_POST['sobreh_tittlees']);
  $sobreh_textes = Addslashes($_POST['sobreh_textes']);

  if( empty(trim($_POST['banner_tittlees'])) || empty(trim($_POST['banner_textes'])) || empty(trim($_POST['sobreh_tittlees'])) || empty(trim($_POST['sobreh_textes']))){
    echo "<meta http-equiv=refresh content='0; url=?pg=3&z=1'>";exit;
  } else {
  
  $sql_perfil=$conn->prepare("update banner_text set tittle_es=?, text_es=?") or die("Falha ao editar o pefil");

  $sql_perfil2=$conn->prepare("update sobre_home set tittle_es=?, text_es=?") or die("Falha ao editar o pefil");
  
  $sql_perfil->bind_param("ss", $banner_tittlees, $banner_textes);

  $sql_perfil2->bind_param("ss",$sobreh_tittlees, $sobreh_textes);

  $sql_perfil->execute();

  $sql_perfil2->execute();
  
  if($sql_perfil->error || $sql_perfil2->error ){
    echo "<meta http-equiv=refresh content='0; url=?pg3&erro=1>";exit;
  }		
  else{
    //se correu mal redireciona com a mensagem de erro m=2
    $sql_perfil->close();
    $sql_perfil2->close();
    echo "<meta http-equiv=refresh content='0; url=?pg=3&m=3'>";exit;
  }
}
}

if(isset($_POST['en']) && $_POST['en']=="EN"){

  $banner_tittleen = Addslashes($_POST['banner_tittleen']);
  $banner_texten = Addslashes($_POST['banner_texten']);
  $sobreh_tittleen = Addslashes($_POST['sobreh_tittleen']);
  $sobreh_texten = Addslashes($_POST['sobreh_texten']);

  if( empty(trim($_POST['banner_tittleen'])) || empty(trim($_POST['banner_texten'])) || empty(trim($_POST['sobreh_tittleen'])) || empty(trim($_POST['sobreh_texten']))){
    echo "<meta http-equiv=refresh content='0; url=?pg=3&z=1'>";exit;
  } else {
  
  $sql_perfil=$conn->prepare("update banner_text set tittle_en=?, text_en=?") or die("Falha ao editar o pefil");

  $sql_perfil2=$conn->prepare("update sobre_home set tittle_en=?, text_en=?") or die("Falha ao editar o pefil");
  
  $sql_perfil->bind_param("ss", $banner_tittleen, $banner_texten);

  $sql_perfil2->bind_param("ss",$sobreh_tittleen, $sobreh_texten);

  $sql_perfil->execute();

  $sql_perfil2->execute();
  
  if($sql_perfil->error || $sql_perfil2->error ){
    echo "<meta http-equiv=refresh content='0; url=?pg3&erro=1>";exit;
  }		
  else{
    //se correu mal redireciona com a mensagem de erro m=2
    $sql_perfil->close();
    $sql_perfil2->close();
    echo "<meta http-equiv=refresh content='0; url=?pg=3&m=3'>";exit;
  }
}
}

?>
<div class="wrapper">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sobre a casa | Home</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Casa</li>
              <li class="breadcrumb-item active">Sobre a casa | Home</li>
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
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Português</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Espanhol</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Inglês</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                  <?php 
                    $sql_casa2=$conn->query("select * from banner_text")or die("Erro ao selecionar o nome.");
                    $sql_casaa2=$conn->query("select * from sobre_home")or die("Erro ao selecionar o nome.");
                        if($sql_casa2->num_rows>=1 && $sql_casaa2->num_rows>=1){ 
                          $row2=$sql_casa2->fetch_assoc();
                          $roww2=$sql_casaa2->fetch_assoc();?>
                  <form action="?pg=3" method="post" class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Titulo com Banner</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="banner_tittlept" id="inputName" value="<?php echo $row2['tittle_pt']?>" placeholder="Name" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Texto descritivo com Banner</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" name="banner_textpt" placeholder="Experience" required><?php echo $row2['text_pt']?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Titulo sobre a casa</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="sobreh_tittlept" value="<?php echo $roww2['tittle_pt']?>" placeholder="Name" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Texto descritivo sobre a casa</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience"  name="sobreh_textpt" placeholder="Experience" required><?php echo $roww2['text_pt']?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="pt" value="PT" class="btn btn-danger">Editar</button>
                        </div>
                      </div>
                    </form>
                        <?php } ?>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <?php 
                    $sql_casa=$conn->query("select * from banner_text")or die("Erro ao selecionar o nome.");
                    $sql_casaa=$conn->query("select * from sobre_home")or die("Erro ao selecionar o nome.");
                        if($sql_casa->num_rows>=1 && $sql_casaa->num_rows>=1){ 
                          $row=$sql_casa->fetch_assoc();
                          $roww=$sql_casaa->fetch_assoc();?>
                    <form action="?pg=3" method="post" class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Titulo com Banner</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="banner_tittlees" value="<?php echo $row['tittle_es']?>" id="inputName" placeholder="Name" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Texto descritivo com Banner</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" name="banner_textes" placeholder="Experience" required><?php echo $row['text_es']?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Titulo sobre a casa</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="sobreh_tittlees"  value="<?php echo $roww['tittle_es']?>" placeholder="Name" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Texto descritivo sobre a casa</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" name="sobreh_textes"  placeholder="Experience" required><?php echo $roww['text_es']?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="es" value="ES" class="btn btn-danger">Editar</button>
                        </div>
                      </div>
                    </form>
                        <?php } ?>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                  <?php 
                    $sql_casa3=$conn->query("select * from banner_text")or die("Erro ao selecionar o nome.");
                    $sql_casaa3=$conn->query("select * from sobre_home")or die("Erro ao selecionar o nome.");
                        if($sql_casa3->num_rows>=1 && $sql_casaa3->num_rows>=1){ 
                          $row3=$sql_casa3->fetch_assoc();
                          $roww3=$sql_casaa3->fetch_assoc();?>
                    <form action="?pg=3" method="post" class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Titulo com Banner</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="banner_tittleen" value="<?php echo $row3['tittle_en']?>" placeholder="Name" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Texto descritivo com Banner</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" name="banner_texten" placeholder="Experience" required><?php echo $row3['text_en']?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Titulo sobre a casa</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" name="sobreh_tittleen" value="<?php echo $roww3['tittle_en']?>" placeholder="Name" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Texto descritivo sobre a casa</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" name="sobreh_texten" placeholder="Experience" required><?php echo $roww3['text_en']?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="en" value="EN" class="btn btn-danger">Editar</button>
                        </div>
                      </div>
                    </form>
                        <?php } ?>
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
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
