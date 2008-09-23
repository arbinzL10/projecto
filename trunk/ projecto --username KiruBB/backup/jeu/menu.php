<!--______________________________________________________________________________________________-->
<!-- 						MENU A INCLURE DANS CONTENT.PHP 									  -->
<!--______________________________________________________________________________________________-->

<?php	
include 'basic_functions.php';
?>
<div id="menu" >
	<?php 
	if(!isIdentified()){
	?>
		<div id="menu_connection">
				<input id="login" name="login" value="login" type="text" >
				<div id="login" onclick="HTTPReq(new Array('log_in[0]','log_in[1]'),new Array('id=login','id=pass'),'verif_data.php','<java>')">
					<label>se connecter</label>
				</div>
				<input id="pass" name="pass" value="********" type="password" >
				<div id="register" onclick="HTTPReq(new Array('register[0]','register[1]'),new Array('id=login','id=pass'),'register.php','b_menu')">
					<label>s'enregistrer</label>
				</div>	 
		</div>
	<?php
	}
	else{
		
	?>
		<div id="menu_jeu">
			<div id="social">
				<label onMouseOver="menu('social')">social</label>
			</div>
	
			<div id="cité">
				<label onMouseOver="menu('cité')">cité</label>
			</div>
	
			<div id="map" onClick="HTTPReq('map_joueur',null,'aff_map.php','b_menu')">
				<label>map</label>
			</div>
		</div>
	<?php
	}
	?>
</div>
