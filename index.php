<!DOCTYPE html>
<html>
<?php
  require "bd.php"; 

  if(isset($_GET['pg']) && $_GET['pg']>0){
    $pg=$_GET['pg'];
  } else $pg=0;

  if(!isset($_SESSION)){ //Se ainda n?o existir a sess?o
	
    session_start(); //criar a sess?o
  }
	//Set the OAuth 2.0 Redirect URI 
	//Mais tarde mudar o redirect link no Google dev
  //https://console.developers.google.com/apis/credentials/consent?authuser=5&project=maximal-record-280812&supportedpurview=project
  if($pg==6){
  $google_client->setRedirectUri('http://127.0.0.1/casa_rural/index.php?pg=6');
  }

  if($pg==7){
    $google_client->setRedirectUri('http://127.0.0.1/casa_rural/index.php?pg=7');
  }

	$google_client->addScope('email');

  $google_client->addScope('profile');
  
  
  $sql_util=$conn->prepare("select idutilizador from reservas where estadia_conc=1");

  $sql_util->execute();

  $result = $sql_util->get_result();

  if($result->num_rows>=1){

  while($up=$result->fetch_assoc()){

    $sql_util2=$conn->prepare("update utilizadores set reserva_conc=1 where idutilizador=?");
            
    $sql_util2->bind_param("i", $up['idutilizador']);

    $sql_util2->execute();

  }

}

//se clicou no botao entrar
if(isset($_POST['entrar']) && $_POST['entrar']=="Entrar"){
		
  if(isset($_POST['email'])) { $email=Addslashes($_POST['email']); } else { $email = ""; }
  if(isset($_POST['pass'])) { $password=$_POST['pass']; } else { $password = ""; }
  
  
  if($email!="" && $password!=""){
      
      
      $sql_user=$conn->prepare("Select idutilizador, tipo, nome, email, password from utilizadores where email = ? ") or die ("Erro ao selecionar o utilizador.");
      $sql_user->bind_param("s", $email);

      $sql_user->execute();
      $sql_user->store_result();

      $sql_user->bind_result($idutil, $idtipo, $nome, $email, $pass);

      if($sql_user->num_rows>=1){
          //encontrou um utilizador com esse email e password
          
          $sql_user->fetch();
          if(password_verify($password, $pass)){
          $tipo=$idtipo;
          $email=$email;
          $nome=$nome;
          $iduti=$idutil;
          
          //session_start();
          //print_r($_SESSION);
          
          $_SESSION['nome']=$nome;
          $_SESSION['email']=$email;
          $_SESSION['tipo']=$tipo;
          $_SESSION['idutilizador']=$iduti;


          $sql_user->close();

          
          switch($tipo){
              case 0: echo "<meta http-equiv=refresh content ='0; url=index.php'>"; break; //cliente
              
              case 1: echo "<meta http-equiv=refresh content ='0; url=admin/index.php'>"; break; //admin
              default: echo ""; break; //erro
          }
          
          
          }

          else{
              //não existe nenhum utilizador com esse email e/ou password
              
              echo "<meta http-equiv=refresh content ='0; url=?pg=6&m=70'>"; exit;
              
              
          }
      }
      
      else{
          //não existe nenhum utilizador com esse email e/ou password
          
          echo "<meta http-equiv=refresh content ='0; url=?pg=6&m=70'>"; exit;
          
          
      }
}
      

}

?>
<head>
    <title>São Gregório Alojamento Local</title>
    <link rel="icon" href="img/logobranco.png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
     
    <meta property="fb:app_id" content="3129933690399587" />
    <meta property="og:url" content="https://3e224a974692.ngrok.io/casa_rural/index.php" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="São Gregório Alojamento Local"/>
    <meta property="og:description" content="Veja o resto do artigo clicando neste link" />
    <meta property="og:image" content="https://3e224a974692.ngrok.io/casa_rural/img/gallery/3f0edd785562ec8c917137b108406408.jpg" />
    <meta property="og:image:width" content="720" />
    <meta property="og:image:height" content="720" />
    <!--Twitter-->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site_name" content="São Gregório Alojamento Local" />
    <meta name="twitter:creator" content="@o_faria28">
    <meta name="twitter:text:title" content="São Gregório Alojamento Local">
    <meta name="twitter:description" content="Veja o resto do artigo clicando neste link">
    <meta name="twitter:image:src" content="https://3e224a974692.ngrok.io/casa_rural/img/gallery/3f0edd785562ec8c917137b108406408.jpg">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="caleandar/css/demo.css"/>
    <link rel="stylesheet" href="caleandar/css/theme1.css"/>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">  
    <!--<link rel="stylesheet" href="css/nice-select.css" type="text/css">-->
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="croppier/croppie.css">
    <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
    <script src="croppier/croppie.js"></script>
</head>

<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_PT/sdk.js#xfbml=1&version=v7.0&appId=3129933690399587&autoLogAppEvents=1" nonce="jEVbh4qg"></script>


    <?php require "top.php" ?> 
	
    <?php require "paginas.php" ?>
	
    <?php require "footer.php" ?>

    <!-- Search model end -->

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="caleandar/js/caleandar.js"></script>
    
    <script src="js/owl.carousel.min.js"></script>
    <script src="profile.js"></script>
    <script src="js/main.js"></script>
    
    <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/pt_PT/sdk.js#xfbml=1&version=v7.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
    </script>
    <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
    <?php $sql_perfil3=$conn->prepare("select * from reserva_datas")or die("Erro ao selecionar o perfil.");

    $sql_perfil3->execute();

    $result2 = $sql_perfil3->get_result();

    if($result2->num_rows>=1){ ?>
    var events = [
    <?php while($row2=$result2->fetch_assoc()){ 
    $dias=$conn->query("SELECT DAY('".$row2['data']."') as  dia, MONTH('".$row2['data']."')-1 as mes, YEAR('".$row2['data']."') as ano") or die ("Erro ao selecionar o utilizador.");
    $dias2=$dias->fetch_assoc();
    ?>
    {'Date': new Date(<?php echo $dias2['ano'];?>, <?php echo $dias2['mes'];?>, <?php echo $dias2['dia'];?>), 'Title': 'Ocupado'}, 
    <?php } ?> 
    ];
    <?php } else { ?>
      var events = [];
    <?php } ?>
    var settings = {};
    var element = document.getElementById('caleandar');
    caleandar(element, events, settings);
    
    </script>  
    
    
  
    
</body>

</html>