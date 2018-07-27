<?php		// script		index.php
	//page principale du site
	//inclure le fichier de configuration
	require_once('inclusion/configuration.php');
	
	//mettre le titre de la page
	$page_titre = 'Bienvenue sur l\'interface de gestion administrative du site &quot;www.thelittles.fr&quot;';
	
	include('inclusion/entete.php');
	
	// acceuillir le visiteur
	echo '<h1>Bienvenue';
	if (isset($_SESSION['prenom'])) {
		echo ", {$_SESSION['prenom']} !";
	}
	echo '</h1>';
	if (isset($_SESSION['id'])) {
		echo "<h3>Vous êtes dans l'interface administrative du site.</h3><p>Veuillez choisir une action sur le menu de gauche...</p>";
		$_SESSION['menuID'] = 0;
	} else {
		echo "<p>Vous devez être connecté pour acceder à l'interface administrative du site.<br />Cliquez sur &quot;Connexion&quot;</p>";
	}

	include('inclusion/pied.php');
?>