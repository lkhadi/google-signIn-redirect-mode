<?php
	//must start the session first
	session_start();
	include 'auth.php';
	$object = new auth;
	echo $object->getRefreshToken();
	echo '<br><h2>New Access</h2>';
	print_r($object->getNewAccess());
?>