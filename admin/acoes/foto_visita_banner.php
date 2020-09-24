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
       <div style="float: left; padding-left: 2px; padding-right: 2px; postion: relative; ">
        <div style="left: 660px; height: 14%; width: 4.5%; position: absolute; top: 165px;">
          <button type="button" data-toggle="modal" data-target="#exampleModal8" id="'.$row['idvisita'].'" class="view_data5" style=" float: right; border: 0px; border-radius: 50px; background: #f78b07; width: 30px; height: 30px; color: white;"><i class="far fa-edit"></i></button>
        </div>
       <img style="width: 700px;" src="../img/blog/blog-hero/'.$row['fotoban'].'"> 
       </div>';  
        
      
     $output .= "";  
     echo $output;  
  }  
?>


<script>
 $(document).ready(function(){  
      $('.view_data5').click(function(){  
           var idvisita = $(this).attr("id");  
           $.ajax({  
                url:"acoes/edit_foto_visita_banner.php",  
                method:"post",  
                data:{idvisita:idvisita},  
                success:function(data){  
                     $('#employee_detail7').html(data);  
                     $('#exampleModal8').modal("show");  
                }  
           });  
      });  
 }); 
</script>