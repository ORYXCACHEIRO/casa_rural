<?php 

if(isset($_SESSION) && !isset($_SESSION['idutilizador'])){
	echo "<meta http-equiv=refresh content='0; url=index.php?z=6'>"; exit;
} else {

    $veri2=$conn->prepare("select password from utilizadores where idutilizador=?") or die ("erro");

    $veri2->bind_param("i", $_SESSION['idutilizador']);

    $veri2->execute();

    $veri2->store_result();

    $veri2->bind_result($password);

    $veri2->fetch();

    if(isset($_SESSION) && isset($_SESSION['nome']) && isset($_SESSION['tipo']) && $_SESSION['nome']!="" && $_SESSION['tipo']==0 && $password!=""){
        echo "<meta http-equiv=refresh content='0; url=index.php?z=6'>"; exit;
    } else {

        if(isset($_POST['novap']) && $_POST['novap']=="Novap"){

            if(isset($_POST['pass1'])){ $pass1 = preg_replace('/\s+/', '', $_POST['pass1']); } else { $pass1 = ""; }
        
            if(isset($_POST['pass2'])){ $pass2 = preg_replace('/\s+/', '', $_POST['pass2']); } else { $pass2 = ""; }
        
            if(empty($pass1) || empty($pass2)){
                echo "<meta http-equiv=refresh content ='0; url=?pg=16&m=70'>"; exit;
            }
            else {
                if($pass1!=$pass2){
                    echo "<meta http-equiv=refresh content ='0; url=?pg=16&m=70'>"; exit;
                } else {
        
                    $hash = password_hash($pass1, PASSWORD_DEFAULT);
        
                    $sql_up=$conn->prepare("Update utilizadores set password=? where idutilizador=?") or die("Erro ao inserir o registooooo");
        
                    $sql_up->bind_param("si", $hash, $_SESSION['idutilizador']);
        
                    $sql_up->execute();
                    
                    if($sql_up->error){
                        echo "<meta http-equiv=refresh content ='0; url=?pg=16&erro=1'>"; exit;
                    } else {
                        echo "<meta http-equiv=refresh content ='0; url=?pg=7&m=7'>"; exit;
                    }
                    
                }
            }
        
        }

    }

    $veri2->close();

}





?>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style2.css">
</head>
<body >
<!-- partial:index.partial.html -->
<div style="padding-top: 70px;"></div>
<div class="container2" id="container2">
	<div class=" form form-container sign-in-container">
		<form action="?pg=16" method="post">
            <h1 style="font-size: 30px; text-align: center; font-weight: 900; color: black; padding-top: 5px;">Antes de continuar</h1>
			<div class="social-container">
				<span style="font-size: 15px; font-weight: 900; color: black">Insira a sua nova palavra-chave aqui</span></br>
			</div>
			<div>
                <div style="padding-top: 15px;">
					<label style="float: left;">Nova Palavra-chave</label>
					<input class="input" type="password" placeholder="Nova Palavra-chave" name="pass1" required="required"/>
				</div>
                <div style="padding-top: 15px;">
					<label style="float: left;">Repita a nova Palavra-Chave</label>
					<input class="input" type="password" placeholder="Repita a palavra-chave" name="pass2" required="required"/>
				</div>
			</div>
			<?php 
			
			if(isset($_GET['m'])){
				$m=(int)$_GET['m']; 
				
                switch($m){
                    case 70:  echo "<div style='width: 99.5%;'>
                    <p style='text-align: left; color: red; padding-top: 10px;' >As palavras-chave qeu inseriur não coincidem, por favor tente outa vez</p>
                    </div>"; break;
                    default: echo "";
                }
			}
			
			?>
			<button type="submit" name="novap" value="Novap" class="button" style="margin-top: 20px;">Criar</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-right">
				<h1 style="font-size: 30px; font-weight: 900; color: #6f7d5d;">Palavra-Chave</h1>
				<p style="color: white; font-size: 20px; padding-top: 20px;">Certefique-se de colocar uma segura</p>
			</div>
		</div>
	</div>
</div>
<div style="padding-bottom: 70px;"></div>
<!-- partial -->
</body>
</html>
