<?php		//		script		concert_del.php	
	
	//page pour supprimer un concert

	require_once('inclusion/configuration.php');
	$page_titre ="Supprimer un concert";
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
		$url = BASE_URL . 'concert_del_main.php?concert=' . $_POST['concert'];
		header("Location: $url");
		exit();//quitter le script
	}
	require_once('../../littles_connection.php');
	$q= "SELECT id, DATE_FORMAT(concert_date,'%d-%m-%Y') AS jour, ville, lieux FROM concerts ORDER BY concert_date";
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	echo '<h1>Supprimer un concert</h1>';
	echo '<p>Choisissez le concert à supprimer de la base de données :</p><br />';
	echo '<form action="concert_del.php" method="post" onSubmit="if(confirm(\'Voulez-vous vraiment supprimer cette entrée ?\')) return true; else return false;"><fieldset><p><b>Concerts à supprimer :</b></p>
	<select name="concert">
	<option value="0">Tous les concerts déjà réalisés</option>';
	while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC))
	{
		echo '<option value="' . $row['id'] . '">Concert du ' . $row['jour'] . ' à ' . $row['ville'] .'</option>';
	}
	
	mysqli_free_result($r);
	mysqli_close($dbc);
	echo '</select><div align="center"><input type="submit" value="Supprimer" /></div><input type="hidden" name="submitted" value="TRUE" /></fieldset></form>';
	include('inclusion/pied.php');
?>