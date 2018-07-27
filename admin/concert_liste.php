<?php		//		script		concert_liste.php	
	
	//page pour lister les concerts

	require_once('inclusion/configuration.php');
	$page_titre ="Liste des concerts";
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
	
	//date du jour
	$aujour = time();
	$ladate = date('Y.m.d',$aujour);
	$au_day = date('d',$aujour);
	$au_month = date('m',$aujour);
	$au_year = date('Y',$aujour);
	$au_date = mktime(0,0,0,$au_month,$au_day,$au_year);
	//requete par défaut
	$q= "SELECT id, DATE_FORMAT(concert_date,'%d-%m-%Y') AS jour, concert_date, horaire, ville, lieux FROM concerts ORDER BY concert_date";
	$letitre = "Liste de tous les concerts";
	if (isset($_POST['submitted'])) {
		if ($_POST['rang'] == 2) {
			$q= "SELECT id, DATE_FORMAT(concert_date,'%d-%m-%Y') AS jour, concert_date, horaire, ville, lieux FROM concerts WHERE concert_date < '$ladate' ORDER BY concert_date";
			$letitre = "Liste des concerts réalisés";
		} else if ($_POST['rang'] == 1) {
			$q = "SELECT id, DATE_FORMAT(concert_date,'%d-%m-%Y') AS jour, concert_date, horaire, ville, lieux FROM concerts WHERE concert_date >= '$ladate' ORDER BY concert_date";
			$letitre = "Liste des futurs concerts";	
		}
	}
	require_once('../../littles_connection.php');
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	
	echo '<h1>' . $letitre . '</h1>';
	//entête de la table
	echo '<table align="center" cellspacing="0" border="0" cellpadding="5" width="85%">
	<tr bgcolor="#CCFFFF">
	<td align="right" width="15%"><b>Date</b></td>
	<td align="center" width="10%"><b>Horaire</b></td>	
	<td align="left" width="25%"><b>Ville</b></td>
	<td align="left" width="25%"><b>Lieu</b></td>';
	$rang = TRUE;
	if (isset($_POST['rang'])) {
		if (($_POST['rang'] == 0) || ($_POST['rang'] == 1)) {
			$rang= TRUE;
		} else {
			$rang = FALSE;
		}
	}
	if ($rang == TRUE) {
		echo '<td align="center" width="10%"><b>Modifier</b></td>';
	}
	echo '<td align="center"><b>Supprimer</b></td>
	</tr>';
	//retrouver et afficher les résultats
	$bg = "#eeeeee";//couleur de fond
	while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC))
	{
		$bg = ( $bg=='#eeeeee' ? '#ffffff' : '#eeeeee');//alternance de la couleur de fond
		echo '<tr bgcolor="' . $bg .'" style="font-size:0.6em">
		<td align="right">' . $row['jour'] . '</td>
		<td align="center">' . $row['horaire'] . '</td>
		<td align="left">' . $row['ville'] . '</td>
		<td align="left">' . $row['lieux'] . '</td>';
		//verification de la date pour ajouter modifier
		if ($rang == TRUE) {
			if (strtotime($row['concert_date']) >= $au_date) {
				echo '<td align="center"><a href="concert_mod_main.php?concert=' . $row['id'] . '" title="Modifier ce concert">Modifier</a></td>';
			} else {
				echo '<td></td>';
			}
		}
		echo '<td align="center"><a href="concert_del_main.php?concert=' . $row['id'] . '" title="Supprimer ce concert" onClick="if(confirm(\'Voulez-vous vraiment supprimer ce concert ?\')) return true; else return false;">Supprimer</a></td>
		</tr>';
	}// FIN de while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC))
	echo '</table>';
	mysqli_free_result($r);
	mysqli_close($dbc);
?>
<br />
<form action="concert_liste.php" method="post">
<fieldset>
<p><b>Selectionnez une option :</b></p>
<select name="rang">
<?php 
	if (isset($_POST['rang'])) {
		switch ($_POST['rang']) {
			case 0:
				echo '<option value="0" selected="selected">Tous les concerts</option><option value="1">Futurs concerts</option><option value="2">Concerts réalisés</option>';
				break;
			case 1:
				echo '<option value="0">Tous les concerts</option><option value="1" selected="selected">Futurs concerts</option><option value="2">Concerts réalisés</option>';
				break;
			case 2:
				echo '<option value="0">Tous les concerts</option><option value="1">Futurs concerts</option><option value="2" selected="selected">Concerts réalisés</option>';
				break;
		}
	} else {
		echo '<option value="0" selected="selected">Tous les concerts</option><option value="1">Futurs concerts</option><option value="2">Concerts réalisés</option>';
	}
?>
</select>
<div align="center"><input type="submit" value="Valider" /></div>
</fieldset>
<input type="hidden" name="submitted" value="TRUE" />
</form>
<?php
	include('inclusion/pied.php')
?>
