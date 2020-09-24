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
       <form action="?pg=6" method="post" enctype="multipart/form-data">
       <input type="hidden" name="idevento" value="'.$row['idevento'].'">
      <div class="modal-body">
        <div>
            <div style="width: 50% ; float: left; padding-right: 5px;">
                <label>Nome do evento</label>
                <input  type="text" name="nome" value="'.$row['nome'].'" style="width: 100%;" required>
            </div>
            <div style="width: 50%; float: right; padding-left: 5px;">
                <label>Data do evento</label>
                <input type="date" name="data" style="width: 100%;" value="'.$row['data'].'" required>
            </div>
        </div>
        <div style=" width: 100%; margin-top: 70px;">
            <label>Link do evento</label>
            <input type="text" name="link" value="'.$row['link'].'" style="width: 100%;" required>
        </div>
        <div style=" width: 100%; margin-top: 10px;">
            <label>Foto do evento</label>
            <input type="file" name="imagem" style="width: 100%;">
        </div>
      </div>
      </form>';  
        
      $output .= "";  
      echo $output;  
     }
  }  
?>