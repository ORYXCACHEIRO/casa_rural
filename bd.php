<?php
	require 'vendor\autoload.php';

	//-------------------------------Paypal---------------------------------//

	use PayPalCheckoutSdk\Core\PayPalHttpClient;
	use PayPalCheckoutSdk\Core\SandboxEnvironment;
	// Creating an environment
	$clientId = "AaitJOdHylLDUChzMBwuzUcgoNz00Kdp6JWFirD5zwP3sZcpAJ-XXoNyFFdAyvlrWhErpOBEktWQWY4l";
	$clientSecret = "EJYDrZ7HbBO-YYhq6Ka-jPOucZ_oL3oXi5TjyRlalVjF-zKwmoor4RTHoAWEq9ExJDhCe29PiTAoHRx_";

	$environment = new SandboxEnvironment($clientId, $clientSecret);
	$client = new PayPalHttpClient($environment);
	 // 1- Client_id
	 // 2 - Secret
	$apiContext = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
		  'AaitJOdHylLDUChzMBwuzUcgoNz00Kdp6JWFirD5zwP3sZcpAJ-XXoNyFFdAyvlrWhErpOBEktWQWY4l',
		  'EJYDrZ7HbBO-YYhq6Ka-jPOucZ_oL3oXi5TjyRlalVjF-zKwmoor4RTHoAWEq9ExJDhCe29PiTAoHRx_'
		)
	  );
	  

	//-------------------------------Google-Login---------------------------------//

	$google_client = new Google_Client();

	//Set the OAuth 2.0 Client ID
	$google_client->setClientId('968653830993-anh01a29ft9fk5kdhbdrka3j8scdjbit.apps.googleusercontent.com');

	//Set the OAuth 2.0 Client Secret key
	$google_client->setClientSecret('d3r98zd4c1MOkNODOElp24CR');

	//----------------------------------------------------------------------//

	$conn = new mysqli('localhost', 'root', '', 'casa',0, '/var/lib/mysql/mysql.sock');
	
	$error="";
	
	if($conn->connect_error){
		die("Connection failed: " .$conn->connect_error);
		exit();
	}

?>