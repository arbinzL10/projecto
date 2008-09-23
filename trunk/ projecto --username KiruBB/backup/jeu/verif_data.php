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
					$sql="select path from map where joueur_id=".$_SESSION['identify']['id'];
					$req=mysql_query($sql);
					$data=mysql_fetch_assoc($req);
					$_SESSION['map']['path']=$data['path'];
					echo "insertBalisesById('b_menu','connecté');";	
					echo "redirect('index.php');";				
			}
		}
		else{
			echo "insertBalisesById('b_menu','pass ou pseudo incorrect(s)');";
		}
	}
?>