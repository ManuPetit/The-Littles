<?php		//		script		photo_liste.php	
	
	//page pour lister les concerts

	require_once('inclusion/configuration.php');
	$page_titre ="Liste des photos";
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
	
	
	require_once('../../littles_connection.php');
	
	//nombre de ligne à afficher
	$display=5;
	//nombre de page
	if(isset($_GET['p']) && is_numeric($_GET['p']))
	{
		//on a deja le nombre de pages
		$pages = $_GET['p'];
	}
	else
	{
		$q = "SELECT COUNT(id) FROM images";
		$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
		$row = @mysqli_fetch_array($r, MYSQLI_NUM);
		$records = $row[0];
		if ($records > $display)
		{
			//plus d'une page
			$pages = ceil($records/$display);
		}
		else
		{
			//une seule page
			$pages = 1;
		}
		mysqli_free_result($r);
	}// FIN de if(isset($_GET['p']) && is_numeric($_GET['p']))
	
	//Où en est t'on dans la base de données
	if (isset($_GET['s']) && is_numeric($_GET['s']))
	{
		$start = $_GET['s'];
	}
	else
	{
		$start = 0;
	}
	
	
	//creation de la requete
	$q = "SELECT id, image, legende, visible FROM images ORDER BY id ASC LIMIT $start, $display";
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	echo '<h1>Liste des photos</h1>';
	//entête de la table
	echo '<table align="center" cellspacing="0" border="0" cellpadding="5" width="85%">
	<tr bgcolor="#CCFFFF">
	<td align="center" width="100px"><b>Photographie</b></td>
	<td align="left"><b>Légende</b></td>
	<td align="center" width="10%"><b>Visible</b></td>
	<td align="center" width="10%"><b>Modifier</b></td>
	<td align="center" width="12%"><b>Supprimer</b></td>';
	//retrouver et afficher les résultats
	$bg = "#eeeeee";//couleur de fond
	while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC))
	{
		$iext = explode('.',$row['image']);				
		$imgname = '../images/' . $iext[0] . '_th.' . $iext[1];
		$isize = getimagesize($imgname);
		$timg = '<img src="' . $imgname . '" border="0" width="' . $isize[0] .'" height="' . $isize[1] .'" title="' . $row['image'] .'" />';
		if ($row['visible'] == 1)
		{
			$vis = "Oui";
		} else {
			$vis = "Non";
		}
		$bg = ( $bg=='#eeeeee' ? '#ffffff' : '#eeeeee');//alternance de la couleur de fond
		echo '<tr bgcolor="' . $bg .'" style="font-size:0.6em">
		<td align="center">' . $timg . '</td>
		<td align="left" valign="top">' . $row['legende'] . '</td>
		<td align="center" valign="top">' . $vis . '</td>';
		echo '<td align="center" valign="top"><a href="photo_mod_main.php?photo=' . $row['id'] . '" title="Modifier cette photographie">Modifier</a></td>
		<td align="center" valign="top"><a href="photo_del_main.php?photo=' . $row['id'] . '" title="Supprimer cette photographie" onClick="if(confirm(\'Voulez-vous vraiment supprimer cette photographie de la base de données ?\')) return true; else return false;">Supprimer</a></td>';
		echo "</tr>\n";
	}// FIN de while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC))
	echo '</table>';
	mysqli_free_result($r);
	mysqli_close($dbc);
	
	if ($pages > 1)
	{
		//début de paragraph
		echo '<br /><p>';
		
		//trouver la page du script
		$current_page = ($start/$display) + 1;
		//Faire un bouton debut
		echo '<a href="photo_liste.php?&s=0&p=' . $pages . '">D&eacute;but&nbsp;&nbsp;&nbsp;</a>';
		//faire un bouton précédent si ce n'est pas la première page
		if ($current_page != 1)
		{
			echo '<a href="photo_liste.php?&s=' . ($start - $display) . '&p=' . $pages . '">Pr&eacute;c&eacute;dent&nbsp;&nbsp;&nbsp;</a>';
		}
		//faire la numérotation des pages
		if ($pages > 9)
		{
			$debut = $current_page - 4;
			if ($debut <1 )
			{
				$debut = 1;
			}
			$fin = $debut + 8;
			if (($pages - $current_page) < 5)
			{
				$debut = $pages - 8;
			}
			if ($current_page <5 )
			{
				$fin = 9;
			}
			if ($fin > $pages)
			{
				$fin = $pages;
			}
			for ($i=$debut; $i <=$fin; $i++)
			{
				if ($i != $current_page)
				{
					echo '<a href="photo_liste.php?&s=' . (($display * ($i-1))) . '&p=' . $pages . '">&nbsp;' . $i . '&nbsp;</a>';
				}
				else
				{
					echo '&nbsp;' . $i . '&nbsp;';
				}
			}// FIN de for ($i=1; $i <=$pages; $i++)
		}
		else
		{
			for ($i=1; $i <=$pages; $i++)
			{
				if ($i != $current_page)
				{
					echo '<a href="photo_liste.php?&s=' . (($display * ($i-1))) . '&p=' . $pages . '">&nbsp;' . $i . '&nbsp;</a>';
				}
				else
				{
					echo '&nbsp;' . $i . '&nbsp;';
				}
			}// FIN de for ($i=1; $i <=$pages; $i++)
		}
		//faire un bouton suivant si ce n'est pas la dernière page
		if ($current_page !=  $pages)
		{
			echo '<a href="photo_liste.php?&s=' . ($start + $display) . '&p=' . $pages . '">&nbsp;&nbsp;Suivant&nbsp;</a>';
		}
		//Faire une page fin
		echo '<a href="photo_liste.php?&s=' . ($display * ($pages-1)) . '&p=' . $pages . '">&nbsp;&nbsp;Fin</a>';
		//fermer le paragraphe
		echo '</p>';
	}// FIN de if ($pages > 1)
	include('inclusion/pied.php');
?>