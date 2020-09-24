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
 if(isset($_POST["idmail"]))  
 {  
      $output = '';   
      $connect = mysqli_connect("localhost", "root", "", "casa");  
      $query = "SELECT * FROM mensagens WHERE idmensagem = '".$_POST["idmail"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
      ';  
      $row = mysqli_fetch_array($result);

      if($_POST["pg"]==9){
       $output .= '  
       <form action="?pg=9" method="post">
       <button type="submit" name="delete" value="Delete" class="btn  btn-outline-danger" style="margin-left: -10px;" >Eliminar</button>
       <a type="button" style="color: white;" class="btn  btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
       <input type="hidden" name="delete_mail" value="'.$_POST["idmail"].'">
       </form> ';  
      } else {
        $output .= '  
        <form action="?pg=11&men='.$_POST["idmail"].'" method="post">
        <button type="submit" name="delete" value="Delete" class="btn  btn-outline-danger" style="margin-left: -10px;" >Eliminar</button>
        <a type="button" style="color: white;" class="btn  btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
        <input type="hidden" name="delete_mail" value="'.$_POST["idmail"].'">
        </form> ';  
      }

     $output .= "";  
     echo $output;  
  }  
?>