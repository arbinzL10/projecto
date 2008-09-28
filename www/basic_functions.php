<?php

function modulo($a, $b) {
	return $a - $b * floor($a/$b);
}

//		DEPRECATED 		USE connect()
function connect($db_name,$host,$login,$pass){
	$db = mysql_connect($host,$login,$pass);
	// on sélectionne la base
	mysql_select_db($db_name,$db);
}

function connect(){
	$db = mysql_connect($_SESSION['bdd']['host'],$_SESSION['bdd']['login'],$_SESSION['bdd']['passord']);
	// on sélectionne la base
	mysql_select_db($_SESSION['bdd']['name'],$db);
}

function exec_req($sql,$debug){
	$req=mysql_query($sql); 
	if($debug==1)
		die($sql.' <br/>			'.mysql_error());
	$i=0;
	if($req==FALSE)
		return false;
	if(substr($sql,0,6)!='INSERT' and substr($sql,0,6)!='UPDATE')
		while($data[$i++]=mysql_fetch_assoc($req));
	else
		$data=$req;
	return $data;
}

function isIdentified(){
	if(empty($_SESSION['identify']['id']))
		return false;
	
	return true;
}

function VerifierAdresseMail($adresse)
{
   $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,5}$#';
   if(preg_match($Syntaxe,$adresse))
   		return true;
   else
   		return false;
}

function afficheMap(){
connect('jeu','localhost','root','');
	
	$sql="select MIN(y),MIN(x) from map";
	$req=mysql_query($sql) or die(mysql_error());
	$res=mysql_fetch_assoc($req);
	$ymin=$res['MIN(y)'];
	$xmin=$res['MIN(x)'];
	$sql="select x,y,path from map  ORDER by x ASC, y ASC";
	$req=mysql_query($sql) or die(mysql_error());
	for($i=0;$i<mysql_numrows($req);$i++){
		$data=mysql_fetch_assoc($req);
		$_SESSION['image_path']=$data['path'];
		if($data['y']==$ymin)
			echo '<br />';
		echo "<IMG SRC=affichage_map.php ALT='map du joueur'TITLE='map du joueur'>";

	}

}




?>