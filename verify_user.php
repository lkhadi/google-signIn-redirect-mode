<?php 
	include 'auth.php';
	$object = new auth;
	$object->verification($_GET['code']);
?>