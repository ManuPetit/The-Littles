<?php		//	script		logout.php
	//script de deconnexion
	
	require_once('inclusion/configuration.php');
	$page_titre = 'Déconnexion';
	include('inclusion/entete.php');
	
	//pas de session redirection
	if (!isset($_SESSION['prenom'])) {
		$url = BASE_URL . 'index.php';
		ob_end_clean();
		header("Location: $url");
		exit();
	} else {	//utilisateur connecté
		$_SESSION = array(); 	//détruire variables de sessions
		session_destroy();		//détruire la session
		setcookie(session_name(),'',time()-300);	//détruire le cookie
	}
	//message de confirmation
	echo '<h3>Vous êtes maintenant déconnecter de l\'interface d\'administration du site &quot;www.thelittles.fr&quot;.';
	
	include('inclusion/pied.php');
?>
	