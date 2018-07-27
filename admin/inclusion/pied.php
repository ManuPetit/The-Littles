<?php		//script 	pied.php
?>
<!-- End of Content -->
</div>
<div id="Menu">

<?php
	//montre les liens selon le login
	if (isset($_SESSION['id'])) {
		if ($_SESSION['menuID'] == 0) {		
			echo '<h3>Menu principal</h3>';
			echo '<a href="concert.php" title="Accéder au menu &quot;concert&quot;">Concerts</a><br />';
			echo '<a href="photo.php" title="Accéder au menu &quot;photo&quot;">Photos</a><br />';
			//echo '<a href="article.php" title="Accéder au menu &quot;article&quot;">Articles</a><br /><br />';
			echo '<br />';
			echo '<a href="change_password.php" title="Changer son mot de passe">Changer mot de passe</a><br /><br /><br />';
		} else if ($_SESSION['menuID'] == 1) {				
			echo '<h3>Menu concerts</h3>';
			echo '<a href="concert_add.php" title="Ajouter un concert">Nouveau concert</a><br />';
			echo '<a href="concert_liste.php" title="Voir la liste des concerts">Liste concerts</a><br />';
			echo '<a href="concert_mod.php" title="Modifier les détails d\'un concert">Modifier concert</a><br />';
			echo '<a href="concert_del.php" title="Supprimer un concert">Supprimer concert</a><br /><br />';
			echo '<a href="index.php" title="Retourner au menu principal de l\'interface administrative">Menu principal</a><br /><br />';
		} else if ($_SESSION['menuID'] == 2) {				
			echo '<h3>Menu photos</h3>';
			echo '<a href="photo_add.php" title="Ajouter une photo">Nouvelle photo</a><br />';
			echo '<a href="photo_liste.php" title="Voir la liste des photos">Liste photos</a><br />';
			echo '<a href="photo_mod.php" title="Modifier les détails d\'une photo">Modifier photo</a><br />';
			echo '<a href="photo_del.php" title="Supprimer une photo">Supprimer photo</a><br /><br />';
			echo '<a href="index.php" title="Retourner au menu principal de l\'interface administrative">Menu principal</a><br /><br />';
		} /*else if ($_SESSION['menuID'] == 3) {				
			echo '<h3>Menu articles</h3>';
			echo '<a href="article_add.php" title="Ajouter un article">Nouvel article</a><br />';
			echo '<a href="article_liste.php" title="Voir la liste des articles">Liste articles</a><br />';
			echo '<a href="article_mod.php" title="Modifier les détails d\'un article">Modifier article</a><br />';
			echo '<a href="article_del.php" title="Supprimer un article">Supprimer article</a><br /><br />';
			echo '<a href="index.php" title="Retourner au menu principal de l\'interface administrative">Menu principal</a><br /><br />';
		}*/
		else if ($_SESSION['menuID'] == 4) {				
			echo '<h3>Menu mot de passe</h3>';
			echo '<a href="index.php" title="Retourner au menu principal de l\'interface administrative">Menu principal</a><br /><br />';
		}
		echo '<a href="logout.php" title="Se déconnecter">Déconnexion</a><br />';
		echo '<a href="../index.html" target="_new" title="Voir le site internet">Site internet</a>';
	} else {	//pas connecté
		echo '<h3>Menu</h3><a href="login.php" title="Se connecter à l\'interface d\'administration du site &quot;www.thelittles.fr&quot;">Connexion</a><br />
		<a href="forgot_password.php" title="Retrouver son mot de passe">Mot de passe oublié</a><br /><br />	
		<a href="../index.html" title="Voir le site internet">Site internet</a>';
	}
?>
</div>
</body>
</html>
<?php
	//vider le buffer
	ob_end_flush();
?>