<?php		// script		concert.php
	//page principale des concerts
	//inclure le fichier de configuration
	require_once('inclusion/configuration.php');
	
	//mettre le titre de la page
	$page_titre = 'Menu concerts';
	
	include('inclusion/entete.php');
	//pas de session redirection
	if (!isset($_SESSION['prenom'])) {
		$url = BASE_URL . 'index.php';
		ob_end_clean();
		header("Location: $url");
		exit();
	}
	
	echo '<h1>Menu concerts</h1>';
	$_SESSION['menuID'] = 1;
	
	echo '<p>Vous êtes dans la section concert. Veuillez choisir une action sur le menu de droite...</p>';

	include('inclusion/pied.php');
?>