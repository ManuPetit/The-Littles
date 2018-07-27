<?php		//script		login.php
	//page de connexion au site
	require_once('inclusion/configuration.php');
	$page_titre = 'Se connecter...';
	include('inclusion/entete.php');
	
	if (isset($_POST['submitted'])) {
		require_once('../../littles_connection.php');
		
		//validation identifiant
		if (!empty($_POST['iden'])) {
			$i = mysqli_real_escape_string($dbc, $_POST['iden']);
		} else {
			$i = FALSE;
			echo '<p class="error">Vous n\'avez pas entrer votre identifiant !</p>';
		}
		//validation mot de passe
		if (!empty($_POST['pass'])) {
			$p = mysqli_real_escape_string($dbc, $_POST['pass']);
		} else {
			$p = FALSE;
			echo '<p class="error">Vous n\'avez pas entrer votre mot de passe !</p>';
		}
		
		if ($i && $p) {	//tout est ok
			//faire la requete
			$q = "SELECT id, prenom FROM utilisateurs WHERE (identifiant = '$i' AND pass = SHA1('$p')) LIMIT 1";
			$r = mysqli_query ($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
			
			if (@mysqli_num_rows($r) == 1) {	//on a un match
				//enregistrer les valeurs et rediriger
				$_SESSION = mysqli_fetch_array($r, MYSQLI_ASSOC);
				mysqli_close($dbc);
				
				$url = BASE_URL . 'index.php';
				
				ob_end_clean();
				header("Location: $url");
				exit();
			} else {		//pas de match
				echo '<p class="error">L\'identifiant fournit ne correspond pas au mot de passe entré. Veuillez les vérifier, et recomencer.</p>';
			}
		} else {
			echo '<p class="error">Une erreur s\'est produite. Veuillez recomencer.</p>';
		}
		mysqli_close($dbc);
	}// FIN du if (isset($_POST['submitted'])) {
?>
<h1>Connexion</h1>
<p>Votre navigateur doit accepter les cookies pour vous connecter.</p>
<form action="login.php" method="post">
	<fieldset>
    <p><b>Votre identifiant :</b> <input type="text" size="20" maxlength="25" name="iden" /></p>
    <p><b>Votre mot de passe :</b> <input type="password" size="20" maxlength="20" name="pass" /></p>
    <div align="center"><input type="submit" name="submit" value="Se connecter" /></div>
    <input type="hidden" name="submitted" value="true" />
    </fieldset>
</form>
<?php
	include('inclusion/pied.php');
?>    
		
		