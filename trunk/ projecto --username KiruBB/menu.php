<!--______________________________________________________________________________________________-->
<!-- 						MENU A INCLURE DANS CONTENT.PHP 									  -->
<!--______________________________________________________________________________________________-->

<?php @session_start();?>
<SCRIPT language="JavaScript">InitBulle("navy","#FFCC66","orange",1);
// InitBulle(couleur de texte, couleur de fond, couleur de contour taille contour)
</SCRIPT>
<div id="menu" >
	<?php 
	if(!isIdentified()){
	?>		
		<div class="log">
			<input id="login" name="login" value="login" type="text" >
			<input id="pass" name="pass" value="********" type="password" >
			<div id="log_in" onclick="HTTPReq(new Array('log_in[0]','log_in[1]'),new Array('id=login','id=pass'),'verif_data.php','<java>')" >
				<img src="images/valider.png" onmouseover="AffBulle('cliquez pour vous connecter')" onmouseout="HideBulle()"  onclick="HTTPReq(new Array('log_in[0]','log_in[1]'),new Array('id=login','id=pass'),'verif_data.php','<java>')" />
			</div>
			<div id="register">
				<img src="images/register.png" onmouseover="AffBulle('cliquez pour vous enregistrer')" onmouseout="HideBulle()" onclick="HTTPReq(new Array('register[0]','register[1]'),new Array('id=login','id=pass'),'register.php','main')" />
			</div>	 
		</div>
		<div class="item">
				<img name="button_accueil" style="margin-top:10%;" src="images/button_accueil.png" onmouseover="AffBulle('accueil')" onmouseout="HideBulle()" onclick="loadPage('accueil.php','main')" onMouseOver="document.button_accueil.src='images/button_accueil_clicked.png';" onMouseOut="document.button_accueil.src='images/button_accueil.png';">
			</div>
			<div class="item" >				
				<img name="button_forum" style="margin-top:10%;" src="images/button_forum.png" onmouseover="AffBulle('forum')" onmouseout="HideBulle()" onclick="loadPage('forum.php','main')" onMouseOver="document.button_forum.src='images/button_forum_clicked.png';"onMouseOut="document.button_forum.src='images/button_forum.png';">
			</div>
			<div class="item" >				
				<img name="button_contact" style="margin-top:10%;" src="images/button_contact.png" onmouseover="AffBulle('contact')" onmouseout="HideBulle()" onclick="loadPage('contact.php','main')" onMouseOver="document.button_contact.src='images/button_contact_clicked.png';" onMouseOut="document.button_contact.src='images/button_contact.png';">
			</div>
	<?php
	}
	else
	{?>						
			<div id="menu_logged"><br />
				<label class="message_logged"><?php echo $_SESSION['identify']['pseudo'];?></label>
				<div id="deconnexion" >
				<img src="images/deco.png" onmouseover="AffBulle('cliquez pour vous déconnecter')" onmouseout="HideBulle()" onclick="HTTPReq('deconnexion',null,'deconnexion.php','<java>')" />
				</div>
			</div>
			<div class="item">
				<img name="button_generaux" style="margin-top:10%;" src="images/button_generaux.png" onclick="addSideMenu('menuD.php','main','menuHero')" onMouseOver="document.button_generaux.src='images/button_generaux_clicked.png';" onMouseOut="document.button_generaux.src='images/button_generaux.png';">
			</div>
			<div class="item" >				
				<img name="button_map" style="margin-top:10%;" src="images/button_map.png" onclick="HTTPReq(new Array('type_map'),new Array('map_joueur'),'aff_map.php','main')" onMouseOver="document.button_map.src='images/button_map_clicked.png';"onMouseOut="document.button_map.src='images/button_map.png';">
			</div>
			<div class="item" >				
				<img name="button_registre" style="margin-top:10%;" src="images/button_registre.png" onclick="loadPage('journal.php','main')" onMouseOver="document.button_registre.src='images/button_registre_clicked.png';" onMouseOut="document.button_registre.src='images/button_registre.png';">
			</div>
			<div id="chateau_item" class="item"   >
				<img name="button_chateau" style="margin-top:10%;" src="images/button_chateaux.png" onMouseOver="document.button_chateau.src='images/button_chateaux_clicked.png';" onMouseOut="document.button_chateau.src='images/button_chateaux.png';" onclick="addSideMenu('menuG.php','main','menuChateau')" />
			</div>
			
			<script language="javascript">
			insertBalisesById('ressources','<div id="ressources"><div class="item"> Or : xxx (x/jour)</div><div class="item"> Pierre : xxx (x/jour)</div><div class="item"> Bois : xxx (x/jour)</div><div class="item"> gemmes : xxx (x/jour)</div><div class="item"> cristaux : xxx (x/jour)</div><div class="item"> souffre : xxx (x/jour)</div></div>');
			</script>

	<?php 
	}
	?>
</div>