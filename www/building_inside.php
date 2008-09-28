<?php 

session_start();

foreach($_SESSION['map']['batiments'] as $key => $value){
	if($_SESSION['map']['batiments'][$key]['x']==$_POST['coord'][0] && $_SESSION['map']['batiments'][$key]['y']==$_POST['coord'][1])
		echo "intérieur du batiment ".$_SESSION['map']['batiments'][$key]['name'];
}
?>