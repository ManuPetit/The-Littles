<?php		//		script		photo_del.php	
	
	//page pour supprimer un concert

	require_once('inclusion/configuration.php');
	$page_titre ="Supprimer une photo";
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
	
	echo '<h1>Supprimer une photographie</h1><p>Cliquez sur la photo que vous souhaitez supprimer.</p><br />';
	require_once('../../littles_connection.php');
	$q = "SELECT id, image FROM images ORDER BY ID";
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	if (mysqli_num_rows($r) > 0) {
		echo '<table border="0" cellpadding="2" cellspacing="0" align="center"><tr>';
		$count=1;
		while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$image = '../images/' . $row['image'];
			$thumb = '../images/' . get_thumb_name($row['image']);
			$thumbsize=getimagesize($thumb);
			echo '<td width="25%" align="center">';
			echo '<a href="photo_del_main.php?photo=' . $row['id'] . '" title="Cliquez ici pour supprimer la photo : &quot;'. $row['image'] .'&quot;" onClick="if(confirm(\'Voulez-vous vraiment supprimer la photo &quot;' . $row['image'] .'&quot; de la base de données ?\')) return true; else return false;"><img src="' . $thumb . '" width="' . $thumbsize[0] . '" height="' . $thumbsize[1] . '" border="0" /></a></td>';
			if (($count%5)==0)
			{
				echo "</tr>\n<tr>";
				$count=0;
				$flag=true;
			}
			else
			{
				$flag=false;
			}
			$count++;
		}
		if ($flag==false)
		{
			if ($count==2)
			{
				echo '<td width="25%"></td><td width="25%"></td><td width="25%"></td><td width="25%"></td></tr>';
			}
			elseif ($count==3)
			{
				echo '<td width="25%"></td><td width="25%"></td><td width="25%"></td></tr>';
			}
			elseif ($count==4)
			{
				echo '<td width="25%"></td><td width="25%"></td></tr>';
			}
			elseif ($count==5)
			{
				echo '<td width="25%"></td></tr>';
			}
			else
			{
				echo '</tr>';
			}
		} else {
			echo '<td colspan="5"></td></tr>';
		}
		echo '</table>';
	} else {
		echo '<p>Il n\'y a aucune photographies enregistrées sur la base de données.</p>';
	}
	mysqli_free_result($r);
	mysqli_close($dbc);
	include('inclusion/pied.php');
?>
	