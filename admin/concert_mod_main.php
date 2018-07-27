<?php		//		script		concert_mod_main.php	
	
	//page pour supprimer un concert

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
	
	$concert = FALSE;
	//verification que l'on a une valeur passée
	if ((isset($_GET['concert'])) && (is_numeric($_GET['concert']))) {
		$concert = $_GET['concert'];
	} else if ((isset($_POST['concert'])) && (is_numeric($_POST['concert']))) {
		$concert = $_POST['concert'];
	} else {
		$url = BASE_URL . 'index.php';
		header("Location: $url");
		exit();//quitter le script
	}
	
	
	require_once('../../littles_connection.php');
	//retrouver les données du concert
	$q= "SELECT DATE_FORMAT(concert_date,'%d-%m-%Y') AS jour, horaire, ville, lieux FROM concerts WHERE id = $concert LIMIT 1";
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	if (mysqli_affected_rows($dbc)==1) {
		$row = @mysqli_fetch_array($r, MYSQLI_ASSOC);
	} else {
		echo '<p class="error">Une erreur s\'est produite. Veuillez contacter l\'administrateur du site.</p>';
		include('inclusion/pied.php');
		exit();
	}
	mysqli_free_result($r);
	if (isset($_POST['submitted'])) {
		$v = $l = $d =FALSE;
		//verification des entrées
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
		if (preg_match('/^[0-9]{2}[-][0-9]{2}[-][0-9]{4}$/',trim($_POST['jour'])))
		{
			$j = substr($_POST['jour'],0,2);
			$m = substr($_POST['jour'],3,2);
			$a = substr($_POST['jour'],6,4);
			if (checkdate($m, $j, $a) == true) {
				$err = FALSE;
			} else {
				$err =TRUE;
				echo '<p class="error">Veuillez vérifier la date proposée.</p><p class="error">Les valeurs proposées ne correspondent pas à celles attendues par la base de donnée...</p>';
			}
			if ($err== FALSE) {
				$date = mktime(0,0,0,$m,$j,$a);
				$d = date('Y.m.d',$date);
			}
		} else {
			echo '<p class="error">Veuillez vérifier la date proposée.</p><p class="error">Son format ne correspond pas à celui attendu par la base de donnée...</p>';
		}

		//tout est ok
		if ($v && $l && $d)
		{
			$h = $_POST['horaire'];
			//verifier que l'on a quelquechose à modifier
			$upd = FALSE;
			if ($v != $row['ville']) {
				$upd = TRUE;
			}
			if ($l != $row['lieux']) {
				$upd = TRUE;
			}
			if (date('d-m-Y',$date) != $row['jour']) {
				$upd = TRUE;
			}
			if ($h != $row['horaire']) {
				$upd = TRUE;
			}
			if ($upd) {	//on a un changement
				$c = $_POST['concert'];
				$q = "UPDATE concerts SET concert_date = '$d', horaire = '$h', ville = '$v', lieux = '$l' WHERE id = $c LIMIT 1";
				$r = mysqli_query ($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));			
				if (mysqli_affected_rows($dbc) == 1) {
					echo '<h3>Le concert a été modifié.</h3>';
					include('inclusion/pied.php');
					exit();
				} else {
					echo '<p class="error">Le concert n\'a pas pu être modifié. Veuillez ré-essayer.</p><p class="error">Contactez l\'administrateur du site si vous pensez qu\'il y a eu une erreur.</p>';
				}
				mysqli_close($dbc);
			} else {
				echo '<h3>Aucune modifification n\'a été apportée à la base de données des concerts.</h3>';
				include('inclusion/pied.php');
				exit();
			}
		}
	} 
	mysqli_close($dbc);
?>
<h1>Modification d'un concert</h1>
<p>Vous pouvez modifier les détails suivant du concert :</p>
<form action="concert_mod_main.php" method="post">
<fieldset>
	<p><b>Ville : </b><input type="text" maxlength="50" size="30" name="ville" value="<?php
		if (isset($_POST['ville'])) {
			echo $_POST['ville'];
		} else {
			echo $row['ville'];
		}
		?>" /></p>
    <p><b>Lieu : </b><input type="text" maxlength="60" size="30" name="lieu" value="<?php
		if (isset($_POST['lieu'])) {
			echo $_POST['lieu'];
		} else {
			echo $row['lieux'];
		}
		?>" /></p>
    <p><b>Date : </b><input type="text" size="20"  maxlength="10" name="jour" value="<?php
		if (isset($_POST['jour'])) {
			echo $_POST['jour'];
		} else {
			echo $row['jour'];
		}
		?>" /><br /><small>La date doit être entrée sous le format jj-mm-aaaa</small></p>
    <p><b>Horaire du concert :</b> <select name="horaire">
    <?php
		if (isset($_POST['horaire'])) {
			$heure = $_POST['horaire'];
		} else {
			$heure = $row['horaire'];
		}
		foreach ($horaire as $value)
		{
		echo '<option value="' . $value . '"';
			if ($heure == $value) 
			{
				echo ' selected="selected"';
			}
			echo ">$value</option>\n";
		}
	?>
    </select></p>
<div align="center"><input type="submit" name="submit" value="Modifier" /></div>
</fieldset>
<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="concert" value="<?php echo $concert; ?>" />
</form>
<?php
	include('inclusion/pied.php');
?>
       
		