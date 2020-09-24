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
 if(isset($_POST["idfoto2"]))  
 {  
      $output = '';   
      $sql_casa2=$conn->query("Select * FROM galeria WHERE not idfoto = '".$_POST["idfoto2"]."' and banner=1") or die("Erro ao selecionar o nome.");
      $output .= '
      <input type="hidden" value="'.$_POST["idfoto2"].'" name="foto_atual">
      <select style="width: 50%; margin-left: 120px;" name="foto_muda">
      ';  
      while($row2=$sql_casa2->fetch_assoc())  
      {  
  		 
       $output .= '  
       
          <option value='.$row2['idfoto'].'>Foto com ID '.$row2['idfoto'].'</option>
        
       
         ';  
        
      
     }
     $output .= " </select>";  
      echo $output;  
  }  
?>