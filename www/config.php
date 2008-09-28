<?php

/* 
		fichier à inclure juste après le session_start() puisqu'il remplit le tableau de session avec des constantes qui compose le fichier config.xml
*/

function ouverture ($parser, $name, $attr){
	if(!empty($attr)){
		foreach($attr as $key => $value )
			$_SESSION[$name][$key]=$value;
	}
	
}
function fermeture ($parser, $name){
	if(isset($_SESSION[$name]))
	foreach($_SESSION[$name] as $key => $value )
		echo '$_SESSION['.$name.']['.$key.']='.$value."<BR>";
}


function texte ($parser, $data_text){
	
}

function defaut (){
	return TRUE;
}

$xml_parseur = xml_parser_create("iso-8859-1");
xml_set_element_handler($xml_parseur, "ouverture", "fermeture");
xml_set_character_data_handler($xml_parseur, "texte");
xml_set_default_handler($xml_parseur,"defaut");
xml_parser_set_option($xml_parseur, XML_OPTION_CASE_FOLDING,"iso-8859-1");
$fp = fopen("config.xml", "r") or die("
Fichier introuvable. L'analyse a ete suspendue");

while ($fdata = fread($fp, 2048)){
	xml_parse($xml_parseur, $fdata, feof($fp)) or die(
		sprintf("Erreur XML : %s à la ligne %d\n",
		xml_error_string(xml_get_error_code($xml_parseur)),
		xml_get_current_line_number($xml_parseur))
		);

}




?>
