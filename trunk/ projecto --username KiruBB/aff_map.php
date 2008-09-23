<?php @session_start();
include 'basic_functions.php';
include 'map.php';
if(isset($_POST['type_map'])){
	if(isset($_POST['offset'][0]) or isset($_POST['offset'][1])){
		$_SESSION['map']['y']+=$_POST['offset'][1];
		$_SESSION['map']['x']+=$_POST['offset'][0];
	}else{
		$_SESSION['map']['y']=0;
		$_SESSION['map']['x']=0;?>
		<script language="javascript">
			eval("selItem=null;");
		</script><?php
	}
	$call_by='null';
	$_SESSION['map']['option']='';
	if(isset($_POST['call_by']))
		$call_by=$_POST['call_by'];
	if(isset($_POST['option']))
		$_SESSION['map']['option']=$_POST['option'];
		
		
	$map=getMap($_SESSION['identify']['id'],$_POST['type_map'],$_SESSION['map']['x'],$_SESSION['map']['y']);
	$mapsize=getMapSize($_POST['type_map']);
	if($map!=NULL){
		$map_id="CACHE__".$_POST['type_map']."_".$_SESSION['map']['option'].".".key($map[key($map)])."_".key($map)."__".(modulo($_SESSION['map']['x'],$mapsize['width']))."_".(modulo($_SESSION['map']['y'],$mapsize['height']));
		
	}
	else{
		$map_id=$_SESSION['map']['last'];
		$_SESSION['map']['y']-=$_POST['offset'][1];
		$_SESSION['map']['x']-=$_POST['offset'][0];
		
	}
	$_SESSION['map']['last']=$map_id;
	$temp=explode(".",$map_id);
	$temp=explode("__",$temp[1]);
	$long=explode("_",$temp[0]);
	
	if(!isset($_POST['offset'][0]) or !isset($_POST['offset'][1])){
	echo utf8_encode("	<div class='pos_info'>
				<div id='mapmonde'>
					Echelle Mondiale:<br/>
					<label>longitude=".$long[0]/*key($map[0])*/."°</label>
					<label>latitude=".$long[1]/*key($map)*/."°</label>
		  		</div>
				<div id='mapjoueur'>
					Echelle national:<br/>
					<label>x=".$_SESSION['map']['x']."</label>
					<label>y=".$_SESSION['map']['y']."</label>
				</div>
			</div>");
	echo "<div id='map'>
			<div id='quadrillage' onclick=\"HTTPReq(new Array('type_map','offset[0]','offset[1]','option'),new Array('map_joueur','0','0','quad'),'aff_map.php','tiles')\" ><label>quadrillage</label></div>
			<div id='zoom' onclick=\"HTTPReq(new Array('type_map','offset[0]','offset[1]'),new Array('map_monde','0','0'),'aff_map.php','tiles')\">
				<label>mapmonde</label>
			</div>
			<div id='flecheH' onclick=\"HTTPReq(new Array('type_map','offset[0]','offset[1]'),new Array('".$_POST['type_map']."','0','-4'),'aff_map.php','tiles')\">
				<IMG SRC=images/flecheH.png >
			</div>
			<div id='flecheG' onclick=\"HTTPReq(new Array('type_map','offset[0]','offset[1]'),new Array('".$_POST['type_map']."','-4','0'),'aff_map.php','tiles')\">
				<IMG SRC=images/flecheG.png >
			</div>
		 	<div id='tiles'>";
	}		
	if($map!=NULL){
		//foreach($map as $key3 => $value3){
			if(!file_exists("C:/Program Files/EasyPHP1-8/www/temp/".$map_id)){
				//---------------------- Traitement pour l'affichage l'édition des map ----------------------------------------------//
				$_SESSION['tiles']=getTileset();
				foreach($_SESSION['tiles'] as $key => $value){
					foreach($_SESSION['tiles'][$key] as $key2 => $value2){
						if($key2!=''){
							$_SESSION['tiles'][$_SESSION['tiles'][$key][$key2]['id']]['path']=$_SESSION['tiles'][$key][$key2]['path'];
						}
					}
				}
				
				if(isset($_SESSION['map']['compo']))
					unset($_SESSION['map']['compo']);
					
				$_SESSION['map']['compo']=parseMap($_SESSION['tiles'],$map,$_POST['type_map'],$_SESSION['map']['x'],$_SESSION['map']['y']);
				$_SESSION['map']['width']=$mapsize['width'];
				$_SESSION['map']['height']=$mapsize['height'];
				$_SESSION['map']['batiments']=parseBat($_
//------------------------------------------------------------------------------------------------//
			}
		//}
		
	}
				/*if($mapsize['width']==$i){
					echo '<br />';
					$i=0;
				}*/
				echo "	<map name=\"Map\">";
				for($j=0;$j<$mapsize['height'];$j++){
					for($i=0;$i<$mapsize['width'];$i++){
					echo "	<area id='rect__".$i."_".$j."' shape='rect' onclick=\"build($i,$j)\" coords='".($i*16).",".($j*16).",".(($i+1)*16).",".(($j+1)*16)."' >";
					}
				}
				echo "	</map>
						<IMG usemap='#Map' SRC=affichage_map.php?id=$map_id lowsrc='images/map.gif'>";
				/*$i++;			
				$j++;
			}
			echo '<br />';
			$j=0;	
		}*/
	echo "	</div>";
	if(!isset($_POST['offset'][0]) or !isset($_POST['offset'][1])){
			echo "<div id='flecheD' onclick=\"HTTPReq(new Array('type_map','offset[0]','offset[1]'),new Array('".$_POST['type_map']."','4','0'),'aff_map.php','tiles')\">
				<IMG SRC=images/flecheD.png >
			</div>
			<div id='flecheB' onclick=\"HTTPReq(new Array('type_map','offset[0]','offset[1]'),new Array('".$_POST['type_map']."','0','4'),'aff_map.php','tiles')\">
				<IMG SRC=images/flecheB.png >
			</div>
		</div>";
		//if(isset($_POST['call_by']) and $_POST['call_by']=='castle')
		echo "	<div id='construct'>
					<div id='item1' class='construct_button' onclick=\"setHaloItem();\" onmouseover=\"selItem='item1';\"> 
					</div>
				</div>";
	}
	
}
/*if(isset($_POST['map_monde'])){
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
	$mapsize=getMapSize();
	$width=$mapsize['width']*$map['nb_joueurs'];
	//------------------------------------------------------------------------------------------------//
	$i=0;
	$j=0;
	$k=0;
	echo "<div id='zoom' onclick=HTTPReq('map_joueur',null,'aff_map.php','b_menu')>
			<label>map du royaume</label>
		 </div><br />";
	foreach($_SESSION['map'] as $key => $value){
		foreach($_SESSION['map'][$key] as $key2 => $value2){
			if($width==$k){
				echo '<br />';
				$k=0;
			}
			echo "<IMG SRC=affichage_map.php?y=$key&id=$j&typeMap='mapmonde'>";
			$j++;
			$k++;
		}
		echo '<br />';
		$i=0;
	}
}*/

?>
