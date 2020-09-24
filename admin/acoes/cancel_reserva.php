<?php
	
    
  if(!isset($_SESSION)){ //Se ainda n?o existir a sess?o
	
	session_start(); //criar a sess?o
  }

  if(!isset($_SESSION) || $_SESSION['nome']=="" || $_SESSION['tipo']!=1){
    session_destroy();
     echo "<meta http-equiv=refresh content='0; url=../index.php?z=3'>"; exit;
  }

    require "../../bd.php"; 
?>
<?php  
 if(isset($_POST["idreserva"]))  
 {  
      $output = '';   
      $connect = mysqli_connect("localhost", "root", "", "casa");  
      $query = "SELECT * FROM reservas WHERE idreserva = '".$_POST["idreserva"]."' and estadia_conc=0";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
      '; 
      if($result->num_rows>=1){ 
      $row = mysqli_fetch_array($result);  
  		 
       $output .= '  
       <form action="?pg=18" method="post">
       <button type="submit" name="cancel" value="Cancel" class="btn  btn-outline-danger" style="margin-left: -10px;" >Cancelar Reserva</button>
       <a type="button" style="color: white;" class="btn  btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
       <input type="hidden" name="cancel_res" value="'.$row['idreserva'].'">
       </form> ';  
        
      }
     $output .= "";  
     echo $output;  
  }  
?>