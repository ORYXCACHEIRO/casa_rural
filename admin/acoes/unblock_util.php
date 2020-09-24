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
 if(isset($_POST["iduser_block"]))  
 {  
      $output = '';   
      $connect = mysqli_connect("localhost", "root", "", "casa");  
      $query = "SELECT * FROM utilizadores_block WHERE iduser_block = '".$_POST["iduser_block"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
      ';  
      while($row = mysqli_fetch_array($result))  
      {  
  		 
       $output .= '  
       <form action="?pg=1" method="post">
       <button type="submit" name="unblock" value="Unblock" class="btn  btn-outline-success" style="margin-left: -10px;" >Desbloquear</button>
       <a type="button" style="color: white;" class="btn  btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
       <input type="hidden" name="unblock_util" value="'.$row['iduser_block'].'">
       </form> ';  
        
      
     }
     $output .= "";  
     echo $output;  
  }  
?>