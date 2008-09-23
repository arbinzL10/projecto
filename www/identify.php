<?php

//------------- DEPRECATED ---------------------------------//
connect('jeu','localhost','root','');
$sql='SELECT pass FROM joueurs WHERE pseudo=\''.$_SESSION['identify']['pseudo'].'\'';
$data=exec_req($sql,'project1','localhost','folken','blabla');
if($data){
	if($data['pass']==$_SESSION['identify']['password']){
		$_SESSION['identify']=true;
	}
}else{
	die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
}
?>

