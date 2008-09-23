<?php
$cache_type='not defined';
$language_type='not defined';

function cache_create($id,$content){
	$file=fopen($_SERVER['DOCUMENT_ROOT'].'/temp/'.$id,'a+');
	fputs($file,$content,sizeof($content));
	fclose($file);
}
function cache_read($id){
	$res='file does not exist!';
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/temp/CACHE_'.encode($id).'.tmp')){
		$file=fopen($_SERVER['DOCUMENT_ROOT'].'/temp/CACHE_'.ecndeo($id).'.tmp',r);
		$buffer='';
		while(!feof($file))
			$buffer+=fgets($file);
		fclose($file);
		$res=$buffer;
	}
	define ("TO_CACHED",true);
	return $res;
}

function cache_createWith($with,$ressource,$path){
if($with='GD')
	imagepng($ressource,$path);

}
function cache_setType($callback_function,$language_type){
$arg='arg';
$start=strpos($callback_function,"(");
$end=strpos($callback_function,")");
$function=substr($res,0,$res-1);

while(strpos($callback_function,',')){
	if(!$comma_pos=strpos($callback_function,",",$start));
		$comma_pos=$end;
	if(!strpos(substr($callback_function,$start,$comma_pos-$start),"Array"))
		$res2[i]=substr($callback_function,$start+1,$comma_pos-$start);
	else
		$res2[i]=explode(",",substr($callback_function,$start,$comma_pos-$start));
	$callback_function=substr($callback_function,$comma_pos);
	$i++;
	$start=$comma_pos;
}
echo "$function($res2[0],$res2[1],$res2[2],$res2[3]);";

}
function encode($name){
return md5($name);
}
function cache_start(){
echo cache_read(encode($_SERVER['SCRIPT_NAME'].session_id()));
}
function cache_end(){
if(defined("TO_CACHED")){
	if($cache_type=='not defined'){
		echo '<script>HTTPReq(\'cache\',null,$_SERVER['SCRIPT_NAME'],\'<cache>\')/script>';
		cache_create(encode($_SERVER['SCRIPT_NAME'].session_id()),'blabla');//<script>HTTPReq(\'cache\',null,$_SERVER['SCRIPT_NAME'],\'<cache>\')/script>";);
	}
	define("TO_CACHED",false);
}
else
	echo "<br />undefined data to cache, please use cache_start() before script...<br />";
}










