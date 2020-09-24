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
 if(isset($_POST["idvisita"]))  
 {  
      $output = '';   
      $connect = mysqli_connect("localhost", "root", "", "casa");  
      $query = "SELECT idvisita  FROM visitas WHERE idvisita = '".$_POST["idvisita"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '';  
      $row = mysqli_fetch_array($result); 
  		 
       $output .= ' 
            <input type="hidden" name="idvisita" value="'.$row['idvisita'].'">
            <input type="file" name="fotoban" accept="image/*" required>
        ';  
           
     $output .= "";  
     echo $output;  
  }  
?>
