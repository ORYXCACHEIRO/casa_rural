<?php 	
	if(isset($_POST['delete']) && $_POST['delete']=="Delete"){

    $id = $_POST['delete_av'];

    $apaga_artigo=$conn->query("DELETE FROM avaliacoes where idavaliacao='".$id."'") or die("Falha ao eliminar o utilizador.");

    if(isset($apaga_artigo)){
			echo "<meta http-equiv=refresh content='0; url=?pg=15&m=2'>";exit;
		}		
		else{
			echo "<meta http-equiv=refresh content='0; url=?pg=15&erro=1'>";exit;
		}

  }

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Avaliações</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Lista de Avaliações</li>
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
            <?php $sql_perfil2=$conn->query("select * from avaliacoes")or die("Erro ao selecionar o nome.");
              if($sql_perfil2->num_rows>=1){ 
                ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Observação</th>
                    <th>Avaliação</th>
                    <th>Data</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                <?php while($row=$sql_perfil2->fetch_assoc()){ ?>
                <tr>
                  <td>
                  <?php if($row['idutilizador']==0){?>
                    <img src="../img/perfis/default.png" style="width: 40px; height: 40px; border-radius: 50px; margin-left: auto; margin-right: auto; display: block;">
                  <?php } else { 
                      $sql_perfil3=$conn->query("select foto from utilizadores where idutilizador = '".$row['idutilizador']."'")or die("Erro ao selecionar o nome.");
                      $row2=$sql_perfil3->fetch_assoc(); 
                      if($row2['foto']!="") { ?>
                    <img src="../img/perfis/<?php echo $row2['foto']; ?>" style="width: 40px; height: 40px; border-radius: 50px; margin-left: auto; margin-right: auto; display: block;">
                  <?php } else {  ?>  
                    <img src="../img/perfis/default.png" style="width: 40px; height: 40px; border-radius: 50px; margin-left: auto; margin-right: auto; display: block;">
                  <?php } } ?>
                  </td>
                  <td><?php echo $row['nome'];?></td>
                  <td><?php echo $row['email'];?></td>
                  <td><?php echo $row['comment'];?></td>
                  <td><?php 
                  
                  switch($row['avaliacao']){

                    case 0: echo "<img src='../img/star-unfill.png'><img src='../img/star-unfill.png'><img src='../img/star-unfill.png'><img src='../img/star-unfill.png'><img src='../img/star-unfill.png'>"; break; 
                    case 1: echo "<img src='../img/star-fill.png'><img src='../img/star-unfill.png'><img src='../img/star-unfill.png'><img src='../img/star-unfill.png'><img src='../img/star-unfill.png'>"; break; 
                    case 2: echo "<img src='../img/star-fill.png'><img src='../img/star-fill.png'><img src='../img/star-unfill.png'><img src='../img/star-unfill.png'><img src='../img/star-unfill.png'>"; break; 
                    case 3: echo "<img src='../img/star-fill.png'><img src='../img/star-fill.png'><img src='../img/star-fill.png'><img src='../img/star-unfill.png'><img src='../img/star-unfill.png'>"; break; 
                    case 4: echo "<img src='../img/star-fill.png'><img src='../img/star-fill.png'><img src='../img/star-fill.png'><img src='../img/star-fill.png'><img src='../img/star-unfill.png'>"; break; 
                    case 5: echo "<img src='../img/star-fill.png'><img src='../img/star-fill.png'><img src='../img/star-fill.png'><img src='../img/star-fill.png'><img src='../img/star-fill.png'>"; break; 
                    default: echo ""; break; //erro

                } ?></td>
                  <td><?php echo $row['data'];?></td>
                  <td> 
                    <button style="border: 0px; background: transparent; color: #007bff;" data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row['idavaliacao'];?>" class="view_data"><i class="far fa-trash-alt"></i></button>
                  </td>
                </tr>
                <?php } ?>
                </tbody>
				<tfoot>
                  <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Observação</th>
                    <th>Avaliação</th>
                    <th>Data</th>
                    <th>Ações</th>
                  </tr>
                </tfoot>
              </table>
              <?php } else { ?>
                <h2 class="card-title"><b>Sem avaliações</b></h2>
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

<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true" style="top: 160px; margin-left: auto; margin-right: auto;">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document" style="position: absolute; left: 50%; top: 27%;  transform: translate(-50%, -50%);">
    <!--Content-->
    <div class="modal-content text-center" >
      <!--Header-->
      <div class="modal-header d-flex justify-content-center" style="margin-left: 1px; background-color: #ff3547; color: white;">
        <p class="heading">Eliminar Avaliação</p>
      </div>

      <!--Body-->
      <div class="modal-body" >

        <i class="fas fa-times fa-4x animated rotateIn" style="color: #ff3547;"></i>
				<div>
          Tem acertezea que quere eliminar esta avaliação?
        </div>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center" id="employee_detail">
        
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->
<script>

$(document).ready(function(){  
      $('.view_data').click(function(){  
           var idav = $(this).attr("id");  
           $.ajax({  
                url:"acoes/delete_av.php",  
                method:"post",  
                data:{idav:idav},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#modalConfirmDelete').modal("show");  
                }  
           });  
      });  
 }); 

</script>
