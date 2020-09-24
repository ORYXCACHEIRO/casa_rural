<?php 

if(!isset($_SESSION)){ //Se ainda n?o existir a sess?o
	
	session_start(); //criar a sess?o
}

// Include the database config file 
include_once 'bd.php'; 
 
if(!empty($_POST["idpais"])){ 
    // Fetch state data based on the specific country 
    $sql_com=$conn->query("select * from pais where idpais='".$_POST['idpais']."'")or die("Erro ao selecionar os artigos.");
     
    // Generate HTML of state options list 
    if($sql_com->num_rows>=1){  
        $row = $sql_com->fetch_assoc(); 
        $tele = $row['telemovel2'];
            echo '<input class="input" type="text" style="height: 45px;" data-mask="'.$tele.'" placeholder="'.$row['telemovel2'].'" name="telemovel">'; 
    }else{ 
        $coisa = 0000;
        echo '<input class="input" placeholder="Escolha um prefixo primeiro" style="height: 45px;" readonly>'; 
    } 
}
 
?>

<script>
$('input[name="telemovel"]').mask('<?php if($sql_com->num_rows>=1){ echo $tele; } else {  echo $coisa; }?>');

$('input[name="telemovel"]').focusout(function(){
$('input[name="telemovel"]').val( this.value.toUpperCase());
});
</script>

<script>
 $(".my-select").chosen();
</script>
