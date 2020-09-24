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
 if(isset($_POST["idevento"]))  
 {  
      $output = '';   
      $connect = mysqli_connect("localhost", "root", "", "casa");  
      $query = "SELECT * FROM eventos WHERE idevento = '".$_POST["idevento"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
      ';  
      while($row = mysqli_fetch_array($result))  
      {  
  		 
       $output .= '  
       <form action="?pg=6" method="post">
       <button type="submit" name="delete" value="Delete" class="btn  btn-outline-danger" style="margin-left: -10px;" >Eliminar</button>
       <a type="button" style="color: white;" class="btn  btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
       <input type="hidden" name="delete_evento" value="'.$row['idevento'].'">
       </form> ';  
        
      $output .= "";  
      echo $output;  
     }
  }  
?>