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
 if(isset($_POST["idfoto_visita"]))  
 {  
      $output = '';   
      $connect = mysqli_connect("localhost", "root", "", "casa");  
      $query = "SELECT idfoto_visita  FROM galeria_visita WHERE idfoto_visita = '".$_POST["idfoto_visita"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '';  
      $row = mysqli_fetch_array($result); 
  		 
       $output .= ' 
            <input type="hidden" name="idfoto_visita" value="'.$row['idfoto_visita'].'">
            <input type="file" name="foto" required>
        ';  
           
     $output .= "";  
     echo $output;  
  }  
?>
