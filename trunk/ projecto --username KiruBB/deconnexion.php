<?php

session_start();
if(isset($_POST['deconnexion'])){
	// Détruit toutes les variables de session
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
echo "redirect('index.php');";
}
?>
