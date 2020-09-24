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
      $query = "SELECT idfoto_visita  FROM galeria_visita WHERE not idfoto_visita = '".$_POST["idfoto_visita"]."' and idvisita='".$_POST["idvisita"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= ' <div style=" width: 100%; margin-left: auto; margin-right: auto;  display: flex; "> 
      <div style=" width: 92%; display: flex; margin-left: auto; margin-right: auto;">';  
      while($row = mysqli_fetch_array($result))  
      {  
  		 
       $output .= ' 
          <form action="?pg=8" method="post" style="padding-left: 10px;" enctype="multipart/form-data">
            <input type="hidden" value="'.$_POST["idfoto_visita"].'" name="foto_atual" >
            <input type="hidden" value="'.$row['idfoto_visita'].'" name="foto_muda" >
            <button type="submit" name="troca" value="Troca" class="btn btn-primary">Trocar com a foto de ID '.$row['idfoto_visita'].'</button>
          </form>
        ';  
           
     }
     $output .= "</div></div>";  
     echo $output;  
  }  
?>
