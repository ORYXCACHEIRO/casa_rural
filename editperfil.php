<?php

if(!isset($_SESSION) || $_SESSION['nome']=="" || $_SESSION['tipo']!=0){
	 echo "<meta http-equiv=refresh content='0; url=index.php?m=3'>"; exit;
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

$mail = new PHPMailer(TRUE);

if(isset($_POST['enviar']) && $_POST['enviar']=="Enviar"){
				
	if(isset($_POST['nome'])) { $nome=Addslashes($_POST['nome']); } else { $nome=""; }
	if(isset($_POST['email'])) { $email=Addslashes($_POST['email']); } else { $email=""; }
	if(isset($_POST['data'])) { $data=Addslashes($_POST['data']); } else { $data="0000-00-00"; }
	if(isset($_POST['pais'])) { $pais=(int)$_POST['pais']; } else { $pais = 0; }
	if(isset($_POST['predix'])) { $prefix=(int)$_POST['prefix']; } else { $prefix = 0; }
	if(isset($_POST['telemovel'])){ $tele=$_POST['telemovel']; } else { $tele = ""; }
	$id = $_SESSION["idutilizador"];
	$prefixx = "";
	$verificado = 1;


	if(empty(trim($_POST['nome'])) || empty(trim($_POST['email'])) || isset($_POST['telemovel']) && !is_numeric(str_replace(" ", "", $_POST['telemovel']))){
		echo "<meta http-equiv=refresh content='0; url=?pg=8&z=5'>";exit;
	} else{	

		

		if($prefix=="7000" || $prefix==""){
				
		} else {
		$sql_perfil3=$conn->query("select * from pais where idpais='".$prefix."'")or die("Erro ao selecionar o nome.");
		if($sql_perfil3->num_rows>=1){
			$ln_perfil3=$sql_perfil3->fetch_assoc();
			$prefixx=$ln_perfil3['telemovel'];
		} else {
			$prefixx = "";
			$tele = "";
		}

		}

		if(empty(trim($_POST['data']))){
			$data = "0000-00-00";
		}

		if($pais=="0" || $pais==""){
			$pais = 0;
		} else { 

		$sql_perfil6=$conn->query("select idpais from pais where idpais='".$pais."'")or die("Erro ao selecionar o nome.");
		if($sql_perfil6->num_rows>=1){
			$ln_perfil6=$sql_perfil6->fetch_assoc();
			$pais=$ln_perfil6['idpais'];
		} else {
			$pais = 0;
		}

		}

		$veri5=$conn->prepare("select email from utilizadores where idutilizador= ?") or die ("erro2");

		$veri5->bind_param("i", $id);

		$veri5->execute();

		$veri5->store_result();

		$veri5->bind_result($email2);

		$veri5->fetch();

		if($email!=$email2){
			$verificado = 0;
		} else $verificado = 1;

		$sql_perfil3=$conn->query("select email from utilizadores where email='".$email."' and idutilizador <>'".$id."' ")or die("Erro ao selecionar o nome.");

		if($sql_perfil3->num_rows>=1){
			echo "<meta http-equiv=refresh content='0; url=?pg=8&z=7'>";exit;
		} else {

		$sql_perfil4=$conn->query("select email from utilizadores_block where email='".$email."'")or die("Erro ao selecionar o nome.");

		if($sql_perfil4->num_rows>=1){
			echo "<meta http-equiv=refresh content='0; url=?pg=8&z=10'>";exit;
		} else {

		$veri6=$conn->prepare("select idutilizador from reservas where idutilizador= ?") or die ("erro2");

		$veri6->bind_param("i", $id);

		$veri6->execute();

		$veri6->store_result();

		$veri6->bind_result($idutil);

		if($veri6->num_rows>=1){
			
			$veri6->fetch();

			$sql_perfil2=$conn->prepare("update reservas set nome_final=?, email_final=? where idutilizador=?") or die("Falha ao editar o pefil");
		
			$sql_perfil2->bind_param("ssi", $nome,  $email, $id);

			$sql_perfil2->execute();

		}

		$veri6->close();

		//edita o texto do quemsomos da loja 1
		$sql_perfil=$conn->prepare("update utilizadores set nome=?, email=?, data=?, idpais=?, telemovel=?, prefix=?, verificado=? where idutilizador=?") or die("Falha ao editar o pefil");
		
		$sql_perfil->bind_param("sssissii", $nome,  $email, $data, $pais, $tele, $prefixx, $verificado, $id);

		$sql_perfil->execute();

		//se correu bem redireciona com a mensagem de sucesso m=1
		if($sql_perfil->error){
			echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1>";exit;
		}		
		else{

			if($verificado==0){

				$email = filter_var($email, FILTER_SANITIZE_EMAIL);
				$email = filter_var($email, FILTER_VALIDATE_EMAIL);
				if (!$email) {
				$error .= '"<meta http-equiv=refresh content="0; url=?pg=8&erro=1">";exit';
				}
				else{
				$sel_query = "SELECT * FROM `utilizadores` WHERE email='".$email."'";
				$results = mysqli_query($conn, $sel_query);
				$row = mysqli_num_rows($results);
				if ($row==""){
				$error .= '"<meta http-equiv=refresh content="0; url=?pg=8&erro=1">";exit';
				}
				}
				if($error!=""){
					echo "<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
				}
				else{
				$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
				$expDate = date("Y-m-d H:i:sa",$expFormat);
				$key = md5(2418*2 . $email);
				$addKey = substr(md5(uniqid(rand(),1)),3,10);
				$key = $key.$addKey;

				$sql_cont=$conn->query("select * from contactos")or die("Erro ao selecionar o nome.");
				$rowc = $sql_cont->fetch_assoc();

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
				<p style="font-size: 28px; line-height: 2; text-align: center; word-break: break-word; font-family: Cormorant Garamond, Times New Roman, Times, serif; mso-line-height-alt: 56px; margin: 0;"><span style="font-size: 28px; "><strong><span style="font-size: 28px;">Verificação de email</span></strong></span></p>
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
			
			$_SESSION['nome']=$nome;
			$_SESSION['email']=$email;
			//se correu mal redireciona com a mensagem de erro m=2
			echo "<meta http-equiv=refresh content='0; url=?pg=7&m=3'>";exit;
		}
		
		$sql_perfil->close();
		$veri5->close();
		}
		}
	}
}

if(isset($_POST['enviar']) && $_POST['enviar']=="Editar"){
	
	if(isset($_POST['password_at'])) { $password_ant=preg_replace('/\s+/', '', $_POST['password_at']); } else { $password_ant=""; }
	if(isset($_POST['password1'])) { $password1=preg_replace('/\s+/', '', $_POST['password1']); } else { $password1=""; }
	if(isset($_POST['password2'])) { $password2=preg_replace('/\s+/', '', $_POST['password2']); } else { $password2=""; }

	$sql_perfil3=$conn->prepare("select password from utilizadores where idutilizador=?")or die("Erro ao selecionar o nome.");

	$sql_perfil3->bind_param("i", $_SESSION['idutilizador']);

	$sql_perfil3->execute();

	$sql_perfil3->store_result();

	$sql_perfil3->bind_result($pass);

	$sql_perfil3->fetch();
	
	if(password_verify($password_ant, $pass)==0 || $password1!=$password2 || empty(trim($_POST['password1'])) || empty(trim($_POST['password2']))){
	echo"<meta http-equiv=refresh content='0; url=?pg=8&z=1'>";exit;
	} 
	else if($password1==$password2){

	$hash = password_hash($password2, PASSWORD_DEFAULT);
	
	$sql_uti=$conn->prepare("update utilizadores set password=? where idutilizador=?");

	$sql_uti->bind_param("si", $hash, $_SESSION['idutilizador']);

	$sql_uti->execute();
	
	if($sql_uti->error){  
		$sql_perfil3->close();
	echo"<meta http-equiv=refresh content='0; url=?pg=8&erro=1'>";exit;
	} 
	else {
		$sql_perfil3->close();
		echo"<meta http-equiv=refresh content='0; url=?pg=8&m=2'>";exit;
	}
	}
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
	<?php $id = $_SESSION['idutilizador']; ?>
	<div class="form form-container sign-up-container">
		<form action="?pg=8" method="post">
			<h1 style="font-size: 30px; font-weight: 900; color: black;">Password</h1>
			<div class="social-container">
				<span style="font-size: 15px; font-weight: 900; color: black">Edite aqui a sua password</span></br>
			</div>
			<div>
				<div>
					<label style="float: left;">Password Atual</label>
					<input class="input" type="password" placeholder="Password Atual" name="password_at" required="required"/>
				</div>
				<div>
					<label style="float: left;">Nova Password</label>
					<input class="input" type="password" placeholder="Nova Password" name="password1" required="required"/>
				</div>
				<div>
					<label style="float: left;">Repeita a nova password</label>
					<input class="input" type="password" placeholder="Repita a nova passoword" name="password2" required="required"/>
				</div>
			</div>
            <button type="submit" class="button" name="enviar" value="Editar" style="margin-top: 15px;">Editar</button>
            <div style="padding-top: 30px;">
				<p>Clique <a href="?pg=7" style="color: #6f7d5d; ">aqui</a> para a voltar ao perfil<p>
			</div>
		</form>
	</div>
	<div class=" form form-container sign-in-container">
		<form action="?pg=8" method="post">
			<h1 style="font-size: 30px; font-weight: 900; color: black;">Perfil</h1>
			<div class="social-container">
				<span style="font-size: 15px; font-weight: 900; color: black">Aqui pode editar todas as suas informações básicas</span></br>
			</div>
			<div>
			<?php 

			$id = $_SESSION['idutilizador'];

			$veri3=$conn->prepare("select nome, email, data, idpais, prefix, telemovel, google_account from utilizadores where idutilizador=?") or die ("erro");

			$veri3->bind_param("i", $id);
			
			$veri3->execute();

			$veri3->store_result();

			$veri3->bind_result($nome, $email, $data, $idpais2, $prefixo, $telemovel, $google);

			if($veri3->num_rows>=1){ 

			$veri3->fetch(); 
			?>

				<div>
					<label style="float: left;">Nome *</label>
					<input class="input" type="text" placeholder="Nome" name="nome" value="<?php echo $nome;?>" required="required"/>
				</div>
				<div>
					<label style="float: left;">Email *</label>
					<input class="input" type="email" placeholder="Email" name="email" value="<?php echo $email;?>" required="required"/>
				</div>
				<div>
					<label style="float: left;">Data de Nascimento</label>
					<?php if($data!="0000-00-00"){ ?>
					<input class="input" type="date" name="data" value="<?php echo $data;?>"/>
					<?php } else { ?>
					<input class="input" type="date" name="data"/>
					<?php } ?>
				</div>
				<div>
					<label style="float: left;">País</label>
					<?php $sql_perfil3=$conn->query("select * from pais")or die("Erro ao selecionar o nomeeeeeee.");
						if($sql_perfil3->num_rows>=1){ ?>
							<select name="pais" class="select">
								<?php if($idpais2>0){

								$pais=$conn->prepare("select paisNome, idpais from pais where idpais=?") or die ("erro");

								$pais->bind_param("i", $idpais2);

								$pais->execute();

								$pais->store_result();

								$pais->bind_result($nomep, $idpais);

								$pais->fetch();

								?>
								<option value="" selected>Escolha um país</option>
								<option value="<?php echo $idpais;?>" selected><?php echo $nomep;?> (Selecionado)</option>
								<?php $pais->close(); }  else { ?>
								<option value="" selected>Escolha um país</option>
								<?php } ?>
								<?php while($ln_perfil3=$sql_perfil3->fetch_assoc()){ ?>
								<option value="<?php echo $ln_perfil3['idpais'];?>"><?php echo $ln_perfil3['paisNome'];?></option>
								<?php } ?>
							</select>
						<?php } ?>
				</div>
				<?php } $veri3->close(); ?>
				<div style="float:left;  position: relative;" >

					<div style=" ">
					<p style="text-align: left; font-size: 15.5px; color: black; font-weight: 400;">Telémovel</p>
					</div>

					<div  id="telemovell" style="width: 55%; float:right; ">
					<?php if($prefixo!=""){ ?>
					<?php $sql_perfil4=$conn->query("select * from pais where telemovel='".$prefixo."'")or die("Erro ao selecionar o nome."); $ln_perfil4=$sql_perfil4->fetch_assoc();?>
						<input class="input" type="text" data-mask="<?php echo $ln_perfil4['telemovel2']?>" style="height: 45px;" placeholder="00 000 0000" name="telemovel" value="<?php echo $telemovel;?>">
						<script>
						$('input[name="telemovel"]').mask('<?php echo $ln_perfil4['telemovel2']?>');

						$('input[name="telemovel"]').focusout(function(){
						$('input[name="telemovel"]').val( this.value.toUpperCase());
						});
						</script>
					<?php } else { ?>
						<input class="input" placeholder="Escolha um prefixo primeiro" style="height: 45px;" readonly>
					<?php } ?> 
					
					</div>

					<div style="width: 45%; float:left;">
					
					<?php $sql_perfil2=$conn->query("select * from pais")or die("Erro ao selecionar o nome.");
								if($sql_perfil2->num_rows>=1){ ?>
								<select  style="float: left;" name="prefix" id="codd" class="select3">
								<?php if($prefixo!=""){ $sql_perfil3=$conn->query("select * from pais where telemovel='".$prefixo."'")or die("Erro ao selecionar o nome."); $ln_perfil3=$sql_perfil3->fetch_assoc();?>
								<option value="7000" selected>Escolha um prefixo</option>
								<option value="<?php echo $ln_perfil3['idpais']?>" selected><?php echo $ln_perfil3['telemovel'];?> <?php echo $ln_perfil3['ISO'];?></option><?php } else { ?>
								<option value="7000" selected>Escolha um prefixo</option>
								<?php } ?>
								<?php while($ln_perfil2=$sql_perfil2->fetch_assoc()){ ?>
								<option  value="<?php echo $ln_perfil2['idpais'];?>"><?php echo $ln_perfil2['telemovel'];?> <?php echo $ln_perfil2['ISO'];?></option>
							<?php } ?>
								</select>
							<?php } ?>
					
					</div>
				</div>
			</div>
            <button type="submit" class="button" name="enviar" value="Enviar" style="margin-top: 15px;">Editar</button>
            <div style="padding-top: 30px;">
                <p>Clique <a href="?pg=7" style="color: #6f7d5d; ">aqui</a> para a voltar ao perfil<p>
			</div>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1 style="font-size: 30px; font-weight: 900; color: #6f7d5d;">Pretende só editar a sua conta?</h1>
				<p style="color: white; font-size: 20px; padding-top: 20px;">Então clique aqui</p>
				<button style="margin-top: 20px; " class="button ghost" id="signIn">Editar conta</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1 style="font-size: 30px; font-weight: 900; color: #6f7d5d;">Gostaria de editar a sua passoword?</h1>
				<p style="color: white; font-size: 20px; padding-top: 20px;">Clique aqui</p>
				<button style="margin-top: 20px;" class="button ghost" id="signUp">Editar password</button>
			</div>
		</div>
	</div>
</div>
<div style="padding-bottom: 70px;"></div>
<!-- partial -->
  <script  src="script2.js"></script>

<script type="text/javascript">

$(document).ready(function(){
    $('#codd').on('change', function(){
        var idpais = $(this).val();
        if(idpais){
            $.ajax({
                type:'post',
                url:'getId2.php',
                data:'idpais='+idpais,
                success:function(html){
                    $('#telemovell').html(html);
                }
            }); 
		}
    });
    
});

</script>

</body>
</html>
