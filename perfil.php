<?php

if(isset($_SESSION) && !isset($_SESSION['nome']) && !isset($_SESSION['tipo']) || isset($_SESSION) && isset($_SESSION['tipo']) && $_SESSION['tipo']==1){
	echo "<meta http-equiv=refresh content='0; url=index.php?z=3'>"; exit;
} else {
	
	$veri=$conn->prepare("select password from utilizadores where idutilizador=?") or die ("erro");

	$veri->bind_param("i", $_SESSION['idutilizador']);

	$veri->execute();

	$veri->store_result();

	$veri->bind_result($pass);

	$veri->fetch();

	$veri->close();

	if($pass==""){
		echo "<meta http-equiv=refresh content='0; url=?pg=16'>"; exit;
	}

}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor\autoload.php';

$mail = new PHPMailer(TRUE);

if(isset($_GET["code"])){

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

	if(!isset($token['error'])) {

      $google_client->setAccessToken($token['access_token']);

      $_SESSION['access_token'] = $token['access_token'];
      
      $payload = $google_client->verifyIdToken($token['id_token']);

     if($payload){

			$google_service = new Google_Service_Oauth2($google_client);

			$data = $google_service->userinfo->get();

			$id = $_SESSION['idutilizador'];
			$googleid = $data['id'];
			$email = $data['email'];
			$google = 1;

			$sql_perfil3=$conn->query("select count(*) as total from utilizadores where googleid='".$googleid."'")or die("Erro ao selecionar o nome.");
			$ln_perfil3=$sql_perfil3->fetch_assoc();
			if($ln_perfil3['total']>=1){
				$google_client->revokeToken();
				echo "<meta http-equiv='refresh' content='0; url=?pg=7&z=9'>";exit;
			} else {

			$sql_perfil4=$conn->query("select * from utilizadores_block where email='".$email."'")or die("Erro ao selecionar o nome.");
			$ln_perfil4=$sql_perfil4->fetch_assoc();

			if($sql_perfil4->num_rows>=1){
				echo "<meta http-equiv='refresh' content='0; url=?pg=7&z=10'>";exit;
			} else {

			$sql_perfil=$conn->prepare("update utilizadores set google_account=?, googleid=? where idutilizador=?") or die("Falha ao editar o pefil");
		
			$sql_perfil->bind_param("isi", $google,  $googleid, $id);

			$sql_perfil->execute();

			if($sql_perfil->error){
				echo "<meta http-equiv='refresh' content='0; url=?pg=7&erro=1>";exit;
			}		
			else{
				echo "<meta http-equiv='refresh' content='0; url=?pg=7&m=9'>";exit;
			}
		}
		}

		} else {
			echo "<meta http-equiv='refresh' content='0; url=?pg=7&erro=1>";exit;
		}
	}	

}

if(isset($_POST['delete']) && $_POST['delete']=="Delete"){ 

	$id = (int)$_SESSION['idutilizador'];

	$sql_perfil=$conn->query("select foto from utilizadores where idutilizador='".$id."'")or die("Erro ao selecionar o nome.");
	
	$ln_perfil=$sql_perfil->fetch_assoc();

	$foto = $ln_perfil['foto'];

	if($foto!=""){

		unlink("img/perfis/$foto");

		$foto_vazia = "";

		$sql_perfil=$conn->prepare("update utilizadores set foto=? where idutilizador=?") or die("Falha ao editar o pefil");
		
		$sql_perfil->bind_param("si", $foto_vazia, $id);

		$sql_perfil->execute();

		echo "<meta http-equiv='refresh' content='0; url=?pg=7&m=10>";exit;

	} else {

		echo "<meta http-equiv='refresh' content='0; url=?pg=7&erro=1>";exit;
	}


}

if(isset($_POST['desv']) && $_POST['desv']=="Desv"){ 

	$id = $_SESSION['idutilizador'];
	$googlea = 0;
	$googleid = "";

	$sql_perfil=$conn->prepare("update utilizadores set google_account=?, googleid=? where idutilizador=?") or die("Falha ao editar o pefil");
		
	$sql_perfil->bind_param("isi", $googlea,  $googleid, $id);

	$sql_perfil->execute();

	if($sql_perfil->error){
		echo "<meta http-equiv='refresh' content='0; url=?pg=7&erro=1>";exit;
	}		
	else{
		echo "<meta http-equiv='refresh' content='0; url=?pg=7&m=8'>";exit;
	}

}

