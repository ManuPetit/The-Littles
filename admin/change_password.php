<?php		//	script		change_password.php
	//permet de changer le mot de passe d'un utilisateur
	
	require_once('inclusion/configuration.php');
	$page_titre ="Changer de mot de passe";
	include('inclusion/entete.php');
	
	//pas de session redirection
	if (!isset($_SESSION['prenom'])) {
		$url = BASE_URL . 'index.php';
		ob_end_clean();
		header("Location: $url");
		exit();
	}
	
	$_SESSION['menuID'] = 4;
	
	if (isset($_POST['submitted'])) {
		require_once('../../littles_connection.php');
		
		//validation du nouveau mot de passe
		$p = FALSE;
		
		if (preg_match('/^(\w){4,20}$/', $_POST['password1'])) {
			if ($_POST['password1'] == $_POST['password2']) {
				$p =mysqli_real_escape_string($dbc,$_POST['password1']);
			} else {
				echo '<p class="error">Votre mot de passe et la confirmation de votre mot de passe sont différents.</p>';
			}
		} else {
			echo '<p class="error">Veuillez entrer un mot de passe valide.</p>';
		}
		
		if ($p) {
			//mot de passe valide
			$q = "UPDATE utilisateurs SET pass = SHA1('$p') WHERE id = {$_SESSION['id']} LIMIT 1";
			$r = mysqli_query ($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
			
			if (mysqli_affected_rows($dbc) == 1) {
				echo '<h3>Votre mot de passe a été changé.</h3>';
				mysqli_close($dbc);
				include('inclusion/pied.php');
				exit();
			} else {
				echo '<p class="error">Votre mot de passe n\'a pas pu être changé. Vérifier que votre nouveau mot de passe est bien différent que celui vous avez en ce moment. Contactez l\'administrateur du site si vous pensez qu\'il y a eu une erreur.</p>';
			}
		} else {
			echo '<p class="error">Veuillez ré-essayer.</p>';
		}
		mysqli_close($dbc);
	}		//fin de 	if (isset($_POST['submitted'])) {
?>

<h1>Changer de mot de passe</h1>
<form action="change_password.php" method="post">
  <fieldset>
    <p><b>Votre nouveau mot de passe :</b>
      <input type="password" name="password1" size="20" maxlength="20" />
      <small>Utilisez seulement des lettres ou des numéros. Doit être entre 4 et 20 caratères.</small></p>
    <p><b>Confirmation du mot de passe :</b>
      <input type="password" name="password2" size="20" maxlength="20" />
    </p>
  </fieldset>
  <div align="center">
    <input type="submit" value="Changer mon mot de passe" />
  </div>
  <input type="hidden" name="submitted" value="TRUE" />
</form>
<?php
	include('inclusion/pied.php');
?>