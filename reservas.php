
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Reservar</h2>
                        <div class="bt-option">
                            <a href="index.php">Home</a>
                            <span>Reservar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Room Details Section Begin -->
    <section class="room-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                <?php $sql_perfil2=$conn->prepare("select * from page_reservas ")or die("Erro ao selecionar o perfil.");

                 $sql_perfil2->execute();

                $result = $sql_perfil2->get_result();

                while($row=$result->fetch_assoc()){ 
                    

                    ?>
                    <div class="room-details-item" style="">
                        <img src="img/room/<?php echo $row['foto'];?>" alt="">
                        <div class="rd-text">
                            <div class="rd-title">
                                <h3>Casa São Gregório Alojamento Local</h3>
                            </div>
                            <table style="margin-left: auto; margin-right: auto; ">
                                <tbody>
                                    <tr>
                                        <td  style="margin-left: auto; margin-right: auto;  display: block; text-align: center;" class="r-o">Capacidade:</td>
                                        <td style=" display: block; text-align: center;">Máximo de <?php echo $row['adultos'];?> pessoas mais <?php echo $row['kids'];?> crianças</td>
                                    </tr>
                                    <tr >
                                        <td style="margin-left: auto; margin-right: auto;  display: block; text-align: center;" class="r-o"> Compartimentos: </td>
                                        <td style=" display: block; text-align: center;">  <?php echo $row['compart_pt'];?>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td style="margin-left: auto; margin-right: auto;  display: block; text-align: center;" class="r-o">Serviços:</td>
                                        <td style=" display: block; text-align: center;"><?php echo $row['serv_pt'];?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="rd-reviews" style="">
                        <div class="rd-title">
                            <h3 style="text-align: center; padding-bottom: 25px;">Preçário</h3>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="background: #6f7d5d; color: white;" scope="col">Data</th>
                                <th style="background: #6f7d5d; color: white;" scope="col">Casa para 6 pessoas ou 4 adultos e 2 crianças a partir de 4 anos (+1 pessoa)</th>
                                <th style="background: #6f7d5d; color: white;" scope="col">Menos pessoas </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">Época baixa: 05.01 a 14.04 / 19.10 a 22.12</th>
                                <td>210 euros (no mínimo 2 noites)</td>
                                <td>A definir através de contacto</td>
                                </tr>
                                <tr>
                                <th scope="row">Época alta: 15.04 a 18.10 /23.12 a 04.01</th>
                                <td>270 euros (no mínimo 2 noites)</td>
                                <td>A definir através de contacto</td>
                                </tr>
                                <tr>
                                <th scope="row">Época alta especial: Páscoa</th>
                                <td>270 euros (no mínimo 2 noites)</td>
                                <td>A definir através de contacto</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rd-reviews" style="">
                        <h4 style=" text-align: center;">Regras do alojamento <img src="img/alerta2.png"></h4>
                        <div style="" class="review-item">
                            <div style="text-align: center; " class="ri-text">
                                <?php echo $row['regras_pt'];?>
                            </div>
                        </div>
                        <b style=" text-align: center; display: block;">Ao reservar estará a concordar com estas regras do alojamento.</b>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Room Details Section End -->

<div class="modal fade" tabindex="-1" id="exampleModal" role="dialog" style="padding-left: 24px;" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" >
    <div style="background: #6f7d5d; height: 8px; width: 100%; margin-top: 0px; margin-left: 0.1px; position: absolute; z-index: 1051;"></div>  
      <div class="modal-header" style=" border-bottom: 0px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
        <div class="modal-body" id="employee_detail">
            
        </div>
    </div>
  </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=AaitJOdHylLDUChzMBwuzUcgoNz00Kdp6JWFirD5zwP3sZcpAJ-XXoNyFFdAyvlrWhErpOBEktWQWY4l&currency=EUR"></script>

<script>
// id live: AUYV5gAOAsKo031av1y7X9BVESD9RVtca3MAxH0etulpzDMZVN6dkDSqpOEIFOD8t_F5WIki44EN-cxF
$(document).ready(function(){  
      $('.view_data').click(function(){  
           var adult = $('#adult').val();
           var child = $('#child').val();  
           var data_i_temp = $('#datai').val();
           var data_f_temp = $('#dataf').val();  
           $.ajax({  
                url:"getReserva.php",  
                method:"post",  
                data:{"adult":adult, "child":child, "datai":data_i_temp, "dataf":data_f_temp},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#exampleModal').modal("show");  
                }  
           });  
      });  
 }); 



</script>


