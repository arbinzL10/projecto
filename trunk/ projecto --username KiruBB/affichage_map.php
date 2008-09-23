<?php @session_start();
header ("Content-type: image/png");
//print_r($_SESSION['map']);

$map_id=$_GET['id'];
if(!file_exists("C:/Program Files/EasyPHP1-8/www/temp/".$map_id)){
$i=0;
$j=0;
$a=0;
//$path='"'.$get.'"';//.$name";
$im=imagecreatefrompng("C:/Program Files/EasyPHP1-8/www/ressources/plaine.PNG");
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
			if($value!='C:/Program Files/EasyPHP1-8/www/ressources/plaine.PNG'){
				$im=imagecreatefrompng($value);
				$tile_square=array(
										$a*16		,	$i*16,
										$a*16		,	($i+1)*16,
										($a+1)*16 	,	($i+1)*16,
										($a+1)*16 	,	$i*16,
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
										($a+1)*8 	,	$i*8,
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
				if($_SESSION['map']['option']=='quad')
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


/*if(isset($_GET['typeMap'])){
	$image=imagecreatetruecolor(12,12);
	imagecopyresized($image,$im,0,0,0,0,12,12,16,16);
	imagedestroy($im);
	$im=$image;
}
$transp = imagecolorallocate($im, 0, 0, 0);
imagecolortransparent($im, $transp);*/
imagejpeg($image,"C:/Program Files/EasyPHP1-8/www/temp/".$map_id);
//imagepng($image);
imagedestroy($image);
}
$im=imagecreatefromjpeg("C:/Program Files/EasyPHP1-8/www/temp/".$map_id);
imageinterlace($im,1);
imagejpeg($im);
imagedestroy($im);

?>
