<?php


//#################################################################################################//
//								   		           FONCTIONS COURANTES										       //	
//#################################################################################################//
	
function connexion(){
	mysql_connect("localhost", "root", "");
	mysql_select_db("jeu");
}



//#################################################################################################//
//									           FONCTIONS UTILES  A L'ACHAT DE BATIMENTS								       //	
//#################################################################################################//

//=============================================       Fonction permettant d'obtenir la liste des  batiments constuctibles      ==================================================
function getListBat(){
	connexion();
	$req = "SELECT id,nom FROM batiments";
	$res = mysql_query($req);
	$i=0;
	while($data = mysql_fetch_assoc($res)){
		$bats[$i++]=$data;
	}	
	mysql_close();
	return $bats;
}	

//==================================================       Fonction permettant d'afficher la liste des bats      =======================================================
function affListBat($liste){
	echo "<select name=\"batiment\">";
	$i=-1;
	while($liste[++$i]['nom']!=NULL){
		echo "<option value=\"".$liste[$i]['id']."\">".$liste[$i]['nom'];
	}	
	echo "</select> <br>";
}

//=============================================================     fonction permettant de construire un batiment     ======================================================
function construire($idj, $idb, $nb,$x,$y){
	echo "id_joueur : ".$idj." <br>id_batiment : ".$idb."<br>";
	connexion();
	$nb = min($nb, getMaxBat($idj, $idb)); //calcul du max constructible
	$req = "SELECT nombre FROM possession_bat WHERE id_joueur='".$idj."' AND id_batiment='".$idb."'";
	$res = mysql_query($req);
	$old = mysql_fetch_assoc($res);
	$oldnb = (int)$old['nombre'];
	if ($oldnb==0){
		$newnb=$nb;
		$req2 = "INSERT INTO possession_bat (id_joueur , id_batiment ,nombre, x, y) VALUES('".$idj."' ,'".$idb."' ,'".$nb."','".$x."','".$y."')";
	}else{
		$newnb=$oldnb +$nb;
		$req2 = "UPDATE possession_bat SET nombre ='".$newnb."' WHERE id_joueur='".$idj."' AND id_batiment='".$idb."'";
	}
	payerBat($idj,$idb, $nb);
	echo "nb : ".$nb."<br>oldnb : ".$oldnb."<br>newnb : ".$newnb."<br>";
	
	$res2 = mysql_query($req2);
	mysql_close();
	//echo $req2;
}

//===================================================         fonction calculant le nombre max de batiment constructible        =================================================
function getMaxBat($idj, $idb){
	$ressources = array('cout_or', 'cout_bois', 'cout_pierre', 'cout_gemme', 'cout_cristaux', 'cout_souffre');
	$req = "SELECT cout_or, cout_bois, cout_pierre, cout_gemme, cout_cristaux, cout_souffre FROM batiments WHERE id='".$idb."'";
	$req2 = "SELECT ressources_id, nombre FROM possession_ressources WHERE joueur_id='".$idj."'";
	$res = mysql_query($req);
	$res2 = mysql_query($req2);
	$cout = mysql_fetch_assoc($res);
	$tabul=" &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ";  //pratique pour les espaces
	$max = 100000;
	$i=0;
	foreach ($ressources as $val){
		$poss = mysql_fetch_assoc($res2);
		if ($cout[$val]!=0){
			$max = min(floor($poss['nombre']/$cout[$val]), $max);
		}
		echo $val." : ".$cout[$val].$tabul." possede : ".(int)$poss['nombre'].$tabul."max : ".$max."<br>";
	}
	return $max;
	// echo "cout : ".$mmm['cout_or']."<br> ressource : ".$mmm2['ressources_id']."<br> possede : ".$mmm2['nombre'];	
}

