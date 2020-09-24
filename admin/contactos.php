<?php
  
  if(isset($_POST['editar']) && $_POST['editar']=="Editar"){

    $email = Addslashes($_POST['email']);
    $fb = Addslashes($_POST['fb']);
    $twitter = Addslashes($_POST['twitter']);
    $insta = Addslashes($_POST['insta']);
    $morada = Addslashes($_POST['morada']);
    $mapa = $_POST['mapa'];
    $tele = $_POST['tele'];
    $footerpt = Addslashes($_POST['footer_pt']);
    $footeres = Addslashes($_POST['footer_es']);
    $footeren = Addslashes($_POST['footer_en']);

    if( empty(trim($_POST['email'])) || empty(trim($_POST['fb'])) || empty(trim($_POST['twitter'])) || empty(trim($_POST['insta'])) || empty(trim($_POST['morada'])) || empty(trim($_POST['mapa'])) || empty(trim($_POST['tele'])) || empty(trim($_POST['footer_pt'])) || empty(trim($_POST['footer_en'])) || empty(trim($_POST['footer_es']))){
      echo "<meta http-equiv=refresh content='0; url=?pg=2&z=1'>";exit;
    } else {
    
    $sql_perfil=$conn->prepare("update contactos set email=?, face=?, insta=?, twitter=?, morada=?, mapa=? , tele=?") or die("Falha ao editar o pefil");
		
	$sql_perfil->bind_param("sssssss", $email,  $fb, $insta, $twitter, $morada, $mapa, $tele);

    $sql_perfil->execute();

    $sql_perfil2=$conn->prepare("update footer set texto=?, texto_en=?, texto_es=?") or die("Falha ao editar o pefil");
		
    $sql_perfil2->bind_param("sss", $footerpt, $footeren, $footeres);
  
      $sql_perfil2->execute();
    
    if($sql_perfil->error || $sql_perfil2->error){
      echo "<meta http-equiv=refresh content='0; url=?pg=4&erro=1>";exit;
      $sql_perfil->close();
      $sql_perfil2->close();
		}		
		else{
      //se correu mal redireciona com a mensagem de erro m=2
      $sql_perfil->close();
      $sql_perfil2->close();
			echo "<meta http-equiv=refresh content='0; url=?pg=4&m=3'>";exit;
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
            <h1>Editar Contactos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Contactos</li>
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
                $sql_perfil2=$conn->query("select * from contactos")or die("Erro ao selecionar o nome.");
                  if($sql_perfil2->num_rows>=1){ 
                    $row=$sql_perfil2->fetch_assoc();
              ?>
              <form action="?pg=4" method="post">
                <div class="card-body">
                  <div class="form-group">
                        <div style="width: 47%; float: right; ">
                        <label for="exampleInputEmail1">Telémovel</label>
                        <input type="text" name="tele" data-mask="(+351) 000 000 000" value="<?php echo $row['tele'];?>" class="form-control"  placeholder="ex: +351 910 000 000" required>
                        </div>
                        <div style="width: 47%; float left;">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" value="<?php echo $row['email'];?>" class="form-control" placeholder="ex: example@example.com" required>
                        </div>
                  </div>
                  <div class="form-group">
                        <div style="width: 47%; float: right; ">
                        <label for="exampleInputEmail1">Morada</label>
                        <input type="text" name="morada" value="<?php echo $row['morada'];?>" class="form-control" placeholder="ex: morada nº00 rua do exemplo, cidade" required>
                        </div>
                        <div style="width: 47%; float left;">
                        <label for="exampleInputEmail1">Link facebook</label>
                        <input type="text" name="fb"  value="<?php echo $row['face'];?>" class="form-control"  placeholder="Qualquer coisa" required>
                        </div>
                  </div>
                  <div class="form-group">
                        <div style="width: 47%; float: right; ">
                            <label for="exampleInputEmail1">Link Twitter</label>
                            <input type="text" name="twitter" value="<?php echo $row['twitter'];?>" class="form-control"  placeholder="00/00/0000" required>
                        </div>
                        <div style="width: 47%; float left;">
                        <label for="exampleInputEmail1">Link Instagram</label>
                            <input type="text" name="insta"  value="<?php echo $row['insta'];?>" class="form-control"  placeholder="00/00/0000" required>
                        </div>
                  </div>
                  <div class="form-group">
                        <label for="exampleInputEmail1">Mapa da casa (Google Maps)</label>
                        <?php echo $row['mapa'];?>
                        <p><strong>Nota importante: Width no código quere dizer largura e Height altura, portanto depois de mudar de mapa verifique se ambos os valores coicidem com 1140 pixeis de largura e 470 de altura</strong></p>
                        <textarea style="margin-top: 10px;" type="text" name="mapa" class="form-control" rows="4" placeholder="Pesquisar no google maps mapa através do partilhar" required><?php echo $row['mapa'];?></textarea>
                  </div>
                  <div class="form-group">
                  <?php $sql_perfil3=$conn->query("select * from footer")or die("Erro ao selecionar o nome.");
                   if($sql_perfil3->num_rows>=1){ 
                    $row2=$sql_perfil3->fetch_assoc(); ?>
                        <label for="exampleInputEmail1">Frase do footer PT</label>
                        <textarea type="text" name="footer_pt"  class="form-control"  placeholder="Qualquer coisa" required><?php echo $row2['texto'];?></textarea>
                        <label for="exampleInputEmail1">Frase do footer ES</label>
                        <textarea type="text" name="footer_es"   class="form-control"  placeholder="Qualquer coisa" required><?php echo $row2['texto_es'];?></textarea>
                        <label for="exampleInputEmail1">Frase do footer EN</label>
                        <textarea type="text" name="footer_en"   class="form-control"  placeholder="Qualquer coisa" required><?php echo $row2['texto_en'];?></textarea>
                   <?Php } ?>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="editar" value="Editar" class="btn btn-primary">Editar</button>
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


$('input[name="tele"]').mask('(+351) 000 000 000');

$('input[name="tele"]').focusout(function(){
$('input[name="tele"]').val( this.value.toUpperCase());
});
</script>