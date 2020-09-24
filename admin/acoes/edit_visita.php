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
      $query = "SELECT * FROM visitas WHERE idvisita = '".$_POST["idvisita"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
      ';  
      $row = mysqli_fetch_array($result);		 
       $output .= '  
       <input type="hidden" name="idvisita" value="'.$row['idvisita'].'">

        <div>
        <div style="width: 100% ; float: left; padding-right: 5px;">
            <label>Titulo da Descoberta</label>
            <input  type="text" name="nome" style="width: 100%;" value="'.$row['nome'].'" required>
        </div>
        </div>
        <div style=" width: 100%; margin-top: 70px;" >
        <label>Descrição</label>
        <ul class="nav nav-pills" style="padding-bottom: 10px;">
            <li class="nav-item" style="padding-right: 5px;"><button type="button" id="pt2" onclick="showDiv11()" style="border: 0px;" class="nav-link active">Português</button></li>
            <li class="nav-item" style="padding-right: 5px;"><button type="button" id="es2" onclick="showDiv22()" style="border: 0px;" class="nav-link">Espanhol</button></li>
            <li class="nav-item"><button type="button" onclick="showDiv33()" id="en2" style="border: 0px;" class="nav-link">Inglês</button></li>
        </ul>
        <div id="welcomeDiv11">
            <input type="hidden" onkeyup="count_down(this);" >
            <textarea class="ckeditor" name="editor4" required>
            '.$row['texto_pt'].'
            </textarea>
        </div>
        <div id="welcomeDiv22" style="display: none;">
            <textarea name="editor5" required>'.$row['texto_es'].'</textarea>
        </div>
        <div id="welcomeDiv33" style="display: none;">
            <textarea name="editor6" required>'.$row['texto_en'].'</textarea>
        </div>
        </div>
        <div>
        <div style="width: 100%; float: left; padding-right: 5px; padding-top: 5px; padding-bottom: 10px;">
            <label>Foto da Visita</label>
            <input type="file" name="fotop" style="width: 100%;">
        </div>
        </div>';  
        
      $output .= "";  
      echo $output;  
  }  
?>
<script>
    CKEDITOR.replace( 'editor4',
    {
    toolbar : 'standard',
    uiColor : '#007bff',
    enterMode : CKEDITOR.ENTER_BR
    });
    CKEDITOR.replace( 'editor5',
    {
    toolbar : 'standard',
    uiColor : '#007bff',
    enterMode : CKEDITOR.ENTER_BR
    });
    CKEDITOR.replace( 'editor6',
    {
    toolbar : 'standard',
    uiColor : '#007bff',
    enterMode : CKEDITOR.ENTER_BR
    });
</script>
