<?php 

session_start();

// Détruit toutes les variables de session
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	echo "redirect('index.php');";

?>