if(isset($_POST['verificar']) && $_POST['verificar']=="Verificar"){ 

	$email=$_POST['email'];
	$nome=$_POST['nome'];

	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	if (!$email) {
	$error .= '"<meta http-equiv="refresh" content="0; url=?pg=7&erro=1">";exit';
	}
	else{
	$sel_query = "SELECT * FROM `utilizadores` WHERE email='".$email."'";
	$results = mysqli_query($conn, $sel_query);
	$row = mysqli_num_rows($results);
	if ($row==""){
	$error .= '"<meta http-equiv="refresh" content="0; url=?pg=7&erro=1">";exit';
	}
	}
	if($error!=""){
		echo "<meta http-equiv='refresh' content='0; url=?pg=7&erro=1'>";exit;
	}
	else{
	$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
	$expDate = date("Y-m-d H:i:sa",$expFormat);
	$key = md5(2418*2 . $email);
	$addKey = substr(md5(uniqid(rand(),1)),3,10);
	$key = $key.$addKey;

	$sql_cont=$conn->query("select * from contactos")or die("Erro ao selecionar o nome.");
  	$rowc = $sql_cont->fetch_assoc();

	mysqli_query($conn,"DELETE FROM `verify_user` WHERE `email`='".$email."';");

	mysqli_query($conn,"INSERT INTO `verify_user` (`email`, `key`, `expDate`) VALUES ('".$email."', '".$key."', '".$expDate."');");
	
	$mail->setFrom('info.casasaogregorio@gmail.com', 'InfoCasaSãoGregório | Denise Lima');
	$mail->addAddress($email, $nome);
	$mail->CharSet = 'UTF-8';
	$mail->Subject = 'Verificação de conta';
	$mail->isHTML(TRUE);
	$mail->AddEmbeddedImage('img/logofinal.png', 'logo');
	$mail->AddEmbeddedImage('img/facebook.png', 'fb');
	$mail->AddEmbeddedImage('img/instagram.png', 'insta');
	$mail->AddEmbeddedImage('img/twitter.png', 'twitter');
	$mail->AddEmbeddedImage('img/services/bottom_rounded_15.png', 'bottom');
	
	$mail->Body = '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
	<head>
	<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
	<meta content="width=device-width" name="viewport"/>
	<!--[if !mso]><!-->
	<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
	<!--<![endif]-->
	<title></title>
	<!--[if !mso]><!-->
	<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Chivo" rel="stylesheet" type="text/css"/>
	<!--<![endif]-->
	<style type="text/css">
			body {
				margin: 0;
				padding: 0;
			}
	
			table,
			td,
			tr {
				vertical-align: top;
				border-collapse: collapse;
			}
	
			* {
				line-height: inherit;
			}
	
			a[x-apple-data-detectors=true] {
				color: inherit !important;
				text-decoration: none !important;
			}
		</style>
	<style id="media-query" type="text/css">
			@media (max-width: 580px) {
	
				.block-grid,
				.col {
					min-width: 320px !important;
					max-width: 100% !important;
					display: block !important;
				}
	
				.block-grid {
					width: 100% !important;
				}
	
				.col {
					width: 100% !important;
				}
	
				.col>div {
					margin: 0 auto;
				}
	
				img.fullwidth,
				img.fullwidthOnMobile {
					max-width: 100% !important;
				}
	
				.no-stack .col {
					min-width: 0 !important;
					display: table-cell !important;
				}
	
				.no-stack.two-up .col {
					width: 50% !important;
				}
	
				.no-stack .col.num4 {
					width: 33% !important;
				}
	
				.no-stack .col.num8 {
					width: 66% !important;
				}
	
				.no-stack .col.num4 {
					width: 33% !important;
				}
	
				.no-stack .col.num3 {
					width: 25% !important;
				}
	
				.no-stack .col.num6 {
					width: 50% !important;
				}
	
				.no-stack .col.num9 {
					width: 75% !important;
				}
	
				.video-block {
					max-width: none !important;
				}
	
				.mobile_hide {
					min-height: 0px;
					max-height: 0px;
					max-width: 0px;
					display: none;
					overflow: hidden;
					font-size: 0px;
				}
	
				.desktop_hide {
					display: block !important;
					max-height: none !important;
				}
			}
		</style>
	</head>
	<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #323742;">
	<!--[if IE]><div class="ie-browser"><![endif]-->
	<table bgcolor="#323742" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #323742; width: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td style="word-break: break-word; vertical-align: top;" valign="top">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#323742"><![endif]-->
	<div style="background-color:#fff;">
	<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 560px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:560px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="560" style="background-color:transparent;width:560px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
	<div class="col num12" style="min-width: 320px; max-width: 560px; display: table-cell; vertical-align: top; width: 560px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px solid transparent; width: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<div style="background-color:#fff;">
	<div class="block-grid three-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 560px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:560px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="186" style="background-color:transparent;width:186px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:5px;"><![endif]-->
	<div class="col num4" style="max-width: 320px; min-width: 186px; display: table-cell; vertical-align: top; width: 186px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 3px; padding-top: 25px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
	<div style="color:#FFFFFF;font-family:Chivo, Arial, Helvetica, sans-serif;line-height:1.2;padding-top:25px;padding-right:0px;padding-bottom:10px;padding-left:3px;">
	<div style="font-size: 12px; line-height: 1.2; color: #FFFFFF; font-family: Chivo, Arial, Helvetica, sans-serif; mso-line-height-alt: 14px;">
	<p style="font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin: 0;"><strong><span style="font-size: 12px;">'.$rowc['email'].'</span></strong></p>
	</div>
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td><td align="center" width="186" style="background-color:transparent;width:186px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:5px;"><![endif]-->
	<div class="col num4" style="max-width: 320px; min-width: 186px; display: table-cell; vertical-align: top; width: 186px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]--><img align="center" alt="Image" border="0" class="center fixedwidth" src="cid:logo" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 65px; display: block;" title="Image" width="65"/>
	<!--[if mso]></td></tr></table><![endif]-->
	</div>
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td><td align="center" width="186" style="background-color:transparent;width:186px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
	<div class="col num4" style="max-width: 320px; min-width: 186px; display: table-cell; vertical-align: top; width: 186px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 3px; padding-left: 0px; padding-top: 25px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
	<div style="color:#6f7d5d;font-family:Chivo, Arial, Helvetica, sans-serif;line-height:1.2;padding-top:25px;padding-right:3px;padding-bottom:10px;padding-left:0px;">
	<div style="font-size: 12px; line-height: 1.2; color: #6f7d5d; font-family: Chivo, Arial, Helvetica, sans-serif; mso-line-height-alt: 14px;">
	<p style="font-size: 14px; line-height: 1.2; text-align: right; word-break: break-word; mso-line-height-alt: 17px; margin: 0;"><strong><span style="font-size: 12px;">'.$rowc['tele'].'</span></strong></p>
	</div>
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<div style="background-color:#fff;">
	<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 560px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:560px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="560" style="background-color:transparent;width:560px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
	<div class="col num12" style="min-width: 320px; max-width: 560px; display: table-cell; vertical-align: top; width: 560px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="3" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 3px; width: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td height="3" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<div style="background-color:#6f7d5d;">
	<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 560px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:560px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="560" style="background-color:transparent;width:560px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;"><![endif]-->
	<div class="col num12" style="min-width: 320px; max-width: 560px; display: table-cell; vertical-align: top; width: 560px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:10px; padding-bottom:10px; padding-right: 10px; padding-left: 10px;">
	<!--<![endif]-->
	<table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;" valign="top">
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="1" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 1px; width: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td height="1" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<div style="background-color:#6f7d5d;">
	<div class="block-grid mixed-two-up no-stack" style="Margin: 0 auto; min-width: 320px; max-width: 560px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #4e5841;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:#4e5841;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:560px"><tr class="layout-full-width" style="background-color:#4e5841"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="373" style="background-color:#4e5841;width:373px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;background-color:#4e5841;"><![endif]-->
	<div class="col num8" style="display: table-cell; vertical-align: top; min-width: 320px; max-width: 368px; width: 373px;">
	<div style="background-color:#4e5841;width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 20px; padding-top: 10px; padding-bottom: 10px; font-family: "Times New Roman", serif"><![endif]-->
	<div style="color:#FFFFFF;font-family:"Cormorant Garamond", "Times New Roman", Times, serif;line-height:2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:20px;">
	<div style="font-size: 12px; line-height: 2; font-family: "Cormorant Garamond", "Times New Roman", Times, serif; color: #FFFFFF; mso-line-height-alt: 24px;">
	<p style="font-size: 28px; line-height: 2; word-break: break-word; font-family: Cormorant Garamond, Times New Roman, Times, serif; mso-line-height-alt: 56px; margin: 0;"><span style="font-size: 28px; padding-left: 30px; color: white;"><strong><span style="font-size: 28px;"></span></strong></span></p>
	</div>
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td><td align="center" width="186" style="background-color:#4e5841;width:186px; border-top: 0px dotted #FFFFFF; border-left: 1px dotted #4e5841; border-bottom: 0px solid #FFFFFF; border-right: 0px dotted #FFFFFF;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
	<div class="col num4" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 184px; width: 185px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px dotted #FFFFFF; border-left:1px dotted #4e5841; border-bottom:0px solid #FFFFFF; border-right:0px dotted #FFFFFF; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px solid transparent; width: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<div style="background-color:#6f7d5d;">
	<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 560px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:560px"><tr class="layout-full-width" style="background-color:#FFFFFF"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="560" style="background-color:#FFFFFF;width:560px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:20px; padding-bottom:10px;"><![endif]-->
	<div class="col num12" style="min-width: 320px; max-width: 560px; display: table-cell; vertical-align: top; width: 560px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:20px; padding-bottom:10px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
	<div style="color:#555555;font-family:Chivo, Arial, Helvetica, sans-serif;line-height:2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
	<div style="font-size: 12px; line-height: 2; font-family: Chivo, Arial, Helvetica, sans-serif; color: #6f7d5d; mso-line-height-alt: 24px;">
	<p style="font-size: 28px; line-height: 2; text-align: center; word-break: break-word; font-family: Cormorant Garamond, Times New Roman, Times, serif; mso-line-height-alt: 56px; margin: 0;"><span style="font-size: 28px; "><strong><span style="font-size: 28px;">Reenvio da verificação de email</span></strong></span></p>
	</div>
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
	<div style="color:#555555;font-family:Chivo, Arial, Helvetica, sans-serif;line-height:2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
	<div style="line-height: 2; font-size: 12px; color: #555555; font-family: Chivo, Arial, Helvetica, sans-serif; mso-line-height-alt: 24px;">
	<p style="line-height: 2; word-break: break-word; text-align: center; font-size: 16px; mso-line-height-alt: 32px; margin: 0;"><span style="font-size: 16px;">Para verificar a sua conta e puder aceder às restantes funcionaliades do site basta clicar neste butão em baixo </span></p>
	<p style="line-height: 2; word-break: break-word; text-align: center; font-size: 16px; mso-line-height-alt: 32px; margin: 0;"><span style="font-size: 16px;">(Este link está ativo por apenas 24 horas)</span></p>
	</div>
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<div style="background-color:#6f7d5d;">
	<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 560px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:560px"><tr class="layout-full-width" style="background-color:#FFFFFF"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="560" style="background-color:#FFFFFF;width:560px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:20px; padding-bottom:10px;"><![endif]-->
	<div class="col num12" style="min-width: 320px; max-width: 560px; display: table-cell; vertical-align: top; width: 560px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:20px; padding-bottom:10px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<div align="center" class="button-container" style="padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="" style="height:36pt; width:275.25pt; v-text-anchor:middle;" arcsize="38%" stroke="false" fillcolor="#6f7d5d"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:24px"><![endif]-->
	<div style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#6f7d5d;border-radius:18px;-webkit-border-radius:18px;-moz-border-radius:18px;width:auto; width:auto;;border-top:1px solid #6f7d5d;border-right:1px solid #6f7d5d;border-bottom:1px solid #6f7d5d;border-left:1px solid #6f7d5d;padding-top:0px;padding-bottom:0px;font-family:Chivo, Arial, Helvetica, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;"><a style="color: white;" href="http://127.0.0.1/casa_rural/index.php?pg=12&amp;key='.$key.'&amp;email='.$email.'&amp;action=reset"><span style="padding-left:50px;padding-right:50px;font-size:24px;display:inline-block;"><span style="font-size: 16px; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;"><span data-mce-style="font-size: 24px; line-height: 48px;" style="font-size: 24px; line-height: 48px;"><strong>Verificar conta</strong></span></span></span></a></div>
	<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
	</div>
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<div style="background-color:#6f7d5d;">
	<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 560px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:560px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="560" style="background-color:transparent;width:560px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:5px;"><![endif]-->
	<div class="col num12" style="min-width: 320px; max-width: 560px; display: table-cell; vertical-align: top; width: 560px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
	<!--<![endif]-->
	<div align="center" class="img-container center autowidth fullwidth">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="" align="center"><![endif]--><img align="center" alt="Image" border="0" class="center autowidth fullwidth" src="cid:bottom" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 560px; display: block;" title="Image" width="560"/>
	<!--[if mso]></td></tr></table><![endif]-->
	</div>
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<div style="background-color:#6f7d5d;">
	<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 560px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:560px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="560" style="background-color:transparent;width:560px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 5px; padding-left: 5px; padding-top:5px; padding-bottom:5px;"><![endif]-->
	<div class="col num12" style="min-width: 320px; max-width: 560px; display: table-cell; vertical-align: top; width: 560px;">
	<div style="width:100% !important;">
	<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 5px; padding-left: 5px;">
	<!--<![endif]-->
	<table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;" valign="top">
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="1" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 1px; width: 100%;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td height="1" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<div style="background-color:#fff;">
	<div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
	<div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
	<!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:500px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
	<!--[if (mso)|(IE)]><td align="center" width="500" style="background-color:transparent;width:500px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
	<div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;">
	<div style="width:100% !important;">
		<!--[if (!mso)&(!IE)]><!-->
	<div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
		<!--<![endif]-->
	<div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
		<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]--><img align="center" alt="Image" border="0" class="center fixedwidth" src="cid:logo" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 60px; display: block;" title="Image" width="60"/>
		<!--[if mso]></td></tr></table><![endif]-->
	</div>
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
	<div style="color:#555555;font-family:Chivo, Arial, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
	<div style="font-size: 12px; line-height: 1.2; color: #555555; font-family: Chivo, Arial, Helvetica, sans-serif; mso-line-height-alt: 14px;">
	<p style="font-size: 14px; line-height: 1.2; text-align: center; word-break: break-word; mso-line-height-alt: 17px; margin: 0;"><span style="color: #999999; font-size: 14px;"><strong><span style="font-size: 12px;">São Gregório Alojamento Local © '.$rowc['morada'].'</span></strong></span></p>
	</div>
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
	<table cellpadding="0" cellspacing="0" class="social_icons" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%">
	<tbody>
	<tr style="vertical-align: top;" valign="top">
	<td style="word-break: break-word; vertical-align: top; padding-top: 15px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
	<table align="center" cellpadding="0" cellspacing="0" class="social_table" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-tspace: 0; mso-table-rspace: 0; mso-table-bspace: 0; mso-table-lspace: 0;" valign="top">
	<tbody>
	<tr align="center" style="vertical-align: top; display: inline-block; text-align: center;" valign="top">
	<td style="word-break: break-word; vertical-align: top; padding-bottom: 5px; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://www.facebook.com/" target="_blank"><img alt="Facebook" height="32" src="cid:fb" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: none; display: block;" title="Facebook" width="32"/></a></td>
	<td style="word-break: break-word; vertical-align: top; padding-bottom: 5px; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://twitter.com/" target="_blank"><img alt="Twitter" height="32" src="cid:twitter" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: none; display: block;" title="Twitter" width="32"/></a></td>
	<td style="word-break: break-word; vertical-align: top; padding-bottom: 5px; padding-right: 5px; padding-left: 5px;" valign="top"><a href="https://instagram.com/" target="_blank"><img alt="Instagram" height="32" src="cid:insta" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: none; display: block;" title="Instagram" width="32"/></a></td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
	<div style="color:#6f7d5d;font-family:Chivo, Arial, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
	<div style="font-size: 12px; line-height: 1.2; color: #6f7d5d; font-family: Chivo, Arial, Helvetica, sans-serif; mso-line-height-alt: 14px;">
	<p style="font-size: 14px; line-height: 1.2; text-align: center; word-break: break-word; mso-line-height-alt: 17px; margin: 0;">São Gregório Alojamento Local © All rights reserved</p>
	</div>
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
	<!--[if (!mso)&(!IE)]><!-->
	</div>
	<!--<![endif]-->
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
	</div>
	</div>
	</div>
	<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
	</td>
	</tr>
	</tbody>
	</table>
	<!--[if (IE)]></div><![endif]-->
	</body>
	</html>';
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';    // SMTP utilizado
	$mail->SMTPAuth = TRUE;
	$mail->SMTPSecure = 'tls';
	$mail->Username = 'info.casasaogregorio@gmail.com';
	$mail->Password = 'V/CTXvz7<{4"ezd9Rt/!#h';
	$mail->Port = 587;

	/* Enable SMTP debug output. */
	$mail->SMTPDebug = 0;

	$mail->send();

	}

}

