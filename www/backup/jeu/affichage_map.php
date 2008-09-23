<?php @session_start();


header ("Content-type: image/png");
$path=$_SESSION['map'][$_GET['id']];
//$path='"'.$get.'"';//.$name";
$im=imagecreatefrompng($path);
if(isset($_GET['typeMap'])){
	$image=imagecreatetruecolor(8,8);
	imagecopyresized($image,$im,0,0,0,0,8,8,16,16);
	imagedestroy($im);
	$im=$image;
}
$transp = imagecolorallocate($im, 0, 0, 0);
imagecolortransparent($im, $transp);
imagepng($im);
//imagedestroy($im);


?>
