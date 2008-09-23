<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
connect('project1','localhost','folken','blabla');
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


</html>
