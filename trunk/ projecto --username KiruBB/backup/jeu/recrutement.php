<?php 
session_start(); 
include('functions_nico.php');
recruter($_SESSION['id'], $_POST['unit'], $_POST['nbunit']);

?>