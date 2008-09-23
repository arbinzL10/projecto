<?php
$xml = simplexml_load_file("config.xml");
foreach($xml->BDD as $item) {
	$_SESSION['BDD'][$item]=$item->host;
	$item->BDD->name;
	$item->BDD->login;
	$item->BDD->password;
echo '<h1><a href='.utf8_decode($item->link).'>'.utf8_decode($item->title).'</a></h1>'.utf8_decode($item->description);
}




?>