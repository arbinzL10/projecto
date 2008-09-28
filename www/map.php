<?php	

//session_start();

function parseMap($tiles,$map,$type_map,$x,$y){
	unset($res2,$res);
	$taille=getMapSize();
	$res='';
	$a=0;
	$b=0;
	foreach($map as $key3 => $value3){
		for($j=0;$j<$taille['height'];$j++){
			foreach($map[$key3] as $key => $value){
				if($type_map=='map_monde'){
					$chaine=substr($map[$key3][$key]['compo'],($taille['width']*2)*$j,($taille['width']*2)-1);
					$res=array_merge($res,explode("-",$chaine));	
				}
				if($type_map=='map_joueur')
				{
					if($x==0 && $y==0){
						if($j==0)
							$res=explode("-",$map[$key3][$key]['compo']);
					}
					else
					{
						/*if($x>0){
							if($a==0)
								$chaine=substr($map[$key]['compo'],($x*2)+($j*($taille['width']*2)),($taille['width']*2)-($x*2)-1);
							if($a==sizeof($map)-1){
								$chaine=substr($map[$key]['compo'],(2*$taille['width'])*$j,($x*2)-1);
								$a=-1;
							}
						}
						if($x<0){						
							if($a==0)
								$chaine=substr($map[$key]['compo'],(($j+1)*($taille['width']*2))-(abs($x)*2),(abs($x)*2)-1);
							if($a==sizeof($map)-1){
								$chaine=substr($map[$key]['compo'],($j*($taille['width']*2)),($taille['width']*2)-(abs($x)*2)-1);
								$a=-1;
							}
						}*/
						if($x==0){
							$startx=$taille['width']*$j;
							$longueur=$taille['width'];
						}
						if($y==0){
							$offsety=0;
							$nbligne=$taille['height'];
						}
						if($b==0){
							if($y>0){
								$offsety=$y;
								$nbligne=$taille['height'];
							}
							if($y<0){
								$offsety=$taille['height']-$y;
								$nbligne=$taille['height'];
							}
						}
						if($b==sizeof($map)-1){
							if($y>0){
								$offsety=0;
								$nbligne=$y;
							}
							if($y<0){
								$offsety=0;
								$nbligne=$taille['height']-$y;
							}
						}
						if($a==0){
							if($x>0){
								$startx=($x%$taille['width'])+($j*$taille['width']);
								$longueur=$taille['width']-(modulo($x,$taille['width']));
							}
							if($x<0){
								$startx=(($j+1)*$taille['width'])-modulo(abs($x),$taille['width']);
								$longueur=modulo(abs($x),$taille['width']);
							}
						}else{
							if($a==sizeof($map[$key3])-1){
								if($x>0){
									$startx=$taille['width']*$j;
									$longueur=modulo($x,$taille['width']);
								}
								if($x<0){
									$startx=$j*$taille['width'];
									$longueur=$taille['width']-modulo(abs($x),$taille['width']);					
								}
								$a=-1;
							}
						}					
						//if($j==0)
						
						// x>0		$chaine=substr($map[$key]['compo'],($x*2)+($j*($taille['width']*2)),($taille['width']*2)-($x*2)-1);
							
						//$chaine=$map[$key]['compo'];
						/*
						else	
							if($x>=0)
								$res=explode("-",substr($map[$key]['compo'],$j*$taille['width'],$x+($j*(($taille['width']*2)-1))));
						if($x<0)
							$res=explode("-",substr($map[$key]['compo'],$j*$taille['width'],$x+(($j+1)*$taille['width'])));
						else
							$res=explode("-",$map[$key]['compo']);*/
						if($j>=$offsety && $j<$nbligne){
							$chaine=explode("-",$map[$key3][$key]['compo']);
						
							$temp=array_slice($chaine,$startx,$longueur);
						
							
							$res=array_merge($res,$temp);	
							$a++;
						}
					}
				}		
			}	
		}
		$b++;
	}
	$i=0;
	foreach($res as $value2){
		if($value2!=''){
			@$res2[$i++]=$tiles[$value2]['path'];
		}	
	}
	return $res2;
}
function exportTilesTabToXml($chemin,$tiles,$x,$y){
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
function getBat($map_id,$offset_mapx,$offset_mapy){
		$data=NULL;
		foreach($map_id as $key => $value){
			if($value!=''){
				$sql="SELECT * from possession_bat WHERE x>='$offset_mapx' and y>='$offset_mapy' and id_map=".$map_id[$key];
				
				$data=exec_req($sql,0);
			}
		}
		return $data;
}

function parseBat($bat){
	//$taille=getMapSize('map_joueur');
	//$tab=array_fill(0,$taille['width']*$taille['height'],-1);
	$data=NULL;
	
	foreach($bat as $key => $value){
		if($value!=''){
			$sql=" SELECT path,width,height,nom FROM tiles WHERE tiles.id= (SELECT id_tile FROM batiments WHERE id=".$bat[$key]['id_batiment'].")";
			$req=mysql_query($sql) or die(mysql_error()." ".$sql);
			$temp=mysql_fetch_assoc($req);
			$data[$key]['path']=$temp['path'];
			$data[$key]['x']=$bat[$key]['x'];
			$data[$key]['y']=$bat[$key]['y'];
			$data[$key]['name']=$temp['nom'];
			//$sql="SELECT width,height FROM batiments WHERE id=".$bat[$key]['id_batiment'];
			//$req=mysql_query($sql);
			//$temp=mysql_fetch_assoc($req);
			$data[$key]['width']=$temp['width'];
			$data[$key]['height']=$temp['height'];
		}	
	}
	return $data;
}
function getMap($id_joueur,$type,$x,$y){
	connect('jeu','localhost','root','');
	$taille=getMapSize();
	if($type=='map_monde'){
			$i=0;
			$sql='SELECT x,y FROM map where joueur_id='.$id_joueur;
			$data=exec_req($sql,0);
			$sql='SELECT joueur_id,compo,x,y FROM map where './*(x='.($data[0]['x']).' and y='.$data[0]['y'].') or*/'(x>'.($data[0]['x']-1).' and x<'.($data[0]['x']+1).' and y>'.($data[0]['y']-1).' and y<'.($data[0]['y']+1).') ORDER BY x ASC,y ASC';
			$data=exec_req($sql,0);
		
			/*foreach($data as $value){
				$res[$data['y']]=array($data['joueur_id'],$data['compo'],$data['x']);
			}*/
			//$res['nb_joueurs']=$data['count(joueur_id)'];
	}
	if($type=='map_joueur'){
		$sql='SELECT joueur_id,compo,x,y FROM map where joueur_id='.$id_joueur;
		$data=exec_req($sql,0);
		
		//if(modulo($y,$taille['height'])>=0){
			if($y>=0)
				$data[0]['y']+=bcdiv($y,$taille['height']);
			else
				$data[0]['y']-=bcdiv($y ,$taille['height']);
		//}
		//if($x % $taille['width']>=0){
			if($x>=0)
				$data[0]['x']+=bcdiv($x , $taille['width']);
			else
				$data[0]['x']-=bcdiv($x , $taille['width']);
		//}
		$sql='SELECT id,joueur_id,compo,x,y FROM map where (';
		if($x!=0){
			$sql.=' x='.($data[0]['x']+($x/abs($x))).' or x='.$data[0]['x'];
		}
		else{
			$sql.=' x='.$data[0]['x'];
		}
		
		if($y!=0)
			$sql.=') and ( y='.($data[0]['y']).' or y='.($data[0]['y']+($y/abs($y)));
		else
			$sql.=') and ( y='.$data[0]['y'];
			
		$sql.=') ORDER BY y ASC,x ASC';
		$data=exec_req($sql,0);	
		/*		
			$sql='SELECT joueur_id,compo,x,y FROM map where x='.($data[0]['x']-1).' or x='.$data[0]['x'].' ORDER BY y ASC,x ASC';
			$data=exec_req($sql,0);
			//$sql='SELECT joueur_id,compo,x,y FROM map where joueur_id='.$id_joueur.' OR x-1=(SELECT x from map where joueur_id='.$id_joueur.') ORDER BY joueur_id ASC';
		}
		if($y>0){
			
			$sql='SELECT joueur_id,compo,x,y FROM map where y='.($data[0]['y']+1).' or y='.$data[0]['y'].' ORDER BY y ASC,x ASC';
			$data=array_merge($data,exec_req($sql,0));
		}
		.' 
		if($y<0)
			$sql='SELECT joueur_id,compo,x,y FROM map where joueur_id='.$id_joueur.' OR y-1=(SELECT y from map where joueur_id='.$id_joueur.') ORDER BY joueur_id ASC';*/	
	}
	if($data[0]!=''){	
		foreach($data as $key => $value){
			if($value!='')
				$res['tiles_id'][$data[$key]['y']][$data[$key]['x']]=array("compo" => $data[$key]['compo']);
				$res['map_id'][]=$data[$key]['id'];
		}
	}else
		$res=NULL;
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
function getMapSize($typeMap='map_joueur'){
	if($typeMap=='map_joueur'){
		$res['width']=$largeur=20;
		$res['height']=$hauteur=20;
	}else{
		if($typeMap=='map_monde'){
			$res['width']=60;
			$res['height']=60;
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
	//connect('jeu','localhost','kirub','blabla');
	
	$largeur=20;
	$hauteur=20;
	$type='normal';
	$tiles=getTileset();
	
	//---------------------- à utiliser pour créer la map ---------------------------------------------//
	$map=createMapWithTiles($tiles[$type],$type,$largeur,$hauteur);
	/*	
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
	}*/
	$mapid='';
	$newpath="C:/Program Files/EasyPHP1-8/www/map/".$_POST['register'][4].".png";
	/*imagepng($im,$newpath);
	$im=imagecreatefrompng($newpath);
	imagealphablending ($im, TRUE)."<br />";
	*/for($i=0;$i<$largeur;$i++){
		for($j=0;$j<$hauteur;$j++){
			foreach( $tiles[$type] as $key => $value){
				if( ($map[$i][$j]==$key) ){
					if($i==0 && $j==0)
						$mapid=$tiles[$type][$key]['id'];
					else
						$mapid=$mapid.'-'.$tiles[$type][$key]['id'];
					/*imagealphablending ($tiles[$type][$key]['image'], TRUE);
					imagecopymerge($im,$tiles[$type][$key]['image'],$j*16,$i*16,0,0,16,16,100); 
					$transp = imagecolorallocate($im, 0, 0, 0);
					imagecolortransparent($im, $transp); // On rend le fond noir transparent*/
				}
			}
		}
	}/*
	$color=imagecolorsforindex($im,imagecolorat($tiles[$type]['montagne 2']['image'],0,0));
	imagecolortransparent($im,imagecolorallocate($im,$color['red'],$color['green'],$color['blue']));
	imagesavealpha ($im, FALSE);
	imagepng($im,$newpath);
	
	*/
	$sql="SELECT MIN(x) FROM map WHERE BORDER=0";
	if($req=mysql_query($sql)){
		$data=mysql_fetch_assoc($req);
		$xmin=$data['MIN(x)'];
	}else
	{
		$xmin=0;
	}
	$sql="SELECT MIN(y) FROM map WHERE BORDER=0";
	if($req=mysql_query($sql)){
		$data=mysql_fetch_assoc($req);
		$ymin=$data['MIN(y)'];
	}else
	{
		$ymin=0;
	}
	$pos=$cardinal[array_rand($cardinal=array("NORTH","SUD","EST","OUEST"))];
	$sql="SELECT MAX(x) FROM map WHERE BORDER=0";
	if($req=mysql_query($sql)){
		$data=mysql_fetch_assoc($req);
		$xmax=$data['MAX(x)'];
	}else
	{
		$xmax=0;
	}
	$sql="SELECT MAX(y) FROM map WHERE BORDER=0";
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
		
		$sql="INSERT INTO `map` (`joueur_id` , `name` , `path` , `x` , `y` , `compo` , `BORDER` )
VALUES (
'0', NULL , NULL , '".($x)."', '".($y-1)."', '19-119-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19', '1')";
	
	}
	if($pos=="SUD"){
		$y=$ymax+1;
		$x=rand($xmin,$xmax);
		
		$sql="INSERT INTO `map` (`joueur_id` , `name` , `path` , `x` , `y` , `compo` , `BORDER` )
VALUES (
'0', NULL , NULL , '".($x)."', '".($y+1)."', '19-119-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19', '1')";
	}
	if($pos=="EST"){
		$x=$xmax+1;
		$y=rand($ymin,$ymax);
		
		$sql="INSERT INTO `map` (`joueur_id` , `name` , `path` , `x` , `y` , `compo` , `BORDER` )
VALUES (
'0', NULL , NULL , '".($x+1)."', '".($y)."', '19-119-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19', '1')";
	}
	if($pos=="OUEST"){
		$x=$xmin-1;
		$y=rand($ymin,$ymax);
		
		$sql="INSERT INTO `map` (`joueur_id` , `name` , `path` , `x` , `y` , `compo` , `BORDER` )
VALUES (
'0', NULL , NULL , '".($x-1)."', '".$y."', '19-119-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19-19', '1')";
	}
	$req=mysql_query($sql);
	$sql='DELETE FROM map WHERE x='.$x.' and y='.$y; 
	$req=mysql_query($sql);
	

	$sql="SELECT id FROM joueurs where pseudo='".$_POST['register'][2]."'";
	$req=mysql_query($sql) or die(mysql_error());
	$data2=mysql_fetch_assoc($req);
	$sql="INSERT INTO map ( joueur_id , name , x , y , compo ) VALUES (".$data2['id'].",'".$_POST['register'][4]."',".$x.",".$y.",'".$mapid."')";
	mysql_query($sql) or die(mysql_error());
	
	
		
}
//}
//echo "<IMG SRC=affichage_map.php ALT='map du joueur'TITLE='map du joueur'>";

?>
