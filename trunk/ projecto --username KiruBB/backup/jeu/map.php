<?php	@session_start();
include "basic_functions.php";
function parseMap($tiles,$map){
	
	foreach($map as $key => $value){
		echo "key=$key";
		$res[$key]=explode("-",$map[$key]['compo']);
		echo "<br />";
		print_r($res);
		$i=0;
		foreach($res[$key] as $value2){
			if($value!=''){
				$res2[$key][$i++]=$tiles[$value2]['path'];
			}	
		}
	}
	echo "<br />res2=";
	print_r($res2);	
	echo "<br />";
	return $res2;
}
function exportTilesTabToXml($chemin,$tiles){
	$fic=fopen("./".$chemin,"a+",true);
	foreach($tiles as $key => $element){
		fwrite($fic,"<$key>");
		foreach($element as $key2 => $element2){
			fwrite($fic,"\n\t<$key2>");
			foreach($element2 as $key3 => $emement3){
				fwrite($fic,"\n\t\t<$key3>$element2[$key3]</$key3>");
			}
			fwrite($fic,"\n\t</$key2>");
		}
		fwrite($fic,"\n</$key>\n");
	}
	fclose($fic);
}
function exportMapToPng($chemin,$map){
	
}
function getMap($id_joueur,$type){

	
	if($type=='mapmonde'){
			$i=0;
			$sql='SELECT x,y FROM map where joueur_id='.$id_joueur;
			$req=mysql_query($sql);
			$data=mysql_fetch_assoc($req);
			$sql='SELECT compo,x,y FROM map where x>'.($data['x']-3).' and x<'.($data['x']+3).' and y>'.($data['y']-3).' and y<'.($data['y']+3).' ORDER BY x ASC,y ASC';
			$data=exec_req($sql,0);
			//while($data[$i]=mysql_fetch_assoc($req))$i++;
			print_r($data);
			$res='';
			$i=0;
			
			
			foreach($data as $value){
				if($value!=''){
					if($i>0)
						$res[$value['y']]['compo']=$res[$value['y']]['compo'].$value['compo'];
					else
						$res[$value['y']]['compo']=$value['compo'];
					$i++;
				}
			}
			echo "<br />";
			print_r($res);
			echo "<br />";
	}
	if($type=='mapjoueur'){
		$sql='SELECT compo FROM map where joueur_id='.$id_joueur;
		$req=mysql_query($sql);
		$res[0]=mysql_fetch_assoc($req);
	}
	return $res;

}
function getTileset(){

	$db = mysql_connect('localhost','root','');
	// on sélectionne la base
	mysql_select_db('jeu',$db);
	$sql='SELECT * FROM tiles';
	$req=mysql_query($sql);
	$i=0;
	while($data[$i++]=mysql_fetch_assoc($req));
	
	if($data){
		$i=0;
	foreach($data as $value){
		if(strpos($value['type'],"eau")==false){
			$tile[$value['type']][$value['nom']]['path'] =$value['path'];
			$tile[$value['type']][$value['nom']]['passthru'] = $value['passthru'];
			$tile[$value['type']][$value['nom']]['id'] = $value['id'];
		}
	}
	return $tile; 
	}
}
function addTileRatio($type_array,$tileType_array,$nb){
	for($i=0;$i<$nb;$i++){
		$type_array[]=$tileType_array[array_rand($tileType_array)];
	}
	return $type_array;
}
function getMapSize($typeMap='mapjoueur'){
	if($typeMap=='mapjoueur'){
		$res['width']=$largeur=20;
		$res['height']=$hauteur=20;
	}else{
		if($typeMap=='mapmonde'){
			$res['width']=120;
			$res['height']=120;
		}
	}
	return $res;
}
function createMapWithTiles($tile_tab,$type_terrain='normal',$width,$height){

	foreach($tile_tab as $key =>$value){
		if(strpos('"'.$key.'"',"montagne")!=FALSE){
			$montagne[]=$key;
		}
		if(strpos('"'.$key.'"',"basic")!=FALSE){
			$basic[]=$key;
		}
		/*if(strpos('"'.$key.'"',"eau")!=FALSE){
			$eau[]=$key;
		}*/
		if(strpos('"'.$key.'"',"foret")!=FALSE){
			$foret[]=$key;
		}
	}
	$type_array=array();
	for($i=0;$i<$width;$i++){
		for($j=0;$j<$height;$j++){
			foreach($tile_tab as $key => $value){
				if(strpos('"'.$key.'"',"basic")!=FALSE){
					$type_array=addTileRatio($type_array,$basic,2);
					
				}
				if(strpos('"'.$key.'"',"montagne")!=FALSE)
					$type_array=addTileRatio($type_array,$montagne,1);
					
				if(strpos('"'.$key.'"',"foret")!=FALSE)
					$type_array=addTileRatio($type_array,$foret,1);
				
			}
			
			if( ($i<2 || $i>$height-2) && ($j<2 || $j>$width-2) ){
				$type_array=addTileRatio($type_array,$montagne,4);
				if( ($i<1 || $i>$height-1) && ($j<1 || $j>$width-1) )
					$type_array=addTileRatio($type_array,$montagne,8);
			}
	
			
			if($i>0)
				$type_array[]=$map[$i-1][$j];
			if($j>0)
				$type_array[]=$map[$i][$j-1];
	
			if($j>=1 and $i>=1){
				if(strpos($map[$i-1][$j-1],'montagne')!=false){
					if(strpos($map[$i][$j-1],'montagne')!=false || strpos($map[$i-1][$j],'montagne')!=false){
						if(strpos($map[$i-1][$j+1],'montagne')!=false)
							$type_array[]=$map[$i-1][$j-1];
						$type_array[]=$map[$i-1][$j-1];
					}
				}
				else{
					if(strpos($map[$i-1][$j-1],'foret')!=false){
						if(strpos($map[$i][$j-1],'foret')!=false || strpos($map[$i-1][$j],'foret')!=false){
							if(strpos($map[$i-1][$j+1],'foret')!=false)
								$type_array[]=$map[$i-1][$j-1];
							$type_array[]=$map[$i-1][$j-1];
						}
					}
					$type_array[]=$map[$i-1][$j-1];
				}
			}
	
			if($i>=1 and $j<($width-1)){
				if(strpos($map[$i-1][$j+1],'montagne')!=false){
					if(strpos($map[$i][$j-1],'montagne')!=false || strpos($map[$i-1][$j],'montagne')!=false){
						if(strpos($map[$i-1][$j+1],'montagne')!=false)
							$type_array[]=$map[$i-1][$j-1];
						$type_array[]=$map[$i-1][$j-1];
					}
				}
				else{
					if(strpos($map[$i-1][$j+1],'foret')!=false){
						if(strpos($map[$i][$j-1],'foret')!=false || strpos($map[$i-1][$j],'foret')!=false){
							if(strpos($map[$i-1][$j+1],'foret')!=false)
								$type_array[]=$map[$i-1][$j-1];
							$type_array[]=$map[$i-1][$j-1];
						}
					}
					$type_array[]=$map[$i-1][$j+1];
				}
			}
			
			$map[$i][$j]=$type_array[array_rand($type_array)];
			array_splice($type_array,0,count($type_array));
	
		}
	}
	return $map;
}

