<?php 

use PayPal\Api\Amount;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;

if(isset($_POST['cancel']) && $_POST['cancel']=="Cancel"){

    $id = $_POST['cancel_res'];

    $estadia = 0;

	$reserva=$conn->prepare("Select paypal_trans, preco_total, paypal_fee from reservas where idreserva=? and estadia_conc=?") or die("Erro ao inserir o registo");

    $reserva->bind_param("ii", $id, $estadia);

	$reserva->execute();
	
    $reserva->store_result();
    
    if($reserva->num_rows>=1){

        $reserva->bind_result($trans, $total, $fee);

        $reserva->fetch();
        
        $preco = number_format($total - $fee, 2);

        $amt = new Amount();
        $amt->setTotal($preco)->setCurrency('EUR');

        $refundRequest = new RefundRequest();
        $refundRequest->setAmount($amt);

        $sale = new Sale();
        $sale->setId($trans);

        
        $refundedSale = $sale->refundSale($refundRequest, $apiContext);

        if($refundedSale){

            $delete1=$conn->prepare("Delete from reserva_cancelar where idreserva=?") or die("Erro ao inserir o registo");

            $delete1->bind_param("i", $id);

            $delete1->execute();

            $delete2=$conn->prepare("Delete from reserva_datas where idreserva=?") or die("Erro ao inserir o registo");

            $delete2->bind_param("i", $id);

            $delete2->execute();

            $updateres=$conn->prepare("update reservas set estadia_conc=2 where idreserva=?") or die("Erro ao inserir o registo");

            $updateres->bind_param("i", $id);

            $updateres->execute();

        echo "<meta http-equiv=refresh content='0; url=?pg=18&m=27'>";exit;

        } else {
            
            echo "<meta http-equiv=refresh content='0; url=?pg=18&erro=1'>";exit;
        }
        $reserva->close();

    } else {
        echo "<meta http-equiv=refresh content='0; url=?pg=18&erro=1'>";exit;
    }

	

}

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Reservas a Decorrer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Lista de Reservas a decorrer</li>
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
                <?php 
                $sql_perfil3=$conn->query("select * from reservas where estadia_conc=0")or die("Erro ao selecionar o nome.");
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
                    <th>Preço Total + taxa</th>
                    <th>Data de Pagamento</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                <?php while($row2=$sql_perfil3->fetch_assoc()){ ?>
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
                    <button type="button" class="view_data"  data-toggle="modal" data-target="#modalConfirmDelete" id="<?php echo $row2['idreserva'];?>" style="border: 0px; background: transparent; color:#007bff ; margin-left: auto; margin-right: auto; display: block; font-size: 22px;"><i class="fas fa-trash"></i></button> 
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
                    <th>Preço Total + taxa</th>
                    <th>Data de Pagamento</th>
                    <th>Ações</th>
                  </tr>
                </tfoot>
              </table>
              <?php } else { echo "<h5>Sem reservas efetuadas neste momento</h5>"; } ?>
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
        <p class="heading">Cancelar Reserva</p>
      </div>

      <!--Body-->
      <div class="modal-body" >

        <i class="fas fa-times fa-4x animated rotateIn" style="color: #ff3547;"></i>
				<div>
          Tem acertezea que quer cancelar este reserva?
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
           var idreserva = $(this).attr("id");  
           $.ajax({  
                url:"acoes/cancel_reserva.php",  
                method:"post",  
                data:{idreserva:idreserva},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#modalConfirmDelete').modal("show");  
                }  
           });  
      });  
 });
 </script>