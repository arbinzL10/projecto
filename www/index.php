<?php	session_start(); 
include 'scripts.js';
include ("basic_functions.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style2.css">
	</head>
	<body id="fond" bgcolor="#BDA984">
	<div id="global">
		<div id="top_left" class="deco_top"><img src="images/deco_top_left.png"></div>

		<!-------------------------------------------------------------------->
		<!------------------------ haut de page------------------------------->
		<div id="top"><!-- entete -->
			<div id="top_right" class="deco_top"><img src="images/deco_top_right.png"></div>
		</div>
		<!---------------------------------------------------------------------->
		<!------------------------ milieu de page------------------------------->
		<div id="middle"> <!-- menu + corps -->
			<?php
				include 'content.php';
			?>
		</div>
		<!------------------------------------------------------------------->
		<!------------------------ bas de page------------------------------->
		<div id="frise"><img src="images/horizontal_border.png"></div>
		<div id="bottom"><!-- pied de page -->
			
		</div>
			
	</div>
	 
	</body>
</html>