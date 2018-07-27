<?php		//		script		concert_del_main.php	
	
	//page pour supprimer un concert

	require_once('inclusion/configuration.php');
	$page_titre ="Confirmation de suppression d'un concert";
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
	if ((isset($_GET['concert'])) && (is_numeric($_GET['concert']))) {
		require_once('../../littles_connection.php');
		if ($_GET['concert'] == 0) {	//suppression des concerts passés
			//creation date
			$aujour = time();
			$ladate = date('Y.m.d',$aujour);
			$q = "DELETE FROM concerts WHERE concert_date < '$ladate'";
			$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
			if (mysqli_affected_rows($dbc)>=1) {
				$mess = "Tous les anciens concerts déjà réalisés, ont été supprimés de la base de données.";
			} else {
				$mess = "Aucun concert n'a été supprimé de la base de données.";
			}
		} else {
			$id = $_GET['concert'];
			//retrouver les données du concert
			$q= "SELECT DATE_FORMAT(concert_date,'%d-%m-%Y') AS jour, ville, lieux FROM concerts WHERE id = $id";
			$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
			if (mysqli_affected_rows($dbc)==1) {
				$row = @mysqli_fetch_array($r, MYSQLI_ASSOC);
				$text_concert = $row['jour'] . ' à ' . $row['ville'];
				//supprimer le concert
				$q = "DELETE FROM concerts WHERE id = $id LIMIT 1";
				$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
				if (mysqli_affected_rows($dbc)>=1) {
					$mess = "Le concert de " . $text_concert . " a été supprimé avec succès.";
				} else {
					$mess = "Une erreur s'est produite.";
				}
			} else {
				$mess = "Une erreur s'est produite.";
			}
		}
		mysqli_close($dbc);
	} else {
		//pas de concert id on retourne à l'index
		$url = BASE_URL . 'index.php';
		header("Location: $url");
		exit();//quitter le script
	}
	echo '<h1>Suppression d\'un concert</h1><h3>' . $mess . '</h3>';
	include('inclusion/pied.php');
?>