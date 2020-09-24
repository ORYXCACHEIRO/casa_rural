<?php 


// Include the database config file 
include_once '../bd.php'; 
 
if(!empty($_POST["idpais"]) && !empty($_POST["idutil"])){ 
    // Fetch state data based on the specific country 
    $sql_com=$conn->query("select * from pais where idpais='".$_POST['idpais']."'")or die("Erro ao selecionar os artigos.");
     
    // Generate HTML of state options list 
    if($sql_com->num_rows>=1){  
        $row = $sql_com->fetch_assoc(); 

        $sql_com2=$conn->query("select prefix, telemovel from utilizadores where idutilizador='".$_POST['idutil']."'")or die("Erro ao selecionar os artigos.");
        $row2 = $sql_com2->fetch_assoc(); 

        $tele = $row['telemovel2'];
        if($row2['prefix']==$row['telemovel']){
            echo '<label for="exampleInputEmail1">Telémovel</label>';
            echo '<input class="form-control" type="text" data-mask="'.$tele.'" placeholder="'.$row['telemovel2'].'" value="'.$row2['telemovel'].'" name="telemovel" required> '; 
        }else{
            echo '<label for="exampleInputEmail1">Telémovel</label>';
            echo '<input class="form-control" type="text" data-mask="'.$tele.'" placeholder="'.$row['telemovel2'].'" name="telemovel" required>'; 
        }
            
    }else{ 
        $coisa = 0000;
        echo '<label for="exampleInputEmail1">Telémovel</label>';
        echo '<input class="form-control" type="text" placeholder="Escolha um prefixo primeiro" readonly>'; 
    } 
}
 
?>

<script type="text/javascript">
$('input[name="telemovel"]').mask('<?php if($sql_com->num_rows>=1){ echo $tele; } else {  echo $coisa; }?>');

$('input[name="telemovel"]').focusout(function(){
$('input[name="telemovel"]').val( this.value.toUpperCase());
});

</script>
