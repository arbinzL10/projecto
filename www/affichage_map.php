<?php session_start();

//header ("Content-type: image/png;Pragma: no-cache");

//include 'pathfinding.php';
 
//print_r($_SESSION['map']['desc']);
/*?>
<script>execute('maintenance_temp.php');
</script><?php 
*/$map_id=$_GET['id'];
if(!file_exists($_SERVER['DOCUMENT_ROOT']."/temp/".$map_id)){
$i=0;
$j=0;
$a=0;
//$path='"'.$get.'"';//.$name";
$im=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/plaine.PNG");
if(strpos($map_id,"map_monde")!=FALSE){
	$im2=imagecreatetruecolor(8,8);
	$image=imagecreatetruecolor(8*$_SESSION['map']['width'],8*$_SESSION['map']['height']);
	imagecopyresized($im2,$im,0,0,0,0,8,8,16,16);
	imagesettile($image,$im2);

	//$im=$im2;
	//imagedestroy($im2);
}
else{
	$image=imagecreatetruecolor(16*20,16*20);
	imagesettile($image,$im);
}
imagefill($image,0,0,IMG_COLOR_TILED);
foreach($_SESSION['map']['desc'] as $key => $value){

		//foreach($_SESSION['map']['compo'][$key] as $value2){
			
			if($a>=$_SESSION['map']['width']){
				$i++;
				$a=0;
			}						
			$paintTile=true;

			if($_SESSION['map']['batiments']!=NULL){
				foreach($_SESSION['map']['batiments'] as $key2 => $value2){
					if( 	($a>= ( $_SESSION['map']['batiments'][$key2]['x']-floor($_SESSION['map']['batiments'][$key2]['width']/2)	)  ) && 
							($a<= ( $_SESSION['map']['batiments'][$key2]['x']+floor($_SESSION['map']['batiments'][$key2]['width']/2))  ) && 
							($i>= ( $_SESSION['map']['batiments'][$key2]['y']-$_SESSION['map']['batiments'][$key2]['height']+1		)  ) && 
							($i<= ( $_SESSION['map']['batiments'][$key2]['y'] ) ) )
					{
							$paintTile=false;
					}
				}
			}
			/*if($paintTile){
				if($_SESSION['map']['unit']!=NULL){
					foreach($_SESSION['map']['unit'] as $key2 => $value2){
						if( 	($a>= ( $_SESSION['map']['unit'][$key2]['x']-floor($_SESSION['map']['unit'][$key2]['width']/2)	)  ) && 
								($a<= ( $_SESSION['map']['unit'][$key2]['x']+floor($_SESSION['map']['unit'][$key2]['width']/2))  ) && 
								($i>= ( $_SESSION['map']['unit'][$key2]['y']-$_SESSION['map']['unit'][$key2]['height']+1		)  ) && 
								($i<= ( $_SESSION['map']['unit'][$key2]['y'] ) ) )
						{
								$paintTile=false;
						}
					}
				} 
			}*/ 
			  
			
			if($value!=$_SERVER['DOCUMENT_ROOT'].'/ressources/plaine.PNG' && $paintTile==true){
				$im=imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$value['compo']);
				$tile_square=array(
										$a*16		,	$i*16,
										$a*16		,	($i+1)*16,
										($a+1)*16 	,	($i+1)*16,
										($a+1)*16 	,	$i*16
									);
				if(strpos($map_id,"map_monde")!=FALSE){
					$im2=imagecreatetruecolor(8,8);
					imagecopyresized($im2,$im,0,0,0,0,8,8,16,16);
					//$im=$im2;
					//imagedestroy($im2);
					$tile_square=array(
										$a*8		,	$i*8,
										$a*8		,	($i+1)*8,
										($a+1)*8 	,	($i+1)*8,
										($a+1)*8 	,	$i*8
									);
					imagesettile($image,$im2);
					$transp = imagecolorallocate($im2, 0, 0, 0);
					imagecolortransparent($im2, $transp);
				}else{
					imagesettile($image,$im);
					$transp = imagecolorallocate($im, 0, 0, 0);
					imagecolortransparent($im, $transp);
				}
				
				imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
				if($value['joueur_id']!=$_SESSION['identify']['id']){
					$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/fog.png");
					imagesettile($image,$im3);
					$transp = imagecolorallocate($im3, 0, 0, 0);
					imagecolortransparent($im3, $transp);
					imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
					imagedestroy($im3);
				}
				else
				{
				
					$im3=NULL;
					if(($key)%$_SESSION['map']['width']!=0 ){
						if($_SESSION['map']['desc'][$key-1]['joueur_id']!=$_SESSION['identify']['id']){
							if($key-($_SESSION['map']['width'])>=0){
								if($_SESSION['map']['desc'][$key-($_SESSION['map']['width'])]['joueur_id']!=$_SESSION['identify']['id'])
									$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/territoire_limite_haut_gauche.png");
							}
							if($im3==NULL)
							{
								if($key<($_SESSION['map']['width']*$_SESSION['map']['height'])-$_SESSION['map']['width']){
									if($_SESSION['map']['desc'][$key+($_SESSION['map']['width'])]['joueur_id']!=$_SESSION['identify']['id']){
										$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/territoire_limite_bas_gauche.png");
									}
								}
								if($im3==NULL)
								{
									$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/territoire_limite_gauche.png");
								}
								
							}
						}
					}

					if((1+$key)%20!=0 && $im3==NULL){														
						if($_SESSION['map']['desc'][$key+1]['joueur_id']!=$_SESSION['identify']['id'] ){	

							if($key-($_SESSION['map']['width'])>=0){
								if($_SESSION['map']['desc'][$key-($_SESSION['map']['width'])]['joueur_id']!=$_SESSION['identify']['id']){
									$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/territoire_limite_haut_droite.png");
								}
							}
							if($im3==NULL)
							{

								if($key<($_SESSION['map']['width']*$_SESSION['map']['height'])-$_SESSION['map']['width']){
									if($_SESSION['map']['desc'][$key+($_SESSION['map']['width'])]['joueur_id']!=$_SESSION['identify']['id']){ 
										$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/territoire_limite_bas_droite.png");
									}
								}
								if($im3==NULL)
								{

									$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/territoire_limite_droite.png");
								}
								
								
							}
						}
					}
					if($key>$_SESSION['map']['width'] && $im3==NULL){
						if($_SESSION['map']['desc'][$key-($_SESSION['map']['width'])]['joueur_id']!=$_SESSION['identify']['id']){
							$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/territoire_limite_haut.png");
						}
					}
					if($key<($_SESSION['map']['width']*$_SESSION['map']['height'])-$_SESSION['map']['width'] && $im3==NULL){
						if($_SESSION['map']['desc'][$key+($_SESSION['map']['width'])]['joueur_id']!=$_SESSION['identify']['id']){
							$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/territoire_limite_bas.png");
						}
					}
					if($im3!=NULL){
						imagesettile($image,$im3);
						$transp = imagecolorallocate($im3, 0, 0, 0);
						imagecolortransparent($im3, $transp);
						imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
						imagedestroy($im3);
					}
				}
				
				
				if(isset($_SESSION['map']['chemin'])){
					$path=$_SESSION['map']['chemin'];
					if($path!=NULL){
						$im3=NULL;
						foreach($path as $key => $value){
							if($value!=''){
								if($a==$value['x'] && $i==$value['y'] ){
									if(isset($path[$key+1])){
										if($path[$key+1]['x'] < $a ){
											if($path[$key+1]['y'] < $i ){
												$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/move_haut_gauche.png");
											}
											else
											{
												if($path[$key+1]['y'] > $i ){
													$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/move_bas_gauche.png");	
												}
												else
												{
													$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/move_gauche.png");
												}
											}
										}
										else
										{
											if($path[$key+1]['x'] > $a ){
												if($path[$key+1]['y'] < $i ){
													$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/move_haut_droite.png");
												}
												else
												{
													if($path[$key+1]['y'] > $i ){
														$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/move_bas_droite.png");					
													}
													else
													{
														$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/move_droit.png");
									
													}
												}
											
											}
											else
											{
												if($path[$key+1]['y'] < $i ){
													$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/move_haut.png");					
												}
												else
												{
													if($path[$key+1]['y'] > $i ){
														$im3=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/move_bas.png");
													}
												}
											}
										}
									}
								}
							}
						}
						if($im3!=NULL){
							imagesettile($image,$im3);
							$transp = imagecolorallocate($im3, 0, 0, 0);
							imagecolortransparent($im3, $transp);
							imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
							imagedestroy($im3);
						}
					}
				}
				

				if($_SESSION['map']['option']['quad']==true)
					imagerectangle($image,$a*16,$i*16,($a+1)*16,($i+1)*16,imagecolorallocate($image,0,0,255));
				imagedestroy($im);
				if(strpos($map_id,"map_monde")!=FALSE)
					imagedestroy($im2);
				
				if($_SESSION['map']['unit']!=NULL){
					if(isset($_SESSION['map']['unit'][$a][$i])){
					//foreach($_SESSION['map']['unit'] as $key => $value){
						$im=imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$_SESSION['map']['unit'][$a][$i]['path']);
						
						
						/*$tile_square=array(
									$_SESSION['map']['unit'][$key]['x']*16			,	$_SESSION['map']['unit'][$key]['y']*16		,
									$_SESSION['map']['unit'][$key]['x']*16			,	($_SESSION['map']['unit'][$key]['y']+1)*16	,
									($_SESSION['map']['unit'][$key]['x']+1)*16		,	($_SESSION['map']['unit'][$key]['y']+1)*16	,
									($_SESSION['map']['unit'][$key]['x']+1)*16 	,	$_SESSION['map']['unit'][$key]['y']*16
								);*/
						//$im3=imagecreatefrompng("C:/Program Files/EasyPHP1-8/www/ressources/plaine.PNG");
						//imagesettile($image,$im2);
						//imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
						$im2=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/blank.png");
						$transp=imagecolorallocate($im,0,0,0);
						imagecolortransparent($im,$transp);
						
						imagecopyresized($im2,$im,0,0,0,0,16,16,imagesx($im),imagesy($im));
						imagesettile($image,$im2);
						$transp=imagecolorallocate($im2,0,0,0);
						imagecolortransparent($im2,$transp);
						imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
						imagedestroy($im2);
			
						
						imagedestroy($im);
						
					
					//}
					}
				}
					
			}
			
			//$j++;
			$a++;
	//	}
	//	$j=0;
}

