<?php 

require_once "bd.php"; 

session_start();
$google_client->revokeToken();
session_destroy();

echo "<meta http-equiv=refresh content ='0; url=index.php'>";
?>