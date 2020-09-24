
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
                <div class="col-lg-8">
                <div class="room-booking" style="padding-top: 55px;" >
                        <h3 style="">Reserve aqui</h3>
                        <form action="#">
                            <div>
                                <div class="check-date" style="width: 47%; float: left;">
                                    <label for="date-in">Check In: <div style="position: absolute; left: 60px; top: -2px;" data-toggle="tooltip" data-placement="top" title="Check-in apenas valido um dia após o atual"><img style="width: 18px;" src="img/informacao.png"></div></label>
                                    <input type="date" id="datai" required>
                                    
                                </div>
                                <div class="check-date" style="width: 47%; float: right;">
                                    <label for="date-out">Check Out:</label>
                                    <input type="date" id="dataf" required>
                                    
                                </div>
                            </div>
                            <div>
                                <div class="check-date" style="width: 47%; float: left;">
                                    <label for="date-in">Nome: </label>
                                    <input type="text" name="nome" placeholder="exemplo" required>
                                    
                                </div>
                                <div class="check-date" style="width: 47%; float: right;">
                                    <label for="date-out">Email:</label>
                                    <input type="text" name="email" placeholder="exemplo@email.com" required>
                                    
                                </div>
                            </div>
                            <div>
                                <div class="select-option" style="width: 47%; float: left;">
                                    <label for="guest">Adultos:</label>
                                    <select class="select" id="adult" required>
                                        <?php 
                                        
                                        $sql_perfil2=$conn->prepare("select adultos, kids from page_reservas ")or die("Erro ao selecionar o perfil.");

                                        $sql_perfil2->execute();

                                        $result = $sql_perfil2->get_result();

                                        $row=$result->fetch_assoc(); 

                                        $adultos = $row['adultos'] - $row['adultos'] + 1;
                                        $max_ad = $row['adultos'];

                                        $kids = $row['kids'] - $row['kids'] + 1;
                                        $max_kids = $row['kids'];

                                        $sql_perfil2->close();

                                        while($adultos <= $max_ad){

                                            if($adultos==1){?>
                                            <option value="<?php echo $adultos;?>"><?php echo $adultos;?> Adulto</option>
                                            <?php } else { ?>
                                                <option value="<?php echo $adultos;?>"><?php echo $adultos;?> Adultos</option>
                                            <?php } ?>
                                        <?php
                                        $adultos +=1;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="select-option" style="width: 47%; float: right;">
                                <label for="room">Crianças:</label>
                                    <select class="select" id="child" required>
                                    <option value="0">Nenhuma criança</option>
                                    <?php 
                                        while($kids <= $max_kids){
                                            if($kids==1){?>
                                            <option value="<?php echo $kids; ?>"><?php echo $kids;?> Criança</option>
                                            <?php } else { ?>
                                                <option value="<?php echo $kids;?>"><?php echo $kids;?> Crianças</option>
                                            <?php } ?>
                                        <?php
                                        $kids +=1;
                                        }
                                        
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="date-out">Observações:</label>
                                <textarea class="select" name="obs" rows="5" style="height: 150px;" placeholder="exemplo" required></textarea>  
                            </div>
                            
                            <button type="button" data-toggle="modal" data-target="#exampleModal" class="view_data" >Reservar</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div style="padding: 10px 30px 0 40px;">
                        <h3 class="h3" style="padding-top: 55px;">Datas de reservas</h3>
                        <div style="padding-top: 40px;" class="calendario">
                            <div id="caleandar">
                            </div>
                        </div>

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


