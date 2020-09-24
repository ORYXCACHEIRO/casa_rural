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
      $query = "SELECT * FROM galeria_visita WHERE idvisita = '".$_POST["idvisita"]."'";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
      ';  
      while($row = mysqli_fetch_array($result))  
      {  
  		 
       $output .= ' 
       <input type="hidden" value="'.$row['idvisita'].'" id="id_visita">
       <div style="float: left; padding-left: 2px; padding-right: 2px; postion: relative;">
       <div style="height: 25%; width: 31%; position: absolute; top: 30px;">
            <div style="height: 100%; width: 10%; float: right;">
                <button type="button" data-toggle="modal" data-target="#exampleModal5" id="'.$row['idfoto_visita'].'" class="view_data4" style=" float: right; border: 0px; border-radius: 50px; background: #404040; width: 30px; height: 30px; color: white;"><i class="fas fa-exchange-alt"></i></button>
                <p style="color: white; background: #404040; text-align: center; float: right; border: 0px; border-radius: 50px; width: 30px; height: 30px; margin-top: 4px; font-size: 19px; font-weight: 500;">'.$row['idfoto_visita'].'</p>
            </div>
        </div>
        <div style="height: 12%; width: 31%; position: absolute; top: 200px;">
          <button type="button" data-toggle="modal" data-target="#exampleModal6" id="'.$row['idfoto_visita'].'" class="view_data5" style=" float: right; border: 0px; border-radius: 50px; background: #cccc00; width: 30px; height: 30px; color: white;"><i class="far fa-edit"></i></button>
        </div>
       <img src="../img/blog/blog-details/'.$row['foto'].'"> 
       </div>';  
        
      
     }
     $output .= "";  
     echo $output;  
  }  
?>


<script>
 $(document).ready(function(){  
      $('.view_data4').click(function(){  
           var idfoto_visita = $(this).attr("id");  
           var idvisita = $('#id_visita').val();
           $.ajax({  
                url:"acoes/troca_foto_visita.php",  
                method:"post",
                data:{"idfoto_visita":idfoto_visita, "idvisita":idvisita},  
                success:function(data){  
                     $('#employee_detail4').html(data);  
                     $('#exampleModal5').modal("show");  
                }  
           });  
      });  
 }); 
</script>

<script>
 $(document).ready(function(){  
      $('.view_data5').click(function(){  
           var idfoto_visita = $(this).attr("id");  
           $.ajax({  
                url:"acoes/edit_foto_visita.php",  
                method:"post",  
                data:{idfoto_visita:idfoto_visita},  
                success:function(data){  
                     $('#employee_detail5').html(data);  
                     $('#exampleModal6').modal("show");  
                }  
           });  
      });  
 }); 
</script>