//=================================================         fonction retirant les ressources dépensee lors de  l'achat des unités       ============================================
function payerBat($idj, $idb, $nb){
	$ressources = array('cout_or', 'cout_bois', 'cout_pierre', 'cout_gemme', 'cout_cristaux', 'cout_souffre');
	$req = "SELECT cout_or, cout_bois, cout_pierre, cout_gemme, cout_cristaux, cout_souffre FROM batiments WHERE id='".$idb."'";
	$req2 = "SELECT ressources_id, nombre FROM possession_ressources WHERE joueur_id='".$idj."'";
	$res = mysql_query($req);
	$res2 = mysql_query($req2);
	$cout = mysql_fetch_assoc($res);
	$i=1;
	echo "ressources restantes :<br>";
	foreach ($ressources as $val){
		$poss = mysql_fetch_assoc($res2);
		if ($cout[$val]!=0){
			$reste = $poss['nombre']-$nb*$cout[$val];
			echo $reste."<br>";
			$reqP = "UPDATE possession_ressources SET nombre= '".$reste."' WHERE joueur_id ='".$idj."' AND ressources_id ='".$i."'";
			$paye = mysql_query($reqP);
		}else{
			echo (int)$poss['nombre']."<br>";
		}
		$i++;
	}
}




//#################################################################################################//
//									           FONCTIONS UTILES  A L'ACHAT DES UNITES								       //	
//#################################################################################################//
//=================================================       Fonction permettant d'obtenir la liste des  unites recrutables      ===================================================
function getListUnit(){
	connexion();
	$req = "SELECT id,nom FROM unites";
	$res = mysql_query($req);
	$i=0;
	while($data = mysql_fetch_assoc($res)){
		$bats[$i++]=$data;
	}	
	mysql_close();
	return $bats;
}

//===================================================       Fonction permettant d'afficher un tableau dans une liste      ======================================================
function affListUnit($liste){
	echo "<select name=\"unit\">";
	$i=-1;
	while($liste[++$i]['nom']!=NULL){
		echo "<option value=\"".$liste[$i]['id']."\">".$liste[$i]['nom'];
	}	
	echo "</select> <br>";
}

//==============================================================     fonction permettant de recruter des unités        =======================================================
function recruter($idj, $idu, $nb){
	echo "id_joueur : ".$idj." <br>id_unite : ".$idu."<br>nombre : ".$nb."<br>";
	connexion();
	$nb = min($nb, getMaxUnit($idj, $idu)); //calcul du max recrutable
	$req = "SELECT nombre FROM possession_unit WHERE joueur_id='".$idj."' AND unites_id='".$idu."'";
	$res = mysql_query($req);
	$old = mysql_fetch_assoc($res);
	$oldnb = (int)$old['nombre'];
	//test si type d'unite deja present
	if ($oldnb==0){
		$req2 = "INSERT INTO possession_unit (joueur_id , unites_id ,nombre, x, y) VALUES('".$idj."' ,'".$idu."' ,'".$nb."','0','0')";
	}else{
		$newnb=$oldnb +$nb;
		$req2 = "UPDATE possession_unit SET nombre ='".$newnb."' WHERE joueur_id='".$idj."' AND unites_id='".$idu."'";
	}
	payerUnit($idj,$idu, $nb);
	echo "nb : ".$nb."<br>oldnb : ".$oldnb."<br>newnb : ".$newnb."<br>";
	$res2 = mysql_query($req2);
	mysql_close();
}

//=======================================================         fonction calculant le nombre max d'unite recrutable        =====================================================
function getMaxUnit($idj, $idu){
	$ressources = array('cout_or', 'cout_bois', 'cout_pierre', 'cout_gemme', 'cout_cristaux', 'cout_souffre');
	$req = "SELECT cout_or, cout_bois, cout_pierre, cout_gemme, cout_cristaux, cout_souffre FROM unites WHERE id='".$idu."'";
	$req2 = "SELECT ressources_id, nombre FROM possession_ressources WHERE joueur_id='".$idj."'";
	$res = mysql_query($req);
	$res2 = mysql_query($req2);
	$cout = mysql_fetch_assoc($res);
	
	$max = 100000;
	$i=0;
	foreach ($ressources as $val){
		$poss = mysql_fetch_assoc($res2);
		if ($cout[$val]!=0){
			$max = min(floor($poss['nombre']/$cout[$val]), $max);
		}
		echo $val." : ".$cout[$val]."_ _ _ possede : ".(int)$poss['nombre']."_ _ _ max : ".$max."<br>";
	}
	return $max;
	// echo "cout : ".$mmm['cout_or']."<br> ressource : ".$mmm2['ressources_id']."<br> possede : ".$mmm2['nombre'];	
}