?>
<!-- partial:index.partial.html -->
<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 99; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal2 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 99; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal3 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 99; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  position: absolute; 
  left: 50%; 
  top: 50%;  
  transform: translate(-50%, -50%);
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 425px;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.close2 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close2:hover,
.close2:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.close3 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close3:hover,
.close3:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

</style>

<div style="padding-top: 70px;"></div>


<div class="container2" id="container2">
			
	<div class=" form form-container sign-in-container">
		<form action="?pg=7" method="post">
			<div class="btn-group dropleft dropbutao">
				<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="img/marca-paginas.png">
				</button>
				<?php 
				
				$sql_not=$conn->prepare("select * from reserva_cancelar where idutilizador=?")or die("Erro ao selecionar o perfil.");

				$sql_not->bind_param("i", $_SESSION['idutilizador']);

				$sql_not->execute();

				$result = $sql_not->get_result();

				?>
				<div class="dropdown-menu">
					<h4 class="dropdown-header" style="text-align: center;">Reservas</h4> 
					<div class="dropdown-divider"></div>
					<?php if($result->num_rows>=1){ 
						
						while($ln_not=$result->fetch_assoc()){ 
							
						$sql_not2=$conn->prepare("select * from reservas where idreserva=?")or die("Erro ao selecionar o perfil.");

						$sql_not2->bind_param("i", $ln_not['idreserva']);

						$sql_not2->execute();

						$result2 = $sql_not2->get_result(); 
						
						$ln_not2=$result2->fetch_assoc(); 
						
					?>
					<p style="text-align: center;" ><?php echo $ln_not2['datai'];?> a <?php echo $ln_not2['dataf'];?> <a href="?pg=17&res=<?php echo $ln_not2['idreserva'];?>&canc=<?php echo $ln_not['idreservac'];?>" style="color: #4e5841; display: block;">Cancelar</a></p>
					<?php } } else { ?>
					<p style="text-align: center;" >Sem reservas para cancelar</p>
					<?php }  ?>
				</div>
			</div>
			<h1 style="font-size: 30px; font-weight: 900; color: black;">Perfil</h1>
			<div class="social-container">
				<span style="font-size: 15px; font-weight: 900; color: black">E toda a sua informação</span></br>
			</div>
			<div>
			<?php 
			$sql_perfil=$conn->query("select * from utilizadores where idutilizador='".$_SESSION['idutilizador']."'")or die("Erro ao selecionar o nome.");
			if($sql_perfil->num_rows>=1){ 
			$ln_perfil=$sql_perfil->fetch_assoc();?>
						
				<div style="background: #8f9d7b; width: 80px; height: 80px; margin-left: auto; margin-right: auto; border-radius: 50px;">
					<?php if($ln_perfil['foto']==""){?>
						<img src="img/perfis/default.png" style="width: 70px; border-radius: 50px; margin-top: 5.15px; margin-left: 0px;">
					<?php } else { ?>
						<img src="img/perfis/<?php echo $ln_perfil['foto'];?>" style="width: 70px; border-radius: 50px; margin-top: 5.15px; margin-left: 0.5px;">
					<?php } ?>
					<div class="icon_div"><button type="button" style="background-color: black; border: 0px; border-radius: 50px;" id="myBtn" class="edit-icon-pic"><i style="margin-top: 4.5px; margin-left: 2px; font-size: 13px;" class="fa fa-edit"></i></button></div>
				</div>
				<!-- Modal -->
				<div>
					<label style="float: left;">Nome</label>
					<input class="input"  placeholder="Nome"  value="<?php echo $ln_perfil['nome'];?>" disabled/>
				</div>
				<div>
					<label style="float: left;">Email</label>
					<input class="input" placeholder="Email" value="<?php echo $ln_perfil['email'];?>" disabled/>
				</div>
				<div>
					<label style="float: left;">Data de Nascimento</label>
					<?php if($ln_perfil['data']!="0000-00-00"){?>
					<input class="input" placeholder="Email"  value="<?php echo $ln_perfil['data'];?>" disabled/>
					<?php } else { ?>
					<input class="input" placeholder="Email"  value="Por defenir" disabled/>
					<?php } ?>
				</div>
				<div>
					<label style="float: left;">País</label>
					<?php if($ln_perfil['idpais']==0){?>
					<input class="input" placeholder="Email" value="Por defenir" disabled/>

					<?php } else { $sql_perfil2=$conn->query("select * from pais where idpais='".$ln_perfil['idpais']."'")or die("Erro ao selecionar o nome."); $ln_perfil2=$sql_perfil2->fetch_assoc();?>
										
					<input class="input" placeholder="Email" value="<?php echo $ln_perfil2['paisNome'];?>" disabled/>
					<?php } ?>
				</div>
				<div>
					<label style="float: left;">Telémovel</label>
					<?php if($ln_perfil['prefix']!="" && $ln_perfil['telemovel']!=""){ ?>
					<input class="input" placeholder="Telémovel" value="<?php echo $ln_perfil['prefix'];?> <?php echo $ln_perfil['telemovel'];?>" disabled/>
					<?php } else { ?>
					<input class="input" placeholder="Telémovel" value="Por defenir" disabled/>
					<?php } ?>
				</div>
				<?php if($ln_perfil['google_account']==1){ ?>
				<p style="margin-left: 5%; font-family: 'Roboto', sans-serif; font-size: 16px; margin-top: 15px;">Conta linkada com <img style="padding: 3px; border-radius: 50px; width: 30px;"src="img/google.png"><p>
				<button name="desv" value="Desv" style="border: 0px; background: #6f7d5d; color: white; height: 40px; border-radius: 30px;"><span style="padding: 10px;">Desvincular</span></button>
				<?php } else { ?>
					<div>
						<label style="float: left;">Vincular Conta <div style="position: absolute; margin-left: 105px; margin-top: -26px;" data-toggle="tooltip" data-placement="top" title="Vincu-le a sua conta Google para puder efetuar login com apenas um clique"><img style="width: 18px;" src="img/informacao.png"></div></label>
						<button type="button" onclick="location.href='<?php echo $google_client->createAuthUrl()?>'" style="margin-top: 10px; background-color: #fff; font-family: 'Roboto', sans-serif; border: 1.5px solid #1a73e8; color: #000; width: 100%; height: 55px; border-radius: 50px; ">Vincular <img style="padding: 3px; border-radius: 50px; width: 30px;"src="img/google.png"></button>
					</div>
				<?php } ?>
				<?php if($ln_perfil['verificado']==0){ ?>
				<div style="padding-top: 30px;">
					<p>Ainda não confirmou o seu email<p>
					<form action="?pg=7" method="post">
					<input type="hidden" value="<?php echo $_SESSION['email']; ?>" name="email">
					<input type="hidden" value="<?php echo $_SESSION['nome']; ?>" name="nome">
					<p>Clique<button type="submit" name="verificar" value="Verificar" style="background: transparent; border: 0px; color: #6f7d5d; ">aqui</button>se precisar reenviar o email de verificação<p>
					</form>
				</div>
				<?php } else { echo ""; } } ?>
			</div>
		</form>
	</div>

	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-right">
				<h1 style="font-size: 30px; font-weight: 900; color: #6f7d5d;">Gostava de editar o seu perfil?</h1>
				<p style="color: white; font-size: 20px; padding-top: 20px;">Clique aqui</p>
				<a href="?pg=8" tyle="margin-top: 20px;" class="button ghost" id="signUp">Editar</a>
			</div>
		</div>
	</div>
