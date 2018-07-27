<?php		//		script		concert_add.php	
	
	//page pour créer une animation

	require_once('inclusion/configuration.php');
	$page_titre ="Cr&eacute;ation d'un nouveau concert";
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
	
	//on verifie si une date est passée
	if ((isset($_GET['ladate'])) && (!is_null($_GET['ladate'])))
	{
		$date = $_GET['ladate'];
	}
	else
	{
		$date = time();
	}
	
	//preparation des différentes variables utilisées dans ce script
	//trouver la date du jour
	$aujour = time();
	$au_day = date('d',$aujour);
	$au_month = date('m',$aujour);
	$au_year = date('Y',$aujour);
	$au_date = mktime(0,0,0,$au_month,$au_day,$au_year);
	
	//separer les variables de la date passée
	$day = date('d',$date);
	$month = date('m',$date);
	$year = date('Y',$date);
	
	//premier jour du calendrier
	$first_day=mktime(0,0,0,$month,1,$year);
	$date_debut = date('Y.m.d',$first_day);
	$title = get_mois($first_day);
	
	//trouver sur quel jour tombe le premier jour de la semaine
	$day_of_week = date('D', $first_day);
	//la semaine sera afficher à partir du samedi
	//donc samedi premier jour 0 espace
	switch($day_of_week)
	{
		case "Sat" : $blank = 0 ; break;
		case "Sun" : $blank = 1 ; break;
		case "Mon" : $blank = 2 ; break;
		case "Tue" : $blank = 3 ; break;
		case "Wed" : $blank = 4 ; break;
		case "Thu" : $blank = 5 ; break;
		case "Fri" : $blank = 6 ; break;
	}
	
	//nbre de jur dans le mois
	$day_in_month = cal_days_in_month(0, $month, $year);
	//créer le dernier jour du mois
	$last_day = mktime(0,0,0,$month,$day_in_month,$year);
	$date_fin = date('Y.m.d', $last_day);
	//créer le mois précédent et le mois suivant
	if (($month - 1) == 0)
	{
		$mois_pre = mktime(0,0,0,12,1,$year-1);
	}
	else
	{
		$mois_pre = mktime(0,0,0,$month-1,1,$year);
	}
	$mois_pre_str = get_mois($mois_pre);
	if (($month + 1) == 13)
	{
		$mois_sui = mktime(0,0,0,1,1,$year + 1);
	}
	else
	{
		$mois_sui = mktime(0,0,0,$month+1,1,$year);
	}
	$mois_sui_str = get_mois($mois_sui);
	
	//connection à la base de donnée
	require_once('../../littles_connection.php');
	//creer la requete de selection des animations
	$q = "SELECT id, concert_date, ville FROM concerts WHERE concert_date>='$date_debut' AND concert_date<='$date_fin' ORDER BY concert_date ASC";	
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	if (mysqli_num_rows($r) == 0)
	{
		$concert = FALSE;
	}
	else
	{
		$concert = TRUE;
		$count_concert= 0;
		while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC))
		{
			$concert_id[$count_concert] = $row['id'];
			$concert_date[$count_concert] = strtotime($row['concert_date']);
			$concert_nom[$count_concert] = $row['ville'];
			$count_concert++;
		}
		mysqli_free_result($r);
	}
	mysqli_close($dbc);
	//afficher la page de présentation
	echo "<h1>Cr&eacute;ation d'une nouvelle date de concert</h1>";
	echo "<p>Choisissez la date de votre concert :</p><br />";
	echo '<table border="1" width="294">';
	echo '<tr><th colspan="7"><a href="concert_add.php?ladate=' . $mois_pre .'" title="' . $mois_pre_str .'">&lt;&lt;&lt;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $title . ' ' . $year . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="concert_add.php?ladate=' . $mois_sui .'" title="' . $mois_sui_str .'">&gt;&gt;&gt;</a></th></tr>';
	echo '<tr><td width="42" align="center">Sam</td><td width="42" align="center">Dim</td><td width="42" align="center">Lun</td><td width="42" align="center">Mar</td><td width="42" align="center">Mer</td><td width="42" align="center">Jeu</td><td width="42" align="center">Ven</td></tr>';
	//compte les jours de la semaine jusqu'à 7
	$day_count = 1;
	echo '<tr>';
	
	//on prend d'abord soin des espaces
	while ($blank > 0)
	{
		echo '<td>&nbsp;</td>';
		$blank = $blank - 1 ;
		$day_count++;
	}
	
	//mettre le premier jour du mois à 1
	$day_num = 1;
	
	//compte tous les jours du mois
	while ($day_num <= $day_in_month)
	{
		$au_jour = mktime(0,0,0,$month,$day_num,$year);
		if ($concert)
		{
			if ($au_jour >= $au_date)
			{
				$is_concert = FALSE;
				for ($i=0; $i<$count_concert; $i++)
				{
					if ($au_jour == $concert_date[$i])
					{
						$is_concert = TRUE;
						$j = $i;
					}
				}
				if ($is_concert)				
				{
					echo '<td align="center" style="background-color:#403e05"><a href="concert_mod_main.php?concert='. $concert_id[$j] . '" title="Concert à : ' . $concert_nom[$j] .'. Cliquez pour modifier...">'. $day_num .'</a></td>';
				}
				else
				{
					echo "<td align=\"center\"><a href=\"concert_add_main.php?ladate=$au_jour\" title=\"Cliquez pour entrer un concert à cette date...\"> $day_num </a></td>";
				}
			}
			else
			{
				echo "<td align=\"center\"> $day_num </td>";
			}
			$day_num++;
			$day_count++;
		}
		else
		{
			if ($au_jour >= $au_date)
			{
				echo "<td align=\"center\"><a href=\"concert_add_main.php?ladate=$au_jour\" title=\"Cliquez pour entrer un concert à cette date...\"> $day_num </a></td>";
			}
			else
			{
				echo "<td align=\"center\"> $day_num </td>";
			}			
			$day_num++;
			$day_count++;
		}
		//commencer une nouvelle semaine
		if ($day_count > 7)
		{
			echo '</tr><tr>';
			$day_count = 1;
		}
	}
	
	//finaliser le calendrier
	while (($day_count > 1) && ($day_count <=7))
	{
		echo '<td>&nbsp;</td>';
		$day_count++;
	}
	
	echo '</tr></table>';
	include('inclusion/pied.php');
?>