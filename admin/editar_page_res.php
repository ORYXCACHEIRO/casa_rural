<?php

include 'php-image-resize/lib/ImageResize.php';

use \Gumlet\ImageResize;

if(isset($_POST['enviar']) && $_POST['enviar']=="Editar"){

    $precoep_baixa = (int)$_POST['precoep_baixa'];
    $precoep_alta = (int)$_POST['precoep_alta'];
    $foto = $_FILES['foto']['name'];
    $maxp = (int)$_POST['adultos'];
    $kids = (int)$_POST['kids'];

    //PT
    $compart_pt = addslashes($_POST['compart_pt']);
    $serv_pt = addslashes($_POST['serv_pt']);
    $regras_pt = $_POST['regras_pt'];
    //EN
    $compart_en = addslashes($_POST['compart_en']);
    $serv_en = addslashes($_POST['serv_en']);
    $regras_en = $_POST['regras_en'];
    //ES
    $compart_es = addslashes($_POST['compart_es']);
    $serv_es = addslashes($_POST['serv_es']);$tempo=$conn->query("SELECT CURDATE() as atual") or die("Erro selecionar o nome."); 
      $time = $tempo->fetch_assoc();
    $regras_es = $_POST['regras_es'];
    
    if( empty(trim($_POST['compart_pt'])) || empty(trim($_POST['serv_pt'])) || empty(trim($_POST['regras_pt'])) || empty(trim($_POST['compart_en'])) || empty(trim($_POST['serv_en'])) || empty(trim($_POST['regras_en'])) || empty(trim($_POST['compart_es'])) || empty(trim($_POST['serv_es'])) || empty(trim($_POST['regras_es'])) || !is_numeric($_POST['precoep_alta']) || !is_numeric($_POST['precoep_baixa']) || !is_numeric($_POST['adultos']) || !is_numeric($_POST['kids'])){
        echo "<meta http-equiv='refresh' content='0; url=?pg=14&z=1'>";exit;
    } else {

        if(isset($_FILES['foto']) && $_FILES['foto']['name']!=""){

        $extensao= strtolower (substr($_FILES['foto']['name'], -4));
        $novo_nome= md5(time()).$extensao;
        $diretorio="../img/room/";
        $temporario="../img/temporario/";
        $target_file = $diretorio.$novo_nome;
        
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $extensions_arr = array("jpg","jpeg","png");

        if( in_array($imageFileType,$extensions_arr)){	

            move_uploaded_file($_FILES['foto']['tmp_name'], $temporario.$novo_nome);

            $image = new ImageResize($temporario.$novo_nome);
            $image->resize(770, 440);
            $image->save($diretorio.$novo_nome);
            
            $foto=$novo_nome;

            $veri=$conn->prepare("select foto from page_reservas") or die ("erro");

            $veri->execute();

            $veri->store_result();

            $veri->bind_result($foto2);

            $veri->fetch();

            unlink("../img/room/$foto2");

            $sql_insereregisto=$conn->prepare("update page_reservas set precoep_alta=?, precoep_baixa=?, adultos=?, kids=?, foto=?, compart_pt=?, serv_pt=?, regras_pt=?, compart_en=?, serv_en=?, regras_en=?, compart_es=?, serv_es=?, regras_es=?") or die("Erro ao inserir o registo");
    
            $sql_insereregisto->bind_param("iiiissssssssss", $precoep_alta, $preco, $maxp, $kids, $foto, $compart_pt, $serv_pt, $regras_pt, $compart_en, $serv_en, $regras_en, $compart_es, $serv_es, $regras_es);
        
            $sql_insereregisto->execute();
        
            if($sql_insereregisto->error){
                $sql_insereregisto->close();
                $veri->close();
                echo "<meta http-equiv='refresh' content='0; url=?pg=14&erro=1'>";exit;
            }
            else{
                move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$novo_nome);
                unlink($temporario.$novo_nome);
                echo "<meta http-equiv='refresh' content='0; url=?pg=14&m=777'>";exit;
            }

        } else {
            echo "<meta http-equiv='refresh' content='0; url=?pg=14&z=1'>";exit;
        }

    } else{

        $sql_insereregisto=$conn->prepare("update page_reservas set precoep_alta=?, precoep_baixa=?, adultos=?, kids=?, compart_pt=?, serv_pt=?, regras_pt=?, compart_en=?, serv_en=?, regras_en=?, compart_es=?, serv_es=?, regras_es=?") or die("Erro ao inserir o registo");
    
        $sql_insereregisto->bind_param("iiiisssssssss", $precoep_alta, $precoep_baixa, $maxp, $kids, $compart_pt, $serv_pt, $regras_pt, $compart_en, $serv_en, $regras_en, $compart_es, $serv_es, $regras_es);
    
        $sql_insereregisto->execute();
    
        if($sql_insereregisto->error){
            $sql_insereregisto->close();
            echo "<meta http-equiv='refresh' content='0; url=?pg=14&erro=1'>";exit;
        }
        else{
            $sql_insereregisto->close();
            echo "<meta http-equiv='refresh' content='0; URL=?pg=14&m=777'>";exit;
            
        }

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
            <h1>Editar Informação da Página Reservas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Editar Informação da Página Reservas</li>
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
            <?php $sql_casa2=$conn->query("select * from page_reservas")or die("Erro ao selecionar o nome."); 
                $row2=$sql_casa2->fetch_assoc();?>
            <form action="?pg=14" method="post" enctype="multipart/form-data">
                <div class="card-header p-2" style="border: 0px;">
                    <div class="form-group row" style="padding: 10px;">
                        <label for="inputName" class="col-sm-2 col-form-label">Preço por Noite Época Alta | Preço por Noite Época Baixa</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" value="<?php echo $row2['precoep_alta'];?>" name="precoep_alta" required>
                        </div>
                        <div class="col-sm-5" styel="">
                        <input type="number" class="form-control" value="<?php echo $row2['precoep_baixa'];?>" name="precoep_baixa" required>
                        </div>
                    </div>
                    <div class="form-group row" style="padding: 10px;";>
                        <label for="inputName" class="col-sm-1 col-form-label">Meses época alta</label>
                        <div class="col-sm-3" >
                        <?php $meses=['Sem mês', 'Janeiro', 'Fvereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']; 
                        $mes=1;
                        while($mes<=3){ ?>
                        
                        <input type="checkbox"  style="" name="<?php echo "mes".$mes;?>" value="1">
                        <label style="padding-left: 10px; padding-right: 10px;"><?php echo $meses[$mes];?></label>
                        
                        <?php  $mes+=1; }   ?>
                        </div>
                        <div class="col-sm-2" >
                        <?php while($mes<=6 && $mes>3){ ?>
                        
                            <input type="checkbox"  style="" name="<?php echo "mes".$mes;?>" value="1">
                            <label style="padding-left: 10px; padding-right: 10px;"><?php echo $meses[$mes];?></label>
                    
                        <?php  $mes+=1; }   ?>
                        </div>
                        <div class="col-sm-3" >
                        <?php while($mes<=9 && $mes>6){ ?>
                        
                            <input type="checkbox"  style="" name="<?php echo "mes".$mes;?>" value="1">
                        <label style="padding-left: 10px; padding-right: 10px;"><?php echo $meses[$mes];?></label>
                    
                        <?php  $mes+=1; }   ?>
                        </div>
                        <div class="col-sm-3">
                        <?php while($mes<=12 && $mes>9){ ?>
                        
                        <input type="checkbox"  style="" name="<?php echo "mes".$mes;?>" value="1">
                        <label style="padding-left: 10px; padding-right: 10px;"><?php echo $meses[$mes];?></label>
                    
                        <?php  $mes+=1; }   ?>
                        </div>
                    </div>´
                    <!-- Default unchecked -->
                    <div class="form-group row" style="padding: 10px;">
                        <label for="inputName" class="col-sm-2 col-form-label">Foto da página</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" name="foto" accept="images/*">
                        </div>
                    </div>
                    <div class="form-group row" style="padding: 10px;">
                        <label for="inputName" class="col-sm-2 col-form-label">Máximo de Adultos / Crianças</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="adultos" value="<?php echo $row2['adultos'];?>" required>
                        </div>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="kids" value="<?php echo $row2['kids'];?>" required>
                        </div>
                    </div>
                    <ul class="nav nav-pills" style="padding-left: 10px;">
                    <li class="nav-item"><a class="nav-link active" href="#pt" data-toggle="tab">Português</a></li>
                    <li class="nav-item"><a class="nav-link" href="#en" data-toggle="tab">Inglês</a></li>
                    <li class="nav-item"><a class="nav-link" href="#es" data-toggle="tab">Espanhol</a></li>
                    </ul>
                </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">

                    <div class="active tab-pane" id="pt">
                        <div class="form-horizontal">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Compartimentos</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $row2['compart_pt'];?>" name="compart_pt" required>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Serviços</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $row2['serv_pt'];?>" name="serv_pt" required>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Regras de Alojamento</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="regras_pt" required><?php echo $row2['regras_pt'];?></textarea>
                                </div>
                            </div>             
                        </div>
                    </div>
                    
                  <!-- /.tab-pane -->
                  

                    <div class="tab-pane" id="en">
                        <div class="form-horizontal">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Compartimentos</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $row2['compart_en'];?>" name="compart_en" required>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Serviços</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $row2['serv_en'];?>" name="serv_en" required>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Regras de Alojamento</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="regras_en" required><?php echo $row2['regras_en'];?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="es">
                        <div class="form-horizontal">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Compartimentos</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $row2['compart_es'];?>" name="compart_es" required>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Serviços</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="<?php echo $row2['serv_es'];?>" name="serv_es" required>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Regras de Alojamento</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="regras_es" required><?php echo $row2['regras_es'];?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div> <!-- /.card-body -->
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10" style="padding-right: 23px; padding-left: 20px;">
                        <button type="submit" style="width: 100%;" name="enviar" value="Editar" class="btn btn-primary">Editar</button>
                    </div>
                </div>
            </form>
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

<script>

    CKEDITOR.replace( 'regras_pt',
    {
    toolbar : 'basic',
    uiColor : '#007bff',
    enterMode : CKEDITOR.ENTER_BR
    });
    CKEDITOR.replace( 'regras_en',
    {
    toolbar : 'basic',
    uiColor : '#007bff',
    enterMode : CKEDITOR.ENTER_BR
    });
    CKEDITOR.replace( 'regras_es',
    {
    toolbar : 'basic',
    uiColor : '#007bff',
    enterMode : CKEDITOR.ENTER_BR
    });

</script>
