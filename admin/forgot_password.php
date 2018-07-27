<?php		//	script		forgot_password.php
	//permet de reinitialiser un mot de passe
	
	require_once('inclusion/configuration.php');
	$page_titre = "Mot de passe oublié...";
	include('inclusion/entete.php');
	
	if (isset($_POST['submitted'])) {
		require_once('../../littles_connection.php');
		
		//rien
		$uid = FALSE;
		
		//validation email
		if (!empty($_POST['email'])) {
			if (preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/',trim($_POST['email'])))
			{
				$e = mysqli_real_escape_string($dbc,trim($_POST['email']));
				//vérifier la présence de l'email
				$q = 'SELECT id FROM utilisateurs WHERE email="'.$e.'"';
				$r = mysqli_query ($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
				
				if (mysqli_num_rows($r) == 1) {
					//on a utilisateur
					list($uid) = mysqli_fetch_array($r, MYSQLI_NUM);
				} else {
					echo '<p class="error">L\'adresse email que vous avez fournie, ne correspond à aucune adresse enregistrée dans le fichier. Veuillez ré-essayer ou contacter l\'administrateur du site.</p>';
				}
			} else {
				echo '<p class="error">Veuillez entrer une adresse email valide.</p>';
			}
		} else {
			echo '<p class="error">Vous avez oublié de fournir votre adresse email...</p>'; 
		}		// fin de if (!empty($_POST['email'])) {
		
		if ($uid) {		//tout est bon
			//creation d'un nouveau mot de passe
			$pass = make_password(12);
			
			//mise à jour de la base de donnée
			$q = "UPDATE utilisateurs SET pass=SHA1('$pass') WHERE id = $uid LIMIT 1";
			$r = mysqli_query ($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
			
			if (mysqli_affected_rows($dbc) == 1) {
				//tout est ok
				//envoyer mail avec nouveau mot de passe
				$body = "Votre mot de passe pour vous connecté à l'interface administrative du site \"www.thelittles.fr\" a été changé temporairement avec le mot de passe suivant : $pass.\n\nPour vous connecter, cliquez sur le lien suivant :\n";
				$body .= BASE_URL . "\nUtilisez votre identifiant, et ce nouveau mot de passe communiqué dans ce mail. Nous vous recommendons de changer votre mot de passe lors de votre procahine connexion au site.\n\nL'administrateur du site.\nPS: ne pas répondre à ce mail.";
				
//*********************************************************************************************************  attention à changer ************************************
				//mail($e,'Nouveau mot de passe temporaire',$body, 'From: admin@thelittles.fr');
				echo $body;
				//afficher
				echo '<h3>Votre mot de passe a été modfié. Vous allez recevoir un email, avec le nouveau mot de passe temporaire. Une fois que vous vous serez connecté au site, nous vous conseillons de modifier votre mot de passe en cliquant sur &quot;Changer mot de passe&quot;.</h3>';
				
				mysqli_close($dbc);
				
				include('inclusion/pied.php');
				exit();
			} else {
				//erreur
				echo '<p class="error">Votre mot de passe n\'a pas pu être modifié. Veuillez nous en excuser.</p>';
			}
		} else {
			//pas de validation
			echo '<p class="error">Veuillez ré-essayer...</p>';
		}
		mysqli_close($dbc);
	}		// 	fin de if (isset($_POST['submitted'])) {
?>

<h1>Mot de passe oublié</h1>
<p>Veuillez entrer votre adresse email, et un nouveau mot de passe vous sera fourni.</p>
<form action="forgot_password.php" method="post">
  <fieldset>
    <p><b>Adresse email : </b>
      <input type="text" name="email" size="30" maxlength="100" />
    </p>
  </fieldset>
  <div align="center">
    <input type="submit" name="submit" value="Changer mon mot de passe" />
  </div>
  <input type="hidden" name="submitted" value="TRUE" />
</form>
<?php
	include('inclusion/pied.php');
?>