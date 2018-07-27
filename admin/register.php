<?php # Script 16.6 - register.php
// This is the registration page for the site.
	
 	require_once ('inclusion/configuration.php');
 	$page_title = 'Creation d\'un nouvel utilisateur';
 	include ('inclusion/entete.php');
 	
	// VERIFICATION DE SECURITE
	/*//si il n'y a aucun utilisateur enregistré redirigé la page
	if (!isset($_SESSION['first_name']))
	{
		$url = BASE_URL . 'index.php';
		ob_end_clean();//supprimer le buffer
		header("Location: $url");
		exit();//quitter le script
	}
	
	//si le niveau de l'utilisateur n'est pas 1 retourner à l'index
	if ($_SESSION['user_level'] != 1)
	{
		$url = BASE_URL . 'index.php';
		ob_end_clean();//supprimer le buffer
		header("Location: $url");
		exit();//quitter le script
	}*/
		
	//création du mot de passe
	$pass=make_password(12);
	
	//vérifier si le formulaire a été soumis
	if (isset($_POST['submitted']))
	{
		//appeler la base de données 	
		require_once('../../littles_connection.php');
		
		//trimer les données
		$trimmed= array_map('trim',$_POST);
		
		//on assume des valeurs invalides
		$fn = $ln = $e = $iden = FALSE;
		
		//verification du prénom
		if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,30}$/i',$trimmed['first_name']))
		{
			$fn = mysqli_real_escape_string($dbc,$trimmed['first_name']);
		}
		else
		{
			echo '<p class="error">Veuillez entrer le prénom correctment.</p>';
		}
		
		//vérification du nom
		if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,30}$/i',$trimmed['last_name']))
		{
			$ln = mysqli_real_escape_string($dbc,$trimmed['last_name']);
		}
		else
		{
			echo '<p class="error">Veuillez entrer le nom de famille correctement.</p>';
		}
		
		//verification identifiant
		if (preg_match('/^[ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿA-Z \'.-]{2,25}$/i',$trimmed['ident']))
		{
			$iden = mysqli_real_escape_string($dbc,$trimmed['ident']);
		}
		else
		{
			echo '<p class="error">Veuillez entrer l\'identifiant correctment.</p>';
		}
		
		//vérification email
		if (preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/',$trimmed['email']))
		{
			$e = mysqli_real_escape_string($dbc,$trimmed['email']);
		}
		else
		{
			echo '<p class="error">Veuillez entrer une adresse email valide.</p>';
		}
		
		//Si tout est bon
		if ($fn && $ln && $e && $iden)
		{
			//vérification que l'email n'existe pas déja
			$q = "SELECT id FROM utilisateurs WHERE email ='$e'";
			$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
			
			//adresse email non enregistrée
			if (mysqli_num_rows($r) == 0)
			{
				//ajouter l'utilisateur sur la base de donnée
				$q = "INSERT INTO utilisateurs (prenom, nom, identifiant, email, pass) VALUES ('$fn', '$ln', '$iden', '$e', SHA1('$pass'));";
				$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
				
				//ajout validé
				if (mysqli_affected_rows($dbc) == 1)
				{
					//envoyer email au nouveau membre
					$body = "Bonjour " . $fn . ",<br />Vous avez maintenant acc&egrave;s &agrave; l'interface de gestion du site www.thelittles.fr.\n\nPour vous connecter, cliquez sur le lien suivant :<a href=\"";
					$body .= BASE_URL . "\">" . BASE_URL . "</a><br />Utilisez votre identifiant, et le mot de passe communiqu&eacute; dans ce mail. Nous vous recommendons de changer votre mot de passe lors de votre premi&egrave;re connexion au site.<br />";
					$body .= "Identifiant de connexion : " . $trimmed['ident'] . "<br />Mot de passe : " . $pass . "<br />A bient&ocirc;t sur le site.<br /><br />L'administrateur du site.<br />PS: ne pas r&eacute;pondre &agrave; ce mail.";

//*********************************************************************************************************  attention à changer ************************************
					//mail($trimmed['email'],'Confirmation d\'enregistrement au site du www.littles.fr',$body, 'From: admin@thelittles.fr');

					echo 'Email qui sera envoy&eacute; :<br />' . $body;
					
					//terminer la page
					echo '<h3>Vous venez d\'enregistrer un nouvel utilisateur sur l\'interface de gestion du restaurant Le Sagittaire. Mer&ccedil;i...</h3>';
					include('inclusion/pied.php');
					//ferme la page
					exit();
				}
				else
				{
					//il y a eu une erreur
					echo '<p class="error">Vous n\'avez pas pu cr&eacute;er un nouvel utilisateur du &agrave; une erreur du syst&egrave;me. Veuillez nous en excuser.</p>';
				}//FIN de if (mysqli_affected_rows($dbc) == 1)
			}
			else
			{
				//l'adresse email existe déja
				echo '<p class="error">L\adresse email que vous avez utilis&eacute; pour enregistrer un nouvel utilisateur, existe d&eacute;j&agrave; dans la base de donn&eacute;es.</p>';
			}//FIN de if (mysqli_num_rows($r) == 0)
		}
		else
		{
			echo '<p class="error">Une erreur s\'est produite. Veuillez recommencer...</p>';
		}//FIN de if ($fn && $ln && $e && $ul && $a)
		
		mysqli_close($dbc);
	}//FIN de if isset($_POST['submitted']))
?>
<h1>Nouvel utilisateur</h1>
<form action="register.php" method="post">
	<fieldset>
    	<p><b>Pr&eacute;nom :</b> <input type="text" name="first_name" size="20" maxlength="30" value="<?php if (isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>" /></p>
        <p><b>Nom :</b> <input type="text" name="last_name" size="20" maxlength="30" value="<?php if (isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>" /></p>
        <p><b>Identifiant :</b> <input type="text" name="ident" size="20" maxlength="25" value="<?php if (isset($trimmed['ident'])) echo $trimmed['ident']; ?>" /></p>
        <p><b>Adresse email :</b> <input type="text" name="email" size="30" maxlength="100" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" /></p>
        <p><b>Mot de passe cr&eacute;&eacute; automatiquement :</b> <input type="text" size="20" disabled="disabled" value="<?php echo $pass; ?>" /></p>
	</fieldset>
    <div align="center"><input type="submit" name="submit" value="Cr&eacute;er nouvel utilisateur" /></div>
    <input type="hidden" name="submitted" value="TRUE" />
</form>
<?php
	include('inclusion/pied.php');
?>
	