if(strpos($map_id,"map_monde")==FALSE){
	if($_SESSION['map']['batiments']!=NULL){					
		foreach($_SESSION['map']['batiments'] as $key => $value){
			$im=imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$_SESSION['map']['batiments'][$key]['path']);
			
			
			for($i=0;$i<$_SESSION['map']['batiments'][$key]['height'];$i++){
				for($j=0;$j<$_SESSION['map']['batiments'][$key]['width'];$j++){
					$tile_square=array(
								(($_SESSION['map']['batiments'][$key]['x']-floor($_SESSION['map']['batiments'][$key]['width']/2))+$j)*16	,	(($_SESSION['map']['batiments'][$key]['y']-$_SESSION['map']['batiments'][$key]['height']+1)+$i)*16,
								(($_SESSION['map']['batiments'][$key]['x']-floor($_SESSION['map']['batiments'][$key]['width']/2))+$j)*16	,	((($_SESSION['map']['batiments'][$key]['y']-$_SESSION['map']['batiments'][$key]['height']+1)+($i+1))*16)-1,
								((($_SESSION['map']['batiments'][$key]['x']-floor($_SESSION['map']['batiments'][$key]['width']/2))+$j+1)*16)-1	,	((($_SESSION['map']['batiments'][$key]['y']-$_SESSION['map']['batiments'][$key]['height']+1)+($i+1))*16)-1,
								((($_SESSION['map']['batiments'][$key]['x']-floor($_SESSION['map']['batiments'][$key]['width']/2))+($j+1))*16)-1 	,	(($_SESSION['map']['batiments'][$key]['y']-$_SESSION['map']['batiments'][$key]['height']+1)+$i)*16
							);
					//$im3=imagecreatefrompng("C:/Program Files/EasyPHP1-8/www/ressources/plaine.PNG");
					//imagesettile($image,$im2);
					//imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
					$im2=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/blank.png");
					$transp=imagecolorallocate($im,0,0,0);
					imagecolortransparent($im,$transp);
					
					imagecopyresampled($im2,$im,0,0,$j*16,$i*16,16,16,16,16);
					imagesettile($image,$im2);
					$transp=imagecolorallocate($im2,0,0,0);
					imagecolortransparent($im2,$transp);
					imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
					imagedestroy($im2);
				}
			}
			imagedestroy($im);
			
		
		}
	}
	/*if($_SESSION['map']['unit']!=NULL){					
		foreach($_SESSION['map']['unit'] as $key => $value){
			$im=imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$_SESSION['map']['unit'][$key]['path']);
			
			
			$tile_square=array(
						$_SESSION['map']['unit'][$key]['x']*16			,	$_SESSION['map']['unit'][$key]['y']*16		,
						$_SESSION['map']['unit'][$key]['x']*16			,	($_SESSION['map']['unit'][$key]['y']+1)*16	,
						($_SESSION['map']['unit'][$key]['x']+1)*16		,	($_SESSION['map']['unit'][$key]['y']+1)*16	,
						($_SESSION['map']['unit'][$key]['x']+1)*16 	,	$_SESSION['map']['unit'][$key]['y']*16
					);
			//$im3=imagecreatefrompng("C:/Program Files/EasyPHP1-8/www/ressources/plaine.PNG");
			//imagesettile($image,$im2);
			//imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
			$im2=imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/ressources/blank.png");
			$transp=imagecolorallocate($im,0,0,0);
			imagecolortransparent($im,$transp);
			
			imagecopyresized($im2,$im,0,0,0,0,16,16,imagesx($im),imagesy($im));
			imagesettile($image,$im2);
			$transp=imagecolorallocate($im2,0,0,0);
			imagecolortransparent($im2,$transp);
			imagefilledpolygon($image,$tile_square,4,IMG_COLOR_TILED);
			imagedestroy($im2);

			
			imagedestroy($im);
			
		
		}
	}*/
}
/*if(isset($_GET['typeMap'])){
	$image=imagecreatetruecolor(12,12);
	imagecopyresized($image,$im,0,0,0,0,12,12,16,16);
	imagedestroy($im);
	$im=$image;
}					
						($_SESSION['map']['batiments'][$key]['x']-floor($_SESSION['map']['batiments'][$key]['width']/2))*16		,	($_SESSION['map']['batiments'][$key]['y']-$_SESSION['map']['batiments'][$key]['height']+1)*16,
						($_SESSION['map']['batiments'][$key]['x']-floor($_SESSION['map']['batiments'][$key]['width']/2))*16		,	($_SESSION['map']['batiments'][$key]['y']+1)*16,
						($_SESSION['map']['batiments'][$key]['x']+1+floor($_SESSION['map']['batiments'][$key]['width']/2))*16 	,	($_SESSION['map']['batiments'][$key]['y']+1)*16,
						($_SESSION['map']['batiments'][$key]['x']+1+floor($_SESSION['map']['batiments'][$key]['width']/2))*16 	,	($_SESSION['map']['batiments'][$key]['y']-$_SESSION['map']['batiments'][$key]['height']+1)*16
$transp = imagecolorallocate($im, 0, 0, 0);
imagecolortransparent($im, $transp);*/
imagejpeg($image,$_SERVER['DOCUMENT_ROOT']."/temp/".$map_id);
//imagepng($image);
imagedestroy($image);
}
$im=imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT']."/temp/".$map_id);
imageinterlace($im,1);
imagejpeg($im);
imagedestroy($im);



?>
