<?php

include('bd.php');
if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){
  $key = $_GET["key"];
  $email = $_GET["email"];
  $curDate = date("Y-m-d H:i:sa");
  $query = mysqli_query($conn,"SELECT * FROM `verify_user` WHERE `key`='".$key."' and `email`='".$email."';");
  $row = mysqli_num_rows($query);

  $query2 = mysqli_query($conn,"SELECT verificado FROM `utilizadores` WHERE `email`='".$email."';");
  $row2 = mysqli_num_rows($query2);
  $coiso = $query2->fetch_assoc();
  if ($row=="" || $row2==0 || $coiso['verificado']==1){
     echo "<meta http-equiv=refresh content='0; url=index.php?erro=2'>";exit;
}

else{
$row = mysqli_fetch_assoc($query);
$expDate = $row['expDate'];
if ($expDate >= $curDate){
?>	

<section class="aboutus-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="about-text">
                    <div class="section-title">
                        <h2>Verificação de email</h2>
                    </div>
                    <p class="f-para">Clique no butão em baixo para verificar o seu email</p>
                    <!--<p class="s-para">So when it comes to booking the perfect hotel, vacation rental, resort,
                        apartment, guest house, or tree house, we’ve got you covered.</p> -->
                    <form action="" name="update" method="post">
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="action" value="update" />
					<input type="hidden" name="email" value="<?php echo $email;?>"/>
                    <button type="submit" class="primary-btn about-btn" style="margin-top: 50px; border: 0px; background: transparent;">Verificar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

}
else{
$error .= "<meta http-equiv=refresh content='0; url=?pg=0&erro=2'>; exit;";
            }
      }
if($error!=""){
  echo "<div class='error'>".$error."</div><br />";
  } 
} // isset email key validate end
 
 
if(isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"]=="update")){
$error="";
$email = $_POST["email"];
$verificado = 1;
$updateee = mysqli_query($conn,"UPDATE `utilizadores` SET `verificado`='".$verificado."' WHERE `email`='".$email."';");
 
mysqli_query($conn,"DELETE FROM `verify_user` WHERE `email`='".$email."';");
 
if($updateee){
	echo "<meta http-equiv=refresh content='0; url=?pg=0&m=4'>";exit;
}

} 
?>