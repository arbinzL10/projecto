<?php @session_start();

include 'map.php';
if(isset($_POST['map_joueur'])){
	//---------------------- à utiliser pour l'affichage ----------------------------------------------//
	$_SESSION['tiles']=getTileset();
	foreach($_SESSION['tiles'] as $key => $value){
		foreach($_SESSION['tiles'][$key] as $key2 => $value2){
			if($key2!=''){
				$_SESSION['tiles'][$_SESSION['tiles'][$key][$key2]['id']]['path']=$_SESSION['tiles'][$key][$key2]['path'];
				//$image=$_SESSION['tiles'][$_SESSION['tiles'][$key][$key2]['id']]['image'];
			}
		}
	}
	$map=getMap($_SESSION['identify']['id'],'mapjoueur');
	$_SESSION['map']=parseMap($_SESSION['tiles'],$map);
	$mapsize=getMapSize();
	//------------------------------------------------------------------------------------------------//
	$i=0;
	$j=0;
	echo "<div id='zoom' onclick=HTTPReq('map_monde',null,'aff_map.php','b_menu')>
			<label>mapmonde</label>
		 </div><br />";
	foreach($_SESSION['map'] as $value){
		if($mapsize['width']==$i){
			echo '<br />';
			$i=0;
		}
		echo "<IMG SRC=affichage_map.php?id=$j >";
		
		$j++;
		$i++;
		
	}
}
if(isset($_POST['map_monde'])){
	$_SESSION['tiles']=getTileset();
	foreach($_SESSION['tiles'] as $key => $value){
		foreach($_SESSION['tiles'][$key] as $key2 => $value2){
			if($key2!=''){
				$_SESSION['tiles'][$_SESSION['tiles'][$key][$key2]['id']]['path']=$_SESSION['tiles'][$key][$key2]['path'];
				//$image=$_SESSION['tiles'][$_SESSION['tiles'][$key][$key2]['id']]['image'];
			}
		}
	}
	$map=getMap($_SESSION['identify']['id'],'mapmonde');
	$_SESSION['map']=parseMap($_SESSION['tiles'],$map);
	//$mapsize=getMapSize('mapmonde');
	//------------------------------------------------------------------------------------------------//
	$i=0;
	$j=0;
	echo "<div id='zoom' onclick=HTTPReq('map_joueur',null,'aff_map.php','b_menu')>
			<label>map du royaume</label>
		 </div><br />";
	//print_r($_SESSION['map']);
	foreach($_SESSION['map'] as $key => $value){
		echo "<IMG SRC=affichage_map.php?id=$j&typeMap='mapmonde' >";
		if($key!=$i){
			echo '<br />';
			$i=0;
		}
		$j++;
		$i=$map[$j]['y'];
		echo $map[$j]['y'];
		
	}
	



}


?>
