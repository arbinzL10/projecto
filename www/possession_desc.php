<?php

include 'basic_functions.php';

session_start();

$sql="Select x,y,nom,pv from possession_".$_POST['type'].",".$_POST['type']." where possession_".$_POST['type'].".id_joueur=".$_SESSION['identify']['id']." and ".$_POST['type'].".id=possession_".$_POST['type'].".id_".$_POST['type'];
$data=exec_req($sql,0);


	echo "<div class='title_menu_desc'><div id='col_nom' class='title_col_menu_desc'>nom</div><div id='col_pv' class='title_col_menu_desc'>pv</div><div id='col_pos' class='title_col_menu_desc'>pos[x,y]</div></div><br />";
foreach($data as $key =>$value){
	if($value!='')
	echo "<div class='item_menu_desc'><div id='col_nom' class='col_menu_desc'>".$value['nom']."</div><div id='col_pv' class='col_menu_desc'>".$value['pv']."</div><div id='col_pos' class='col_menu_desc'>[".$value['x'].",".$value['y']."]</div></div><br />";
}
echo "<div class='bottom_menu_desc'></div>";

?>
