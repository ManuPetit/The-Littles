<?php		//		script		photo_mod_main.php	
	
	//page pour supprimer un concert

	require_once('inclusion/configuration.php');
	$page_titre ="Modifier une photo";
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
	
	$concert = FALSE;
	//verification que l'on a une valeur passée
	if ((isset($_GET['photo'])) && (is_numeric($_GET['photo']))) {
		$pid = $_GET['photo'];
	} else if ((isset($_POST['photo'])) && (is_numeric($_POST['photo']))) {
		$pid = $_POST['photo'];
	} else {
		$url = BASE_URL . 'index.php';
		header("Location: $url");
		exit();//quitter le script
	}
	
	
	require_once('../../littles_connection.php');
	//retrouver les détails de la photo
	$q= "SELECT image, legende, visible FROM images WHERE id = $pid LIMIT 1";
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	if (mysqli_affected_rows($dbc)==1) {
		$row = @mysqli_fetch_array($r, MYSQLI_ASSOC);
	} else {
		echo '<p class="error">Une erreur s\'est produite. Veuillez contacter l\'administrateur du site.</p>';
		include('inclusion/pied.php');
		exit();
	}
	mysqli_free_result($r);
	$thumb = '../images/' . get_thumb_name($row['image']);
	
	if (isset($_POST['submitted'])) {
		$l = $v = FALSE;
		//verifier la légende
		if (preg_match('/^[a-zA-Z0-9 éèàçâêîôû:,.\'-]{3,100}$/i',trim($_POST['legende'])))
		{
			$l =  mysqli_real_escape_string($dbc,trim($_POST['legende']));
			$err = FALSE;
		}
		else
		{
			echo '<p class="error">Veuillez entrer la légende correctment</p>';
			$err = TRUE;
		}
		//on affecte la valeur de visiblite
		if ($_POST['visible'] == "Oui") {
			$v =1;
		} else {
			$v =0;
		}
		//verifier que l'on a des entrées différentes
		if ($err == FALSE){
			if (($l != $row['legende']) || ($v != $row['visible'])) {
				//il y a un changement
				$q = "UPDATE images SET legende = '" . $l ."', visible = $v WHERE id = $pid LIMIT 1";
				$r = mysqli_query ($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));			
				if (mysqli_affected_rows($dbc) == 1) {
					echo '<h3>Les données de la photographie ont été modifiées.</h3>';
					mysqli_close($dbc);
					include('inclusion/pied.php');
					exit();
				} else {
					echo '<p class="error">La photographie n\'a pas pu être modifiée. Veuillez ré-essayer.</p><p class="error">Contactez l\'administrateur du site si vous pensez qu\'il y a eu une erreur.</p>';
				}
				mysqli_close($dbc);
			} else {
				echo '<h3>Aucune modifification n\'a été apportée à la base de données des photographies.</h3>';
				mysqli_close($dbc);
				include('inclusion/pied.php');
				exit();
			}		
		}
	}//		FIN DE if (isset($_POST['submitted'])) {
	mysqli_close($dbc);

echo '<h1>Modification de la photo &quot;'.$row['image'].'&quot;</h1>';
?>
<p>Vous pouvez modifier la légende de la photo et sa visibilité.</p><br />
<form action="photo_mod_main.php" method="post">
<fieldset><legend>Le nom du fichier n'est pas modifiable pour des raisons de sécurité</legend>
<?php
	$sizth= getimagesize('../images/' . $thumb);
	echo '<p><b>Image :</b><br /><img src="' . $thumb . '" width="' . $sizth[0] .'" height="' . $sizth[1] . '" border="0" title="' . $row['image'] .'" /></p><p><b>Nom du fichier : </b>' . $row['image'] .'</p>';
	echo '<p><b>Légende :</b><br /><input type="text" size="70" maxlength="100" name="legende" value="' .$row['legende']. '" /></p>';	
	echo '<p><b>L\'image est visible sur le site internet : </b><select name="visible">';
	if ($row['visible'] == 1) {
		echo '<option value="Oui" selected="selected">Oui</option><option value="Non">Non</option>';
	} else {
		echo '<option value="Oui">Oui</option><option value="Non" selected="selected">Non</option>';
	}
	echo '</select><div align="center"><input type="submit" name="submit" value="Modifier la photographie" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="photo" value="'. $pid .'" />';
?>
</fieldset>
</form>
<?php
	include('inclusion/pied.php');
?>