function createMap(){
	connect('jeu','localhost','kirub','blabla');
	
	$largeur=20;
	$hauteur=20;
	$type='normal';
	$tiles=getTileset();
	
	//---------------------- à utiliser pour créer la map ---------------------------------------------//
	$map=createMapWithTiles($tiles[$type],$type,$largeur,$hauteur);
		
	foreach($tiles[$type] as $key => $value){
			if($key!=''){
				$tiles[$type][$key]['image']=imagecreatefrompng($tiles[$type][$key]['path']);
			}
	}
	
	$im=imagecreatetruecolor(16*$largeur,16*$hauteur);
	
	for($i=0;$i<$largeur;$i++){
		for($j=0;$j<$hauteur;$j++){
				imagecopymerge($im,$tiles[$type]['basic']['image'],$j*16,$i*16,0,0,16,16,100); 
		}
	}
	$mapid='';
	$newpath="C:/Program Files/EasyPHP1-8/www/map/".$_POST['register'][4].".png";
	imagepng($im,$newpath);
	$im=imagecreatefrompng($newpath);
	imagealphablending ($im, TRUE)."<br />";
	for($i=0;$i<$largeur;$i++){
		for($j=0;$j<$hauteur;$j++){
			foreach( $tiles[$type] as $key => $value){
				if( ($map[$i][$j]==$key) ){
					if($i==0 && $j==0)
						$mapid=$tiles[$type][$key]['id'];
					else
						$mapid=$mapid.'-'.$tiles[$type][$key]['id'];
					imagealphablending ($tiles[$type][$key]['image'], TRUE);
					imagecopymerge($im,$tiles[$type][$key]['image'],$j*16,$i*16,0,0,16,16,100); 
					$transp = imagecolorallocate($im, 0, 0, 0);
					imagecolortransparent($im, $transp); // On rend le fond noir transparent
				}
			}
		}
	}
	$color=imagecolorsforindex($im,imagecolorat($tiles[$type]['montagne 2']['image'],0,0));
	imagecolortransparent($im,imagecolorallocate($im,$color['red'],$color['green'],$color['blue']));
	imagesavealpha ($im, FALSE);
	imagepng($im,$newpath);
	
	
	$sql="SELECT MIN(x) FROM map";
	if($req=mysql_query($sql)){
		$data=mysql_fetch_assoc($req);
		$xmin=$data['MIN(x)'];
	}else
	{
		$xmin=0;
	}
	$sql="SELECT MIN(y) FROM map";
	if($req=mysql_query($sql)){
		$data=mysql_fetch_assoc($req);
		$ymin=$data['MIN(y)'];
	}else
	{
		$ymin=0;
	}
	$pos=$cardinal[array_rand($cardinal=array("NORTH","SUD","EST","OUEST"))];
	$sql="SELECT MAX(x) FROM map";
	if($req=mysql_query($sql)){
		$data=mysql_fetch_assoc($req);
		$xmax=$data['MAX(x)'];
	}else
	{
		$xmax=0;
	}
	$sql="SELECT MAX(y) FROM map";
	if($req=mysql_query($sql)){
		$data=mysql_fetch_assoc($req);
		$ymax=$data['MAX(y)'];
	}else
	{
		$ymax=0;
	}
	if($pos=="NORTH"){
		$y=$ymin-1;
		$x=rand($xmin,$xmax);
	}
	if($pos=="SUD"){
		$y=$ymax+1;
		$x=rand($xmin,$xmax);
	}
	if($pos=="EST"){
		$x=$xmax+1;
		$y=rand($ymin,$ymax);
	}
	if($pos=="OUEST"){
		$x=$xmin-1;
		$y=rand($ymin,$ymax);
	}
	$sql="SELECT id FROM joueurs where pseudo='".$_POST['register'][2]."'";
	$req=mysql_query($sql) or die(mysql_error());
	$data2=mysql_fetch_assoc($req);
	$sql="INSERT INTO map ( joueur_id , name , x , y , compo ) VALUES (".$data2['id'].",'".$_POST['register'][4]."',".$x.",".$y.",'".$mapid."')";
	mysql_query($sql) or die(mysql_error());
	
	
		
}
//}
//echo "<IMG SRC=affichage_map.php ALT='map du joueur'TITLE='map du joueur'>";

?>
