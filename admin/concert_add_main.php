<?php		//		script		concert_add_main.php	
	
	//page pour créer une animation

	require_once('inclusion/configuration.php');
	$page_titre ="Cr&eacute;ation d'un nouveau concert";
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
	
	//on verifie si une date est passée
	if ((isset($_GET['ladate'])) && (!is_null($_GET['ladate'])))
	{
		$ladate = $_GET['ladate'];
	} else if ((isset($_POST['ladate'])) && (!is_null($_POST['ladate']))) {
		$ladate = $_POST['ladate'];
	}
	else
	{
		//pas de date on retourne à l'index
		$url = BASE_URL . 'index.php';
		header("Location: $url");
		exit();//quitter le script
	}
	//preparer les variables du jour
	$lejour = get_jour($ladate);
	$jour = date('d',$ladate);
	$lemois = get_mois($ladate);
	$annee = date('Y',$ladate);
	$date_comp = 'le ' . $lejour . ' ' . $jour . ' ' . $lemois . ' ' . $annee;
	

	echo '<h1>Création d\'un concert ' . $date_comp . '</h1>';
	
	if (isset($_POST['submitted'])) {
		
		$v = $l =FALSE;
		
		require_once('../../littles_connection.php');
		//validation de la ville et du lieu
		if (preg_match('/^[a-zA-Z éèàçâêîôû\'-]{3,50}$/i',trim($_POST['ville'])))
		{
			$v =  mysqli_real_escape_string($dbc,trim($_POST['ville']));
		}
		else
		{
			echo '<p class="error">Veuillez entrer le nom de la ville correctment.</p>';
		}
		if (preg_match('/^[a-zA-Z0-9 éèàçâêîôû\'?]{3,60}$/i',trim($_POST['lieu'])))
		{
			$l =  mysqli_real_escape_string($dbc,trim($_POST['lieu']));
		}
		else
		{
			echo '<p class="error">Veuillez entrer le nom du lieu du concert correctement.</p>';
		}
		
		if ($v && $l) {		//tout est ok
			$date = date('Y.m.d',$ladate);
			$heure = $_POST['horaire'];
			$q ="INSERT INTO concerts (concert_date, horaire, ville, lieux) VALUES ('$date', '$heure', '$v', '$l')";
			$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
			
			if (mysqli_affected_rows($dbc) == 1) {				
				echo '<h3>Votre concert a bien été enregistré.</h3>';
				mysqli_close($dbc);
				include('inclusion/pied.php');
				exit();
			} else {
				echo '<p class="error">Votre concert n\'a pas pu être enregisté. Contactez l\'administrateur du site si le problème persiste.</p>';
				mysqli_close($dbc);
			}
		} else
		{
			echo '<p class="error">Une erreur s\'est produite. Veuillez recommencer...</p>';
		}
	}		//	fin de 		if (isset($_POST['submitted'])) {
?>	
	
	<p>Veuillez entrer les d&eacute;tails relatifs &agrave; ce concert :</p>
<form action="concert_add_main.php" method="post">
<fieldset>
	<p><b>Ville du concert :</b> <input type="text" maxlength="50" size="30" name="ville" value="<?php if (isset($_POST['ville'])) echo $_POST['ville']; ?>" /></p>
    <p><b>Lieu du concert :</b> <input type="text" maxlength="60" size="30" name="lieu" value="<?php if (isset($_POST['lieu'])) echo $_POST['lieu']; ?>" /></p>
    <p><b>Horaire du concert :</b> <select name="horaire">
    <?php
	foreach ($horaire as $value)
	{
		echo '<option value="' . $value . '"';
		if (isset($_POST['horaire'])) 
		{
			if ($_POST['horaire'] == $value) 
			{
				echo ' selected="selected"';
			}
		}
		echo ">$value</option>\n";
	}
	?>
    </select></p>
</fieldset>
<div align="center"><input type="submit" name="submit" value="Cr&eacute;er date de concert" /></div>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="ladate" value="<?php echo $ladate; ?>" />
</form>
<?php
	include('inclusion/pied.php');
?>