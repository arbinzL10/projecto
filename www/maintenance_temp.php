<?php
/* A insérer dans un fichier de config :
	- $_SESSION['config']['temporary']['available_time'] = temps en heure de validité des images
*/

$_SESSION['config']['temporary']['available_time']=5;
$available_time=mktime(date("H")-$_SESSION['config']['temporary']['available_time'],date("i"),date("s"),date("m"),date("d"),date("y"));
clean("C:/Program Files/EasyPHP1-8/www/temp/",$available_time);



function clean ($directory,$available_time){

    //Get each file and add its details to two arrays
    $res = array();
    $handler = opendir($directory);
    while ($file = readdir($handler)) { 
        if ($file != '.' && $file != '..' && $file != "robots.txt" && $file != ".htaccess"){
            $currentModified = filectime($directory."/".$file);
			if($currentModified <=$available_time){
				unlink("C:/Program Files/EasyPHP1-8/www/temp/".$file);
			   	$res[$file] = $currentModified;
			}
			//$res[$file] = $currentModified;
        }   
    }
    closedir($handler);

    //Sort the date array by preferred order
    asort($res);
    //return $res;

}

function timeOfValidity(){
	return date("r",$_SESSION['config']['temporary']['available_time']);
}

?>