/*function cache_get_cached_version ($id) {
	  // HACK: Ignore memory requests if our OS doesn't
	  // support memory functions
	  if($id[0] == 'M' && !function_exists('shmop_open')) {
		$id[0] = 'F';
		}
	  // Determine where we should dispatch the call
	  switch ($id[0]) {
		case 'F' :
		  // This item was cached via file
		  $cache = cache_disk_get_cached_version ($id);
		  break;
		case 'M' :
		  // This item was cached via shared memory
		  $cache = cache_shm_get_cached_version ($id);
		  break;
		default :
		  // Nothing useful... raise an error and bail out
		  //user_error("Unknown cache ID token '{$id}'", E_ERROR);
		  die("Unknown cache ID token '{$id}'");
		}
	  if ($cache && is_array($cache) && count($cache)==2) {
		// Now that we have the cached object,
		//let's make sure that it's still good
		if ($cache[0] <= time()) {
		  return $cache[1];
		} else {
		  return false;
		  }
	  } else {
		return false; // The cache failed
		}
}

	function cache_cache ($id, $value, $timeout){
	  // Prepare cache
	  $cache = array (time() + $timeout, $value);
	  // HACK: Ignore memory requests if our OS doesn't
	  // support memory functions
	  if ($id[0] == 'M' && !function_exists('shmop_open')) {
		$id[0] = 'F';
		}
	  // Determine where we should dispatch the call
	  switch ($id[0]) {
		case 'F' :
		  return cache_disk_cache ($id, $value);
		case 'M' :
		  return cache_shm_cache ($id, $value);
		default :
		  // Nothing useful... raise an error and bail out
		  user_error("Unknown cache ID token '{$id}'", E_ERROR);
		  die();
		}
  }

	function cache_shm_get_cached_version ($id) {
	  // Crée l’identifiant de la ressource
	  $id = crc32 ($id);
	
	  // pose le sémaphore
	  $sem = sem_get ($id, 1);
	
	  if (!is_resource($sem)) {
		// Nous n’avons pas le sémaphore
		// Le cache échoue
		return false;
		}
	
	  if (!sem_acquire ($sem)) {
		// Nous n’avons pas le sémaphore
		// Le cache échoue
		sem_remove ($sem);
		return false;
		}
	
	  // lecture du segment de mémoire
	  $shm = shmop_open ($id, 'a', 0, 0);
	  if (!$shm) {
		// impossible de lire le segment shm
		sem_release ($sem);
		sem_remove ($sem);
		return false;
		}
	
	  $value = @unserialize (shmop_read ($shm, 0, shmop_size ($shm)));
	
	  // Libération du segment de mémoire
	  shmop_close ($shm);
	
	  // effacement du sémaphore
	  sem_release ($sem);
	  sem_remove ($sem);
	  return $value;
  }

function cache_shm_cache ($id, $value) {
	  // creation de l’identifiant
	  $id = crc32 ($id);
	
	  // Linearisation de la valeur
	  $value = serialize ($value);
	  $value_length = strlen ($value);
	
	  //Pose du sémaphore de la ressource
	  $sem = sem_get ($id, 1);
	
	  if (!is_resource($sem)) {
		// erreur de sémaphore : on annule tout
		return false;
		}
	
	  // Acquisition du sémaphore
	  if (!sem_acquire ($sem)) {
		// impossible d’obtenir le sémaphore
		sem_remove ($sem);
		return false;
		}
	  $shm = shmop_open($id, "c", 0664, $value_length);
	
	  if (!$shm) {
		// Echec de l’ouverture
		sem_release ($sem);
		sem_remove ($sem);
		return false;
		}
	
	  // Ecriture des données en mémoire
	  shmop_write ($shm, $value, 0);
	
	  // Libération du segment de mémoire
	  shmop_close ($shm);
	
	  // Libération du sémaphore et fin
	  sem_release ($sem);
	  sem_remove ($sem);
	  return false;
  }
function cache_disk_lock ($id) {
  // Détermine le dossier verrou
  $dir = "$id.lock";

  // Essaie de créer le dossier
  while (!@mkdir ($dir));
  // Fin. Le verrou est posé
  }

function cache_disk_unlock ($id) {
  // Détermine le nom du verrou
  $dir = "$id.lock";

  // Essaie de supprimer le verrou
  @rmdir ($dir);

  // Fin. Le verrou est libre
  }

function cache_disk_get_cached_version ($id) {
  // Determine le nom du fichier
  $id = $_SERVER['DOCUMENT_ROOT'] . "/CACHEXXX" . md5($id) . ".cache";

  // Verrouille l’accès au fichier
  cache_disk_lock($id);

  // Accède au fichier
  $f = @fopen ($id, "r");

  if (!$f) {
    cache_disk_unlock($id);
    return false;
    }

  // Lit la valeur
  $result = unserialize (file_get_contents ($f));

  // Deverrouille le fichier
  cache_disk_unlock($id);

  // Retourne la valeur
  return $value;
  }

function cache_disk_cache ($id, $value) {
  // Determine le nom du fichier
  $id = $_SERVER['DOCUMENT_ROOT'] . "/CACHEXXX" .  md5($id) . ".cache";

  // Verrouille l’accès au fichier
  cache_disk_lock($id);

  // Accède au fichier
  $f = @fopen ($id, "w");

  if (!$f) {
    cache_disk_unlock();
    return false;
    }

  // Ecrit la valeur
  $value = serialize ($value);

  // Fin
  return true;
  }
if (defined ("CACHE_THIS_PAGE")) {
	function cache_ob_uniqueid() {
		return $_SERVER['REQUEST_URI'];
	}
	function cache_ob_handler ($buffer) {
		// Determine l’identifiant de la page
		$id = cache_ob_uniqueid();
		// met en cache cette valeur
		cache_cache ($id, $buffer, CACHE_TIMEOUT);
		return $buffer;
	}
	// Determine l’identifiant de la page
	$id = cache_ob_uniqueid();
	// Utilisez un delai d’expiration d’une heure
	if (!defined ("CACHE_TIMEOUT")) {
		@define (CACHE_TIMEOUT, 3600);
	}
	// Determine le type de cache
	if (!defined ("CACHE_TYPE")) {
		// Utilise les fichiers par défaut
		define ("CACHE_TYPE", "FILE");
	}
	switch (CACHE_TYPE) {
		case "FILE" :
		$id = "F" . $id;
		break;
		case "SHM" :
		$id = "M" . $id;
		break;
		default :
		// Affiche une erreur
		user_error ("Type de cache invalide " .
		CACHE_TYPE, E_ERROR);
		die();
	}
	// Vérifie si la version en cache existe
	if (($data = cache_get_cached_version($id))
	== false){
	// Ok, nous l’avons et elle est bonne
	// affichage et fin
	echo ($data);
	die();
	} else {
	// Le cache est invalide. Génération
	ob_start ("cache_ob_handler");
	}
	// Netoyage
	unset ($id);
	unset ($data);
}
?>*/