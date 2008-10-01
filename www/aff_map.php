<?php session_start();
include 'basic_functions.php';
include 'functions_nico.php';
include 'map.php';

if(isset($_POST['type_map'] )){
	if(isset($_POST['offset'][0]) or isset($_POST['offset'][1])){
		$_SESSION['map']['y']+=$_POST['offset'][1];
		$_SESSION['map']['x']+=$_POST['offset'][0];
	}
	if( !isset($_POST['option']) or $_POST['option']=='init' ){
		$_SESSION['map']['y']=0;
		$_SESSION['map']['x']=0;?>
		<script language="javascript">
			eval("selItem=null;");
		</script><?php
	}
	
	$option='';
	if(isset($_POST['option'])){
		if(is_array($_POST['option'])){
			foreach($_POST['option'] as $cle => $valeur){
				if($cle==0)
					$option="'".$_POST['option'][$cle];
				else
					$option.="&".$_POST['option'][$cle];
				
			}
			$option.="'";
		}
		else
			$option="'".$_POST['option']."'";
	}
		
		
	$map=getMap($_SESSION['identify']['id'],$_POST['type_map'],$_SESSION['map']['x'],$_SESSION['map']['y']);
	$mapsize=getMapSize($_POST['type_map']);
	if($map!=NULL){
		$map_id="CACHE__".$_POST['type_map']."__"./*$option.*/key($map['tiles_id'][key($map['tiles_id'])])."_".key($map['tiles_id'])."__".(modulo($_SESSION['map']['x'],$mapsize['width']))."_".(modulo($_SESSION['map']['y'],$mapsize['height']));
		
	}
	else{
		$map_id=$_SESSION['map']['last'];
		$_SESSION['map']['y']-=$_POST['offset'][1];
		$_SESSION['map']['x']-=$_POST['offset'][0];
	}
	$res=file_incache($map_id);
	if($res!=false){
		$map_id_temp=$map_id;
		$map_id=$res;
	}
		
	/*-------------------- Switch des options ------------------------------*/
	if(strpos($option,'force-reloading')!=false or strpos($option,'no-cache')!=false){
		if(file_exists("C:/Program Files/EasyPHP1-8/www/temp/".$map_id))
			unlink("C:/Program Files/EasyPHP1-8/www/temp/".$map_id);
		$map_id=$map_id_temp.".".mktime(date("H"),date("i"),date("s")-5,date("m"),date("d"),date("y"));
	}
	if(strpos($option,'building')==true){
		construire($_SESSION['identify']['id'],substr($_POST['item'][0],4),$_POST['item'][1],$_POST['item'][2],$map['map_id'][0]);
	}
	if(strpos($option,'quad')==true)
		$_SESSION['map']['option']='quad';
	
	/*----------------------------------------------------------------------*/

	$_SESSION['map']['last']=$map_id;
	
	$temp=explode("__",$map_id);
	$long=explode("_",$temp[2]);
	
	if( (!isset($_POST['offset'][0]) or !isset($_POST['offset'][1])) and (strpos($option,'init')!=false ) ){
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
					
				$_SESSION['map']['compo']=parseMap($_SESSION['tiles'],$map['tiles_id'],$_POST['type_map'],$_SESSION['map']['x'],$_SESSION['map']['y']);
				$_SESSION['map']['width']=$mapsize['width'];
				$_SESSION['map']['height']=$mapsize['height'];
				$bat=getBat($map['map_id'],modulo($_SESSION['map']['x'],$mapsize['width']),modulo($_SESSION['map']['y'],$mapsize['height']));
				if($bat!=NULL)	$_SESSION['map']['batiments']=parseBat($bat);
				else	$_SESSION['map']['batiments']=NULL;
				
//------------------------------------------------------------------------------------------------//
			
		//}
		
	}
				/*if($mapsize['width']==$i){
					echo '<br />';
					$i=0;
				}*/
				echo "	<map name=\"Map\">";
				
				for($j=0;$j<$mapsize['height'];$j++){
					for($i=0;$i<$mapsize['width'];$i++){
						$x=$_SESSION['map']['x']+$i;
						$y=$_SESSION['map']['y']+$j;
						echo "	<area id='rect__".$i."_".$j."' shape='rect' onclick=\"HTTPReq(new Array('option[0]','option[1]','type_map','item[0]','item[1]','item[2]'),new Array('building','no-cache','map_joueur',selEffItem,'".$i."','".$j."'),'aff_map.php','tiles');\" coords='".($i*16).",".($j*16).",".(($i+1)*16).",".(($j+1)*16)."' >";
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
	if( (!isset($_POST['offset'][0]) or !isset($_POST['offset'][1])) and (strpos($option,'init')!=false ) ){
			echo "<div id='flecheD' onclick=\"HTTPReq(new Array('type_map','offset[0]','offset[1]'),new Array('".$_POST['type_map']."','4','0'),'aff_map.php','tiles')\">
				<IMG SRC=images/flecheD.png >
			</div>
			
			<div id='flecheB' onclick=\"HTTPReq(new Array('type_map','offset[0]','offset[1]'),new Array('".$_POST['type_map']."','0','4'),'aff_map.php','tiles')\">
				<IMG SRC=images/flecheB.png >
			</div>
		</div>
		<div id='cite_frame'>
			<div class='div_citeframe_item' id='l_batiment'>
				<div class='plus'>
					<label>+</label>
				</div>
				<label>batiments</label>
			</div>
			<div class='div_citeframe_item' id='l_unités'>
				<div class='plus'>
					<label>+</label>
				</div>
				<label>unités</label>
			</div>
		</div>";
		
		//if(isset($_POST['call_by']) and $_POST['call_by']=='castle')
		$_POST['init']='null';
		$_POST['type_menu']='batiments';
		include 'mini-menu-construction.php';
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
function file_incache($prefix){
	// clean le rep de temporarie avant action
	include 'maintenance_temp.php';
	$calc=0;
	$res=false;
    $handler = opendir($_SERVER['DOCUMENT_ROOT']."/temp/");
    while ($file = readdir($handler)) { 
        if ($file != '.' && $file != '..' && $file != "robots.txt" && $file != ".htaccess"){
			
            if(strpos($file,$prefix)>=0){
				
				if(isset($temp[1])){
					if($calc<$temp[1]){
						$calc=$temp[1];
						$res=$file;
					}
				}else{
					$res=$file;	
				}	
			}
			
			//$res[$file] = $currentModified;
        }   
    }
    closedir($handler);
	

    //Sort the date array by preferred order
    return $res;

}

?>