</div>

	<div id="myModal" class="modal">
		<form action="?pg=7" method="post">
		<!-- Modal content -->
		<div class="modal-content">
			<span style="text-align: right; " class="close">&times;</span>
			<div>
			<h5 style="padding-top: 10px;"><strong>Imagem</strong> - Atualize aqui a sua imagem</h5>
			</div>
			<div style="width: 96%; height: 200px; margin: 10px; padding-top: 10px;">
				<button type="button" class="butao-modal" id="myBtn2"><img src="img/upload.png" style="width: 16px; height: 16px; margin-top: -10px;"><p style="color: #6f7d5d;">Nova Imagem</p></button>
			</div>
			<div style="width: 96%;  height: 200px; margin: 10px;">
				<?php if($ln_perfil['foto']==""){?>
				<button type="button" class="butao-modal" id="myBtn3" disabled><img src="img/edit.png" style=" width: 16px; height: 16px; margin-top: -10px;"><p style="color: #6f7d5d;">Editar imagem (Sem imagem para editar)</p></button>
				<?php } else { ?>
				<button type="button" class="butao-modal" id="myBtn3" ><img src="img/edit.png" style=" width: 16px; height: 16px; margin-top: -10px;"><p style="color: #6f7d5d;">Editar imagem</p></button>
				<?php } ?>
			</div>
			<?php $sql_perfil=$conn->query("select foto from utilizadores where idutilizador='".$_SESSION['idutilizador']."'")or die("Erro ao selecionar o nome.");
			$ln_perfil=$sql_perfil->fetch_assoc(); ?>
			<button type="button" id="butao-modal" class="butao-modal2" >Cancelar</button>
			<?php if($ln_perfil['foto']!=""){ ?>
			<button type="submit" name="delete" value="Delete" style="width: 130px; float: right; background: #ff4d4d; margin-left: 90px; margin-top: -26px;" class="butao-modal50">Remover Foto</button>
			<?php } ?>
		</div>
		<form>
	</div>

	<div id="myModal2" class="modal2">

		<!-- Modal content -->
		<div class="modal-content" >
			<span style="text-align: right;" class="close2">&times;</span>
			<div>
			<h5><strong>Imagem</strong> - Adicione uma nova imagem</h5>
			</div>
			<form action="?pg=7" method="post" enctype="multipart/form-data">
			<div  style="margin-left: auto; margin-right: auto; padding-top: 70px;" >
					<div id="upload-demo" style="margin-left: auto; margin-right: auto; width:350px;">
					<button style="background: rgb(0, 0, 0, 0); border: 0px; position: absolute; left: 35px; top: 360px;" type="button" id="rotateLeft2" data-rotate="-90"><img src="img/rotateL.png"></button>
					<button style="background: rgb(0, 0, 0, 0); border: 0px; position: absolute; left: 360px; top: 360px;" type="button" id="rotateRight2" data-rotate="90"><img src="img/rotateR.png"></button>
					</div>
			</div>
			<div  style="padding-top:25px;">
				<strong>Selecione uma imagem:</strong>
				<br/>
				<input type="file" id="upload" name="foto" accept="image/*"  style="padding-top:10px;">
			</div>

			<div style="margin-top: 22px;">
				<button type="submit"  class="butao-modal2 upload-result" style="float: left;">Enviar</button>
				<button type="button" id="butao-modal2" class="butao-modal2" style="margin-left: 7px; background: #000;">Cancelar</button>
			</div>
			</form>
		</div>

	</div>

	<div id="myModal3" class="modal3">

		<!-- Modal content -->
		<div class="modal-content" >
			<span style="text-align: right;" class="close3">&times;</span>
			<div>
			<h5><strong>Imagem</strong> - Edite a sua imagem</h5>
			</div>
			<div style="margin-top: 40px;" class="demo-basic" >

			<button style="background: rgb(0, 0, 0, 0); border: 0px; position: absolute; left: 35px; top: 330px;" type="button" id="rotateLeft" data-rotate="-90"><img src="img/rotateL.png"></button>
			<button style="background: rgb(0, 0, 0, 0); border: 0px; position: absolute; left: 360px; top: 330px;" type="button" id="rotateRight" data-rotate="90"><img src="img/rotateR.png"></button>

			</div>		

			<div>
				<button type="button" name="enviar" value="Enviar" class="butao-modal2 upload-result2" style="float: left; ">Editar</button>
				<button type="button" id="butao-modal3" class="butao-modal2" style="margin-left: 7px; background: #000;">Cancelar</button>
			</div>
		</div>

	</div>

