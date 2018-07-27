<?php		//		script		photo_del_main.php	
	
	//page pour supprimer un concert

	require_once('inclusion/configuration.php');
	$page_titre ="Confirmation de suppression d'une photographie";
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
	
	//verification que l'on a une valeur passée
	if ((isset($_GET['photo'])) && (is_numeric($_GET['photo']))) {
		require_once('../../littles_connection.php');
		$pid = $_GET['photo'];
		// verifier que l'on a une photo
		$q = "SELECT image FROM images WHERE id = $pid LIMIT 1";
		$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
		if (mysqli_num_rows($r) == 1) {//on un resultat
			$row = @mysqli_fetch_array($r, MYSQLI_ASSOC);
			$mess = $row['image'];
			mysqli_free_result($r);
			$q = "DELETE FROM images WHERE id = $pid LIMIT 1";
			$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
			if (mysqli_affected_rows($dbc)==1) { //entrée enmlever de la base de données
				//supprimer le fichier sur le disque
				$fichier = '../images/' . $mess;
				$thumb = '../images/' . get_thumb_name($mess);
				if (file_exists($fichier)) {
					unlink($fichier);
				}
				if (file_exists($thumb)) {
					unlink($thumb);
				}
				$entete = 'La photographie &quot;' . $mess . '&quot; a été supprimée avec succès.';
			} else {
				echo '<p class="error">La photographie n\'a pas pu être supprimée de la base de données.</p>';
			}
		} else {
			echo '<p class="error">Il n\'y a aucune photographie dans la base de données correspondante à votre choix.</p>';
		}	//FIN DE 	if (mysqli_num_rows($r) == 1) {//on un resultat
	} else {
		//pas de photo id on retourne à l'index
		$url = BASE_URL . 'index.php';
		header("Location: $url");
		exit();//quitter le script
	}
	echo '<h1>Suppression d\'une photographie</h1>';
	if (isset($entete)) {
		echo '<h3>' . $entete .'</h3>';
	}
	include('inclusion/pied.php');
?>