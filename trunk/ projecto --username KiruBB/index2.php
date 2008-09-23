<?php	session_start(); 
include 'scripts.js';	
include ("scripts.js");	
?>
<HTML>
<HEAD>
<link href="style.css" rel="stylesheet" type="text/css">  
<TITLE>Design</TITLE>
</HEAD>

<BODY bgcolor=black>

<div id="global">
	<div id="entete">
	</div>
		
	<div id="menu">
		<div id="journal" onclick="loadPage('journal.php','main')">Journal</div>
 		<div id="ressources">
			<div id="ressource1"> Or : xxx (x/jour)</div>
			<div id="ressource2"> Pierre : xxx (x/jour)</div>
			<div id="ressource3"> Bois : xxx (x/jour)</div>
			<div id="ressource4"> gemmes : xxx (x/jour)</div>
			<div id="ressource5"> cristaux : xxx (x/jour)</div>
			<div id="ressource6"> souffre : xxx (x/jour)</div>  
		</div>

		<div id="log">
			<div id = "pseudobox">
				<INPUT type="text" name="pouet"><br><br><INPUT type="text" name="pass">
			</div>
		</div> 
	</div>
	<div id="corps">
		<div id="menuG">
			<div id="chateau1" onclick="loadPage('incastle.php','main')"></div>
			<div id="chateau2" onclick="loadPage('incastle2.php','main')"></div>
			<div id="chateau3" onclick="loadPage('incastle3.php','main')"></div>
			<div id="chateau4" onclick="loadPage('incastle4.php','main')"></div>
			<div id="chateau5" onclick="loadPage('incastle5.php','main')"></div>
			<div id="chateau6" onclick="loadPage('incastle6.php','main')"></div>
			<div id="next" onclick="loadPage('suivant.php','menuG')"></div>
		</div>
		<div id="main"><br><br><br><br>
			fenetre dans laquelle <br><br>apparaitra la map, les messages,<br><br> les batiments d'un chateau, <br><br>les évolutions accessibles ou non.
		</div>
		<div id="menuD">
			<div id="hero1" onclick="loadPage('hero1.php','main')"></div>
			<div id="hero2" onclick="loadPage('hero2.php','main')"></div>
			<div id="hero3" onclick="loadPage('hero3.php','main')"></div>
			<div id="hero4" onclick="loadPage('hero4.php','main')"></div>
			<div id="hero5" onclick="loadPage('hero5.php','main')"></div>
			<div id="hero6" onclick="loadPage('hero6.php','main')"></div>
			<div id="next" onclick="loadPage('suivant.php','menuG')"></div>
		</div>
	</div>
</div>
</BODY>
</HTML>