<?php		//script 	concert_mod.php

	require_once('inclusion/configuration.php');
	$page_titre ="Modifier un concert";
	include('inclusion/entete.php');
	
	// VERIFICATION DE SECURITE
	//si il n'y a aucun utilisateur enregistré redirigé la page
	if (!isset($_SESSION['id']))
	{
		$url = BASE_URL . 'index.php';
		ob_end_clean();//supprimer le buffer
		header("Location: $url");
		exit();//quitter le script
	}
	
	if (isset($_POST['submitted'])) {
		//rediriger
		$url = BASE_URL . 'concert_mod_main.php?concert=' . $_POST['concert'];
		header("Location: $url");
		exit();//quitter le script
	}
	//date du jour
	$aujour = time();
	$ladate = date('Y.m.d',$aujour);
	$au_day = date('d',$aujour);
	$au_month = date('m',$aujour);
	$au_year = date('Y',$aujour);
	$au_date = mktime(0,0,0,$au_month,$au_day,$au_year);
	
	require_once('../../littles_connection.php');
	$q= "SELECT id, DATE_FORMAT(concert_date,'%d-%m-%Y') AS jour, ville, lieux FROM concerts WHERE concert_date >= '$ladate' ORDER BY concert_date";
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	echo '<h1>Supprimer un concert</h1>';
	echo '<p>Choisissez le concert que vous voulez modifier :</p><br />';
	echo '<form action="concert_mod.php" method="post"><fieldset><p><b>Liste des concerts :</b></p>
	<select name="concert">';
	while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC))
	{
		echo '<option value="' . $row['id'] . '">Concert du ' . $row['jour'] . ' à ' . $row['ville'] .'</option>';
	}
	
	mysqli_free_result($r);
	mysqli_close($dbc);
	echo '</select><div align="center"><input type="submit" value="Modifier le concert" /></div><input type="hidden" name="submitted" value="TRUE" /></fieldset></form>';
	include('inclusion/pied.php');
?>