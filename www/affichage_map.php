<?php session_start();

header ("Content-type: image/png;Pragma: no-cache");

 
//print_r($_SESSION['map']);
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
foreach($_SESSION['map']['compo'] as $key => $value){
		//foreach($_SESSION['map']['compo'][$key] as $value2){
			
			if($a>=$_SESSION['map']['width']){
				$i++;
				$a=0;
			}						
			$paintTile=true;

			foreach($_SESSION['map']['batiments'] as $key2 => $value2){
				if( 	($a>= ( $_SESSION['map']['batiments'][$key2]['x']-floor($_SESSION['map']['batiments'][$key2]['width']/2)	)  ) && 
						($a<= ( $_SESSION['map']['batiments'][$key2]['x']+floor($_SESSION['map']['batiments'][$key2]['width']/2)+1)  ) && 
						($i>= ( $_SESSION['map']['batiments'][$key2]['y']-$_SESSION['map']['batiments'][$key2]['height']+1		)  ) && 
						($i<= ( $_SESSION['map']['batiments'][$key2]['y']+1 ) ) )
				{
						$paintTile=false;
				}
			}
			  
			  
			
			if($value!=$_SERVER['DOCUMENT_ROOT'].'/ressources/plaine.PNG' && $paintTile==true){
				$im=imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$value);
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
				if(isset($_GET['option']) && $_GET['option']=='quad')
					imagerectangle($image,$a*16,$i*16,($a+1)*16,($i+1)*16,imagecolorallocate($image,0,0,255));
				imagedestroy($im);
				if(strpos($map_id,"map_monde")!=FALSE)
					imagedestroy($im2);
			}
			
			//$j++;
			$a++;
	//	}
	//	$j=0;
}

if(strpos($map_id,"map_monde")==FALSE && $_SESSION['map']['batiments']!=NULL){					
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
