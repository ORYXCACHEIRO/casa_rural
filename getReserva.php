<?php
	
    
  if(!isset($_SESSION)){ //Se ainda n?o existir a sess?o
	
  session_start(); //criar a sess?o
  
  }

    require "bd.php"; 
?>
<?php  

 if(isset($_POST["adult"]) && isset($_POST["child"]) && isset($_POST["datai"]) && isset($_POST["dataf"]))  
 { 
      if(isset($_SESSION) && !isset($_SESSION['idutilizador'])){

        $output = '';
          $output .= '  
          <div style="">
              <div style="width: 80%; margin-left: auto; margin-right: auto;">
                <h2 style="border-bottom: 1.5px solid #6f7d5d; text-align: center; padding-bottom: 10px;">Erro...</h2>
                <p style="font-size: 17px; text-align: center; padding-top: 10px; letter-spacing: 1px;">Para puder efetuar uma reserva precisa de ter uma conta criada.</p>
                <p style="font-size: 17px; text-align: center; padding-top: 5px; letter-spacing: 1px;">Ainda não tem conta?</p>
                <p style="font-size: 17px; text-align: center; letter-spacing: 1px;">Clique <a href="?pg=6" style="color: #262626;">aqui</a> e crie já uma!</p>
                </div>      
          </div> 
          <div style="padding-bottom: 30px;">
                <div style="width: 80%; margin-left: auto; margin-right: auto;">
                    <button type="button" data-dismiss="modal" style="border: 0px; background: #6f7d5d; color: white;  width: 100%; height: 40px; margin-top: 30px;">Voltar Atrás</button>
                </div>
            </div>';  
          
        echo $output; 

      } else {

      $sql_perfil3=$conn->prepare("select verificado, password, tipo from utilizadores where idutilizador=?")or die("Erro ao selecionar o perfil.");

      $sql_perfil3->bind_param("i", $_SESSION['idutilizador']);

      $sql_perfil3->execute();

      $result2 = $sql_perfil3->get_result();

      $row2=$result2->fetch_assoc(); 

      $sql_perfil3->close();

      if($row2['verificado']==0 || $row2['password']=="" || $row2['tipo']==1){

        $output = '';
          $output .= '  
          <div style="">
              <div style="width: 80%; margin-left: auto; margin-right: auto;">
                <h2 style="border-bottom: 1.5px solid #6f7d5d; text-align: center; padding-bottom: 10px;">Erro...</h2>
                <p style="font-size: 17px; text-align: center; padding-top: 10px; letter-spacing: 1px;">Não pode efetuar uma reserva se ainda não tiver o seu email verificado ou se não ainda não cumpriu os procedimentos da criação da conta todos. Verifique se recebeu um email para verificar a sua conta. Caso o link tenha expirado ou não tenha recebido o mesmo visite o seu perfil e clique para reenviar um novo email de verificação.</p>
                </div>      
          </div> 
          <div style="padding-bottom: 30px;">
                <div style="width: 80%; margin-left: auto; margin-right: auto;">
                    <button type="button" data-dismiss="modal" style="border: 0px; background: #6f7d5d; color: white;  width: 100%; height: 40px; margin-top: 30px;">Voltar Atrás</button>
                </div>
            </div>';  
          
        echo $output; 

      } else {

      $pessoas=$conn->query("SELECT adultos, kids, precoep_baixa from page_reservas") or die("Erro selecionar o nome."); 
      $p = $pessoas->fetch_assoc();

      if(isset($_POST["datai"]) && $_POST["datai"]=="" || isset($_POST["dataf"]) && $_POST["dataf"]=="" || !is_numeric($_POST['adult']) || !is_numeric($_POST['child']) || is_numeric($_POST['adult']) && $_POST['adult']<=0 || is_numeric($_POST['adult']) && $_POST['adult']>$p['adultos'] || is_numeric($_POST['child']) && $_POST['child']<0 || is_numeric($_POST['child']) && $_POST['child']>$p['kids']){

        $output = '';
          $output .= '  
          <div style="">
              <div style="width: 80%; margin-left: auto; margin-right: auto;">
                <h2 style="border-bottom: 1.5px solid #6f7d5d; text-align: center; padding-bottom: 10px;">Erro...</h2>
                <p style="font-size: 17px; text-align: center; padding-top: 10px; letter-spacing: 1px;">Na escolha da sua reserva inseriu um período de datas errado ou um número de pessoas incorreto. Por favor verifique que a informação que escolheu é válida.</p>
              </div>      
          </div> 
          <div style="padding-bottom: 30px;">
                <div style="width: 80%; margin-left: auto; margin-right: auto;">
                    <button type="button" data-dismiss="modal" style="border: 0px; background: #6f7d5d; color: white;  width: 100%; height: 40px; margin-top: 30px;">Voltar Atrás</button>
                </div>
            </div>';  
          
        echo $output; 
  
      } else {

      $sql_perfil4=$conn->prepare("select count(*) as conta from reservas where ? between datai and dataf and estadia_conc=0")or die("Erro ao selecionar o perfil.llll");

      $sql_perfil4->bind_param("s", $_POST["datai"]);

      $sql_perfil4->execute();

      $result3 = $sql_perfil4->get_result();

      $row3=$result3->fetch_assoc();

      $sql_perfil4->close();

      $veri=$conn->prepare("select count(*) as conta from reservas where ? between datai and dataf and estadia_conc=0") or die ("erro");

      $veri->bind_param("s", $_POST["dataf"]);

      $veri->execute();

      $veri->store_result();

      $veri->bind_result($conta);

      $veri->fetch();

      $veri->close();

      $existe = false;
      
      $dataii = $_POST['datai'];
      $dataff = $_POST['dataf'];
      
      $sql_perfil5=$conn->prepare("select count(*) as conta, data from reserva_datas")or die("Erro ao selecionar o perfil.llll");

      $sql_perfil5->execute();

      $result4 = $sql_perfil5->get_result();

      $sql_perfil5->close();

      while($dataii!=$dataff){

        $atual=$conn->query("SELECT ADDDATE('".$dataii."', INTERVAL 1 DAY) as intervalo") or die ("Erro ao selecionar o utilizador.");
        $ln3=$atual->fetch_assoc();
        $dataii = $ln3['intervalo'];
        if($result4->num_rows>=1){
          while($row4=$result4->fetch_assoc()){
            if($dataii==$row4['data']){
              $existe=true;
            }
          }
        }
      }

      if($row3['conta']!=0 || $conta!=0 || $existe==true){
        $output = '';
          $output .= '  
          <div style="">
              <div style="width: 80%; margin-left: auto; margin-right: auto;">
                <h2 style="border-bottom: 1.5px solid #6f7d5d; text-align: center; padding-bottom: 10px;">Erro...</h2>
                <p style="font-size: 17px; text-align: center; padding-top: 10px; letter-spacing: 1px;">Na escolha da sua reserva inseriu um período de datas errado ou um número de pessoas incorreto. Por favor verifique que a informação que escolheu é válida.</p>
              </div>      
          </div> 
          <div style="padding-bottom: 30px;">
                <div style="width: 80%; margin-left: auto; margin-right: auto;">
                    <button type="button" data-dismiss="modal" style="border: 0px; background: #6f7d5d; color: white;  width: 100%; height: 40px; margin-top: 30px;">Voltar Atrás</button>
                </div>
            </div>';  
          
        echo $output; 

      } else {

      $tempo=$conn->query("SELECT CURDATE() as atual") or die("Erro selecionar o nome."); 
      $time = $tempo->fetch_assoc();

      $atual=$conn->query("SELECT ADDDATE('".$time['atual']."', INTERVAL 1 DAY) as intervalo") or die ("Erro ao selecionar o utilizador.");
			
      $ln3=$atual->fetch_assoc();
      
      $date_diff=$conn->query("SELECT DATEDIFF('".$_POST['dataf']."','".$_POST['datai']."') as diff") or die("Erro selecionar o nomeeee."); 
      $diff = $date_diff->fetch_assoc();

      if($_POST['datai']<$ln3['intervalo'] || $time['atual']>$_POST['datai'] || $_POST['datai']>$_POST['dataf'] || $_POST['datai']==$_POST['dataf'] || $diff['diff']>180){

        $output = '';
          $output .= '  
          <div style="">
                  <div style="width: 80%; margin-left: auto; margin-right: auto;">
                      <h2 style="border-bottom: 1.5px solid #6f7d5d; text-align: center; padding-bottom: 10px;">Erro...</h2>
                      <p style="font-size: 17px; text-align: center; padding-top: 10px; letter-spacing: 1px;">Na escolha da sua reserva inseriu um período de datas errado. Por favor verifique que a data que escolheu é válida.</p>
                  </div>      
              </div>
              <div style="padding-bottom: 30px;">
                <div style="width: 80%; margin-left: auto; margin-right: auto;">
                    <button type="button" data-dismiss="modal" style="border: 0px; background: #6f7d5d; color: white;  width: 100%; height: 40px; margin-top: 30px;">Voltar Atrás</button>
                </div>
            </div>';  
          
        echo $output; 

      } else {

        $preco = $p['precoep_baixa']*$diff['diff'];
        $total = number_format($preco * 3.4 / 100 + 0.47, 2);
        $total2 = number_format($total + $preco, 2);

      $output = '';
       $output .= '  
       <form action="?pg=8" method="post">
          <div style="">
            <div style="width: 80%; margin-left: auto; margin-right: auto;">
              <h2 style="border-bottom: 1.5px solid #6f7d5d; text-align: left;">Checkout</h2>
              <div>
                <div style="padding-top: 20px; width: 50%; float: left;">
                  <h4 style="text-align: center;">Check-In</h4>
                  <p style="text-align: center; padding-top: 10px;">'.$_POST["datai"].'</p>
                </div>
                <div style=" padding-top: 20px; width: 50%; float: right;">
                  <h4 style="text-align: center;">Check-Out</h4>
                  <p style="text-align: center; padding-top: 10px;">'.$_POST['dataf'].'</p>
                </div>
              </div>
              <div>
                <div style="padding-top: 20px; width: 50%; float: left;">
                  <h4 style="text-align: center;">Adultos</h4>
                  <p style="color: #6f7d5d; text-align: center; padding-top: 10px; font-size: 37px; font-weight: 700;">'.$_POST["adult"].'</p>
                </div>
                <div style="padding-top: 20px; width: 50%; float: right;">
                  <h4 style="text-align: center;">Crianças</h4>
                  <p style="color: #6f7d5d; text-align: center; padding-top: 10px; font-size: 37px; font-weight: 700;">'.$_POST["child"].'</p>
                </div>
              </div>
            </div>      
          </div>
          <div>
            <div style="width: 80%; margin-left: auto; margin-right: auto;">
              <div style="background: #6f7d5d; height: 2px; width: 74.5%; margin-top: 200px; margin-left: -0px; position: absolute; z-index: 1051;"></div>
              <div style="float: left; width: 50%;">
                <h5 style="padding-top: 20px; text-align: left;">Taxa Paypal:</h5>
              </div>    
              <div style="float: right; width: 50%;">
                <h5 style="padding-top: 20px; text-align: right;">'.$total.'€</h5>
              </div>           
            </div>
            <div style="width: 80%; margin-left: auto; margin-right: auto;">
              <div style="background: #6f7d5d; height: 2px; width: 74.5%; margin-top: 200px; margin-left: -0px; position: absolute; z-index: 1051;"></div>
              <div style="float: left; width: 50%;">
                <h5 style="padding-top: 20px; text-align: left;">Valor Total a Pagar:</h5>
              </div>    
              <div style="float: right; width: 50%;">
                <h5 style="padding-top: 20px; text-align: right;">'.$total2.'€</h5>
              </div>
              <div style="padding-top: 5px; float: left;">
                <p style="padding-top: 20px; text-align: left;"><b>Nota importante:</b> Tem até às 21:00 do dia anterior do Check-In para puder cancelar a sua reserva sem custos adicionais.É possivel fazê-lo até às 23:59, mas será cobrado 20% do valor total </p>
              </div>            
            </div>
          </div>
          <div style="padding-bottom: 30px;">
            <div style="width: 80%; margin-left: auto; margin-right: auto;">
              <div id="paypal-button-container"></div> 
            </div>
          </div>
       </form> ';  
        
      echo $output;  ?>

    <script>
      paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '<?php echo $total2;?>'
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          //This function shows a transaction success message to your buyer.
          $.ajax({
          method: "POST",
          url: 'save_payment.php',
          data: { 
            "user": <?php echo $_SESSION['idutilizador']; ?>,
            "datain":  $('#datai').val(),
            "datafi":  $('#dataf').val(),
            "adults": <?php echo $_POST['adult'];?>,
            "children": <?php echo $_POST['child'];?>,
            "fee": '<?php echo $total;?>',
            "total": '<?php echo $total2;?>',
            "transaction_id": details.purchase_units[0].payments.captures[0].id
            },
            success:function(data){ 

              window.location = "index.php?pg=9&m=13";	
              
            }       
          });
        });
      }
    }).render('#paypal-button-container');
  </script>

       <?php }
      }
     }
    }
 }
} 
?>












            