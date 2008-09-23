<?php 
session_start(); 
include('functions_nico.php');
construire($_SESSION['identify']['id'], $_POST['batiment'], $_POST['nbbat']);

?>