<div style="padding-bottom: 70px;"></div>

<!-- partial -->
<!-- <script  src="script2.js"></script> -->

<script type="text/javascript">

$uploadCrop = $('#upload-demo').croppie( {
	enableOrientation: true,
    viewport: {
        width: 120,
        height: 120,
        type: 'square'
    },
    boundary: {
        width: 200,
        height: 200,
    }
	
});

$('#upload').on('change', function () { 
	var reader = new FileReader();
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
			url: e.target.result,
			orientation: 1
    	}).then(function(){
    		console.log('jQuery bind complete');
    	});
    	
    }
    reader.readAsDataURL(this.files[0]);
});


$('.upload-result').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: { width: 200, height: 200 }
	}).then(function (resp) {
		var file_input = $('#upload').val();
		$.ajax({
			url: "foto.php",
			type: "POST",
			data: {"image":resp, "file":file_input},
			success: function (data) {
				window.location.reload(true); 
			}
		});
	});
});



</script>

<script type="text/javascript">


$basic = $('.modal-content .demo-basic').croppie({
	enableOrientation: true,
    viewport: {
        width: 120,
        height: 120,
		type: 'square'
    },
	boundary: {
        width: 200,
        height: 200,
    }
});

$basic.croppie('bind', {
	url: 'img/perfis/<?php echo $ln_perfil['foto'];?>',
	orientation: 1,
	
}).then(function($basic){
	$('.cr-slider').attr({'min':0.5910, 'max':1.5000});
});

$('.upload-result2').on('click', function (ev) {
	$basic.croppie('result', {
		type: 'canvas',
		size: { width: 200, height: 200 }
	}).then(function (resp) {
		$.ajax({
			url: "foto2.php",
			type: "POST",
			data: {"image":resp},
			success: function (data) {
				window.location.reload(true); 
			}
		});
	});
});


</script>
