<?php //empeche de voir les fichier retourne à l'accueil
	$url = '../../accueil.html';
	header("Location: $url");
	exit();
?>