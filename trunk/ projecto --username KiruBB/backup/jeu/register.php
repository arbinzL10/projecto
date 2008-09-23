<div id="centre">
 <body>
	<fieldset>
    <legend>Infos obligatoires</legend>
         <table>
			 <tr><td> Pseudo :</td><td><input id="pseudo" type="text" name="pseudo" onKeyUp="verifData('pseudo','l_pseudo','pseudo')" value=<?php echo '"'.$_POST['register'][0].'"';?>/></td><td><label id="l_pseudo"></label></td></tr>
			
			<tr><td> Mot de passe :</td><td><input onKeyUp="HTTPReq(new Array('register[0]','register[1]'),new Array('id=pass1','id=pass2'),'verif_data.php','l_password')" id="pass1" type="password" name="password1" value=<?php echo $_POST['register'][1] ;?> /></td></tr><td><label id="l_password"></label></td></tr>
	
			<tr><td>Confirmer mot de passe :</td><td><input onKeyUp="HTTPReq(new Array('register[0]','register[1]'),new Array('id=pass1','id=pass2'),'verif_data.php','l_password')" id="pass2"  type="password" name="password2" value=<?php echo $_POST['register'][1] ;?> /></td><td><label id="l_pass"></label></td></tr>
	
			<tr><td> e_Mail :</td><td><input id="email" onKeyUp="verifData('email','l_email','email')" type="text" name="mail" size="15"/></td><td><label id="l_email"></label></td></tr>
			
			<tr><td> Nom du royaume :</td><td><input id="royaume_name" type="text" name="royaume_name" onKeyUp="verifData('royaume_name','l_name','royaume_name')"/></td><td><label id="l_name"></label></td></tr>
			<tr><td><label id="l_verif"></label></td><td>

		</table>
	</fieldset>
	<div id="register_submit" onClick="HTTPReq(new Array('register[0]','register[1]','register[2]','register[3]','register[4]'),new Array('id=pass1','id=pass2','id=pseudo','id=email','id=royaume_name'),'verif_data.php','l_verif')"><label>s'enregistrer</label></div>	 
	</div>
</body>
