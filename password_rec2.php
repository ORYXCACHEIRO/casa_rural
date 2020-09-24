
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
    <?php
include('bd.php');
if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){
  $key = $_GET["key"];
  $email = $_GET["email"];
  $curDate = date("Y-m-d H:i:sa");
  $query = mysqli_query($conn,"SELECT * FROM `password_reset` WHERE `key`='".$key."' and `email`='".$email."';");
  $row = mysqli_num_rows($query);
  if ($row==""){
    echo "<meta http-equiv=refresh content='0; url=index.php?erro=2'>";exit;
 }
  else{
  $row = mysqli_fetch_assoc($query);
  $expDate = $row['expDate'];
  if ($expDate >= $curDate){
  ?>
		<form action="" method="post">
			<h1 style="font-size: 30px; font-weight: 900; color: black;">Recuperar</h1>
            <h1 style="font-size: 30px; text-align: center; font-weight: 900; color: black; padding-top: 5px;">Palavra-chave</h1>
			<div class="social-container">
				<span style="font-size: 15px; font-weight: 900; color: black">Insira a sua nova palavra-chave aqui</span></br>
			</div>
			<div>
                <div style="padding-top: 15px;">
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="email" value="<?php echo $email;?>"/>
					<label style="float: left;">Nova Password</label>
					<input class="input" type="password" placeholder="Nova Password" name="pass1" required="required"/>
				</div>
                <div style="padding-top: 15px;">
					<label style="float: left;">Repita a nova password</label>
					<input class="input" type="password" placeholder="Repita a password" name="pass2" required="required"/>
				</div>
			</div>
			<?php 
			
			if(isset($_GET['m'])){
				$m=(int)$_GET['m']; 
				
					switch($m){
						case 70:  echo "<div style='width: 99.5%;'>
						<p style='text-align: left; color: red; padding-top: 10px;' >O email que inseriu não existe</p>
						</div>"; break;
						default: echo "";
					}
				}
			
			?>
			<button type="submit" class="button" style="margin-top: 20px;">Editar</button>
		</form>
        <?php
}
else{
$error .= "<meta http-equiv=refresh content='0; url=?pg=0&erro=2'>; exit;";
            }
      }
if($error!=""){
  echo "<div class='error'>".$error."</div><br />";
  } 
}// isset email key validate end
 
 
if(isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"]=="update")){
$error="";
$pass1 = mysqli_real_escape_string($conn,$_POST["pass1"]);
$pass2 = mysqli_real_escape_string($conn,$_POST["pass2"]);
$email = $_POST["email"];
$curDate = date("Y-m-d H:i:sa");
if ($pass1!=$pass2 || empty(trim($_POST['pass1'])) || empty(trim($_POST['pass2']))){
$error.= '"<meta http-equiv=refresh content="0; url=?pg=14&key='.$_GET['key'].'&email='.$_GET['email'].'&m=70&action=reset"target="_blank">"; exit';
  }
  if($error!=""){
echo "<div class='error'>".$error."</div><br />";
}
else{

$hash = password_hash($pass1 , PASSWORD_DEFAULT);
$updateee = mysqli_query($conn,"UPDATE `utilizadores` SET `password`='".$hash."'  WHERE `email`='".$email."';");
 
mysqli_query($conn,"DELETE FROM `password_reset` WHERE `email`='".$email."';");
 
if($updateee){
	echo "<meta http-equiv=refresh content='0; url=?pg=6&m=2'>";exit;
}

}
}
?>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-right">
				<h1 style="font-size: 30px; font-weight: 900; color: #6f7d5d;">Lembra-se da palavra-chave?</h1>
				<p style="color: white; font-size: 20px; padding-top: 20px;">Faça login na sua conta aqui</p>
				<a style="margin-top: 20px;" class="button ghost" href="?pg=6">Login</a>
			</div>
		</div>
	</div>
</div>
<div style="padding-bottom: 70px;"></div>
<!-- partial -->
</body>
</html>
