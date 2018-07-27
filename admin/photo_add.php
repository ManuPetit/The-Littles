<?php		//		script		photo_add.php	
	
	//page pour créer une animation

	require_once('inclusion/configuration.php');
	$page_titre ="Ajout d'une nouvelle photo";
	include('inclusion/entete.php');
	require_once('../../littles_connection.php');
	
	// VERIFICATION DE SECURITE
	//si il n'y a aucun utilisateur enregistré redirigé la page
	if (!isset($_SESSION['id']))
	{
		$url = BASE_URL . 'index.php';
		ob_end_clean();//supprimer le buffer
		header("Location: $url");
		exit();//quitter le script
	}
	
	//verifier la submission
	if (isset($_POST['submitted'])) {
		
		//validation des données
		$errors = array();
		
		//verification de la légende
		if (preg_match('/^[a-zA-Z0-9 éèàçâêîôû:,.\'-]{3,100}$/i',trim($_POST['legende'])))
		{
			$l =  mysqli_real_escape_string($dbc,trim($_POST['legende']));
		}
		else
		{
			$errors[] ='Veuillez entrer la légende correctment';
		}
		
		//verifier que l'on a un upload
		if (isset($_FILES['upload'])) {
			//verifier le type de fichier jpg, png, gif
			$allowed = array('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/jpg', 'image/GIF', 'image/gif');
			
			//verification du fichier téléchargé
			if (in_array($_FILES['upload']['type'], $allowed)) {
				//verifier qu'il y a un fichier
				if ($_FILES['upload']['size'] == 0){
					$errors[] = 'Veuillez fournir un fichier a télécharger.';
				} else {//il y a un fichier			
					//verifier la taille du fichier
					if ($_FILES['upload']['size'] > 500000){
						$errors[] = 'Désolé, mais votre fichier est trop grand. Taille maximum acceptée : 500Kb.';
					} else {//le fichier fait moin de 500Kb
						//verification de la largeur et longueur du fichier
						$sizefile = getimagesize($_FILES['upload']['tmp_name']);
						if ($sizefile[0]>600 || $sizefile[1] > 600) {
							$errors[] = 'La taille du fichier ne doit pas depasser 600 pixels en largeur et en longueur.';
						} else { //taille du fichier ok
							//retrouver l'extension du fichier
							$fext = '.' . findexts($_FILES['upload']['name']);
							//creer nouveau nom du fichier
							$tmpname = make_password(12) . $fext;
							$temp = $_FILES['upload']['tmp_name'];
							//transferer le fichier
							if (!move_uploaded_file ($_FILES['upload']['tmp_name'],"../images/". $tmpname)){
								$errors[] = 'Le fichier n\'a pas pu être sauvegardé sur le serveur. Si ce problème persite, veuillez contacter l\'administrateur du site.';
							} else {
								//creation du thumbnail de l'image
								createthumb("../images/" . $tmpname,100,100);
							}
						}
					}
				}				
			} else {
				$errors[] = 'Le format du fichier n\'est pas une image compatible. Utilisez soit une image de type jpg ou gif.';
				$temp = NULL;
			}	//FIN DE		if (in_array($_FILES['upload']['type'], $allowed)) {
		} else {
			$errors[] = 'Aucun fichier image n\'a été fourni pour le téléchargement.';
			$temp = NULL;
		}		//FIN DE 	if (isset($_FILES['upload'])) {
		
		if ($_POST['visible'] == 'Oui') {
			$v = 1;
		} else {
			$v = 0;
		}
		
		//si pas d'erreur
		if (empty($errors)) {
			//préparation de la requete
			$q = 'INSERT INTO images (image, legende, visible) VALUES(?,?,?)';
			$stmt = mysqli_prepare($dbc, $q);
			mysqli_stmt_bind_param($stmt, 'ssi', $tmpname, $l, $v);
			mysqli_stmt_execute($stmt);
			
			//check the result
			if (mysqli_stmt_affected_rows($stmt) == 1) {
				$iext = explode('.',$tmpname);				
				$imgname = '../images/' . $iext[0] . '_th.' . $iext[1];
				$isize = getimagesize($imgname);
				$timg = '<img src="' . $imgname . '" border="0" width="' . $isize[0] .'" height="' . $isize[1] .'" />';
				echo '<h3>L\'image ' . $timg . ' a été ajouté avec succès...</h3>';
				include('inclusion/pied.php');
				exit();
			} else {
				echo '<p class="error">Votre requête n\'a pas être éxecutée du à une erreur du système.</p>';
			}
			mysqli_stmt_close($stmt);
		}	// FIN DE 		//si pas d'erreur
		
		//Enlever le fichier si il existe toujours
		if (isset($temp) && file_exists($temp) && is_file($temp)) {
			unlink($temp);
		}
	}	//FIN DE 	if (isset($_POST['submitted'])) {
		
	echo '<h1>Ajouter une photographie</h1>';
	
	if (!empty($errors) && is_array($errors)) {
		foreach($errors as $msg) {
			echo '<p class="error">' . $msg . '</p>';
		}
	}
?>
<form enctype="multipart/form-data" action="photo_add.php" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="524288" />
<fieldset><legend>Veuillez entrer les détails de la photographie à télécharger :</legend>
<p><b>Choisissez l'image que vous voulez télécharger : </b><br /><input type="file" name="upload" size="40" /><br /><small>Fichiers jpg uniquement. Taille maximun 600pixels x 600 pixels et 500Kb.</small></p>
<p><b>Donnez une légende à votre image : </b><br /><input type="text" name="legende" size="70" maxlength="100" value="<?php if (isset($_POST['legende'])) echo $_POST['legende']; ?>" /></p>
<p><b>L'image sera visite sur le site : </b><select name="visible">
<?php
	if (isset($_POST['visible'])) {
		if ($_POST['visible'] == 'Oui') {
			echo '<option value="Oui" selected="selected">Oui</option><option value="Non">Non</option>';
		} else {
			echo '<option value="Oui">Oui</option><option value="Non" selected="selected">Non</option>';
		}
	} else {
		echo '<option value="Oui" selected="selected">Oui</option><option value="Non">Non</option>';
	}
?>
</select></p>
<div align="center">
<input type="submit" value="Ajouter photo" name="submit" />
</div>
</fieldset>
<input type="hidden" name="submitted" value="true" />
</form>
<?php
	include('inclusion/pied.php');
?>

			


			
			
		
				
				