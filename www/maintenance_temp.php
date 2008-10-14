<?php
/* 
		script réalisant la maintenance des fichiers présent dans le dossier /temp, suivant le temps de validité spécifié dans le fichier config.xml
*/


//clean($_SERVER['DOCUMENT_ROOT']."/temp/",$_SESSION['temporary']['expire']);



function clean ($directory,$available_time){

    //Get each file and add its details to two arrays
    $res = array();
    $handler = opendir($directory);
    while ($file = readdir($handler)) { 
        if ($file != '.' && $file != '..' && $file != "robots.txt" && $file != ".htaccess"){
            $currentModified = filectime($directory."/".$file);
			if($currentModified <=$available_time){
				unlink($_SERVER['DOCUMENT_ROOT']."/temp/".$file);
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
	return date("r",$_SESSION['temporary']['expire']);
}

?>