//=================================================         fonction retirant les ressources dépensee lors de  l'achat des unités       ============================================
function payerUnit($idj, $idu, $nb){
	$ressources = array('cout_or', 'cout_bois', 'cout_pierre', 'cout_gemme', 'cout_cristaux', 'cout_souffre');
	$req = "SELECT cout_or, cout_bois, cout_pierre, cout_gemme, cout_cristaux, cout_souffre FROM unites WHERE id='".$idu."'";
	$req2 = "SELECT ressources_id, nombre FROM possession_ressources WHERE joueur_id='".$idj."'";
	$res = mysql_query($req);
	$res2 = mysql_query($req2);
	$cout = mysql_fetch_assoc($res);
	$i=1;
	echo "ressources restantes :<br>";
	foreach ($ressources as $val){
		$poss = mysql_fetch_assoc($res2);
		if ($cout[$val]!=0){
			$reste = $poss['nombre']-$nb*$cout[$val];
			echo $reste."<br>";
			$reqP = "UPDATE possession_ressources SET nombre= '".$reste."' WHERE joueur_id ='".$idj."' AND ressources_id ='".$i."'";
			$paye = mysql_query($reqP);
		}else {
			echo (int)$poss['nombre']."<br>";
		}
		$i++;
	}
}
	

//#################################################################################################//
//									           FONCTIONS UTILES AU COMBAT										       //	
//#################################################################################################//
//=================================================================         donne les stats d'un type d'unité         ===========================================================
function getstats($idu){
	connexion();
	$reqS="SELECT nom,attaque,portee,pv FROM unites WHERE id =".$idu;
	$resS = mysql_query($reqS);
	$stats = mysql_fetch_assoc($resS);
	mysql_close();
	return $stats;
}

//===============================================          fonction retournant le nb d'unité d'un type que le joueur possède         ================================================		
function getNbUnit($idj, $idu){
	connexion();
	$nbG = "SELECT nombre FROM possession_unit WHERE joueur_id = ".$idj." AND unites_id =\"".$idu."\"";
	$res = mysql_query($nbG);
	$data = mysql_fetch_assoc($res);
	return (int)$data['nombre'];
	mysql_close();
}

//=========================================================         VERIF Nb Unités envoyées / Nb Unités max         =========================================================
function VerifNbUnit($idj, $idu, $nb){
	connexion();
	$nbmax = getNbUnit($idj, $idu);
	if ($nb>$nbmax)
		return $nbmax;
	else
		return $nb;
	mysql_close();	
}

//=======================================================       Fonction permettant d'obtenir la liste des cibles      =========================================================
function getListCible(){
	connexion();
	$req = "SELECT id,pseudo FROM joueurs";
	$res = mysql_query($req);
	$i=0;
	while($data = mysql_fetch_assoc($res)){
		if ($data['pseudo'] != $_SESSION['pseudo']){
			$cibles[$i++]=$data;
		}
	}	
	mysql_close();
	return $cibles;
}	

//==================================================       Fonction permettant d'afficher un tableau dans une liste      ======================================================
function affListCibles($liste){
	echo "<select name=\"cible\">";
	$i=-1;
	while($liste[++$i]['pseudo']!=NULL){
		echo "<option value=\"".$liste[$i]['id']."\">".$liste[$i]['pseudo'];
	}	
	echo "</select> <br>";
}

//==============================================     fonction permettant de connaitre la puissance offensive d'un groupe     ==================================================
function getpuissoffensive($nb, $idu){
	connexion();
	$req = "SELECT attaque FROM unites WHERE id='".$idu."'"; 
	$res = mysql_query($req);
	$att = mysql_fetch_assoc($res);
	$power = (int)$att['attaque'] * $nb;
	mysql_close();
	return $power;
}

//======================================================     fonction permettant de connaitre les pv d'un groupe     ========================================================	
function getHP($nb, $idu){
	connexion();
	$req = "SELECT pv FROM unites WHERE id='".$idu."'"; 
	$res = mysql_query($req);
	$vie = mysql_fetch_assoc($res);
	$HP = (int)$vie['pv'] * $nb;
	mysql_close();
	return $HP;
}


