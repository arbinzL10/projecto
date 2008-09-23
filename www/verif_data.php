 <?php
 	@session_start();
	include 'basic_functions.php';
     if(!empty($_POST['pseudo']))
     {
         connect('jeu','localhost','root','');		 
		$sql='SELECT id FROM joueurs WHERE pseudo=\''.$_POST['pseudo'].'\'';
          $req = mysql_query($sql);
		  if($req){
			  if (mysql_numrows($req) > 0) {
				   echo stripslashes(htmlentities('pseudo déjà utilisé'));
			  }
		  }
     }
	  if(!empty($_POST['royaume_name']))
     {
         connect('jeu','localhost','root','');		 
		$sql='SELECT id FROM map WHERE name=\''.$_POST['royaume_name'].'\'';
          $req = mysql_query($sql);
		  if($req){
			  if (mysql_numrows($req) > 0) {
				   echo stripslashes(htmlentities('nom de royaume déjà utilisé'));
			  }
		  }
     }
	 if(!empty($_POST['email']))
     {
        $adresse=htmlentities($_POST['email']);
		if(!VerifierAdresseMail($adresse)){
		  echo stripslashes('Votre adresse e-mail n\'est pas valide.');
		}
	}
	
	if(isset($_POST['register'])){
	
		if(isset($_POST['register'][0]) or isset($_POST['register'][1]) )
		{	
			if($_POST['register'][0]!=$_POST['register'][1]){
			  echo htmlentities('pass diférents');
			}
			else{
				if(isset($_POST['register'][2]))
				{	
					connect('jeu','localhost','root','');		 
					$sql='SELECT id FROM joueurs WHERE pseudo=\''.$_POST['register'][2].'\'';
					  $req = mysql_query($sql);
					  if($req){
						  if (mysql_numrows($req) > 0) {
							   echo stripslashes(htmlentities('pseudo invalide'));
						  }
						  else{
								if(isset($_POST['register'][3]))
								{	
									$adresse=htmlentities($_POST['register'][3]);
									if(!VerifierAdresseMail($adresse)){
										echo stripslashes('Votre adresse e-mail n\'est pas valide.');
									}
									else{
										if(isset($_POST['register'][4]))
										{
											connect('jeu','localhost','root','');		 
											$sql='SELECT id FROM map WHERE name=\''.$_POST['register'][4].'\'';
											$req = mysql_query($sql);
											if($req){
												if (mysql_numrows($req) > 0) {
													echo stripslashes(htmlentities('nom de royaume déjà utilisé'));
												}
												else
												{
												
													$sql="INSERT INTO joueurs (pseudo,pass,mail) VALUES ('".$_POST['register'][2]."','".md5($_POST['register'][0])."','".$_POST['register'][3]."')";
													$req=mysql_query($sql) or die(mysql_error());
													if($req){
														echo "<br />";
														echo htmlentities('enregistrer avec succés');
														include 'map.php';
														createMap();
														echo "<br />";
														echo htmlentities('map créé avec succés');
													}
												}
											}
										}
									}
								
								}
						  
						  }
					  }
			
				}
				
			
			}
	
		}
	
	}
	
	if(isset($_POST['log_in'][0]) or isset($_POST['log_in'][1]) )
	{	
		connect('jeu','localhost','root','');
		$sql='SELECT id,pass FROM joueurs WHERE pseudo=\''.$_POST['log_in'][0].'\'';
		$req=mysql_query($sql);
		$data=mysql_fetch_assoc($req);
		if(mysql_numrows($req) > 0){
			if($data['pass']==md5($_POST['log_in'][1])){
					$_SESSION['identify']['id']=$data['id'];
					$_SESSION['identify']['pseudo']=$_POST['log_in'][0];
					$sql="select path from map where joueur_id=".$_SESSION['identify']['id'];
					$req=mysql_query($sql);
					$data=mysql_fetch_assoc($req);
					$_SESSION['map']['path']=$data['path'];
					echo "redirect('index.php');";
					
					
										//echo utf8_encode("insertBalisesById('menu','<div class=\"item\" onclick=\"loadPage(\"menuD.php\",\"menu\")\">Generaux</div>');");
					/*echo  utf8_encode('insertBalisesById("menuChateau","<div id=\"chateau1\" class=\"chateau\" onclick=\"loadPage(\"incastle.php\",\"entre2menu\")\"></div><div id=\"chateau2\" class=\"chateau\" onclick=\"loadPage(\"incastle2.php\",\"entre2menu\")\"></div><div id=\"chateau3\" class=\"chateau\" onclick=\"loadPage(\"incastle3.php\",\"entre2menu\")\"></div><div id=\"chateau4\" class=\"chateau\" onclick=\"loadPage(\"incastle4.php\",\"entre2menu\")\"></div><div id=\"chateau5\" class=\"chateau\" onclick=\"loadPage(\"incastle5.php\",\"entre2menu\")\"></div><div id=\"chateau6\" class=\"chateau\" onclick=\"loadPage(\"incastle6.php\",\"entre2menu\")\"></div><div id=\"nextChateau\" class=\"next\" onclick=\"loadPage(\"suivant.php\",\"menuG\")\"></div>");');
					echo utf8_decode('insertBalisesById("menuHero","<div id=\"hero1\" class=\"hero\" onclick=\"loadPage(\"hero1.php\",\"entre2menu\")\"></div><div id=\"hero2\" class=\"hero\" onclick=\"loadPage(\"hero2.php\",\"entre2menu\")\"></div><div id=\"hero3\" class=\"hero\" onclick=\"loadPage(\"hero3.php\",\"entre2menu\")\"></div><div id=\"hero4\" class=\"hero\" onclick=\"loadPage(\"hero4.php\",\"entre2menu\")\"></div><div id=\"hero5\" class=\"hero\" onclick=\"loadPage(\"hero5.php\",\"entre2menu\")\"></div><div id=\"hero6\" class=\"hero\" onclick=\"loadPage(\"hero6.php\",\"entre2menu\")\"></div><div class=\"next\" onclick=\"loadPage(\"suivant.php\",\"menuG\")\"></div>");');
					echo 'insertBalisesById("contenu","include \"menuG.php\"");';
					echo 'loadPage("menuD.php","contenu");';*/
			}
		}
		else{
			echo "insertBalisesById('main','pass ou pseudo incorrect(s)');";
		}
	}
?>
