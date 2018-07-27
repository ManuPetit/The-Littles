<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>The Littles - les Photographies</title>
<script type="text/javascript" src="js/sm/script/soundmanager2.js"></script>
<script type="text/javascript" src="js/photo.js"></script>
<link href="css/littles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
</head>
<body>
<div id="wrapper">
  <div id="entete">
    <p class="accueil">Les photographies</p>
  </div>
  <div id="navigation1">
    <table border="0" cellpadding="0" align="center">
      <tr>
        <td><a href="biographie.html"><img src="images/bandFix.gif" border="0" width="180" height="140" name="pic1" onmouseover="javascript:roll_over('pic1','images/band.gif')" onmouseout="javascript:roll_over('pic1','images/bandFix.gif')" title="Cliquez ici pour découvrir notre biographie" alt="Cliquez ici pour découvrir notre biographie" /></a></td>
      </tr>
      <tr>
        <td><a href="musique.html"><img src="images/jukeFix.gif" border="0" width="180" height="140" name="pic2" onmouseover="javascript:roll_over('pic2','images/juke.gif')" onmouseout="javascript:roll_over('pic2','images/jukeFix.gif')" title="Cliquez ici pour écouter Les Littles chanter les Beatles" alt="Cliquez ici pour écouter Les Littles chanter les Beatles" /></a></td>
      </tr>
      <tr>
        <td><img src="images/photosFix.gif" border="0" width="180" height="140" name="pic3" title="Vous êtes dans la section photographie du site..." alt="Vous êtes dans la section photographie du site..." /></td>
      </tr>
    </table>
  </div>
  <div id="principal2"> <a href="accueil.html">Retour à la page d'accueil</a><br />
    <h3>Les photographies des Littles</h3>
    <p>Cliquez sur une photo pour lancer le diaporama.<br />
      <br />
      Pour naviguer dans le diaporama : utilisez la souris ou cliquez sur Suiv. ou Prec.</p>
      <?php	  
	require_once('inclusion/configuration.php');
	//retrouvez les photos
	require_once('../littles_connection.php');
	$q = "SELECT id, image, legende FROM images WHERE visible = 1 ORDER BY id ASC";
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	if (@mysqli_num_rows($r) >= 1)
	{
		
		echo ' <table width="100%" border="0" cellpadding="5"><tr>';
		$count=1;
		while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$image = 'images/' . $row['image'];
			$thumb = 'images/' . get_thumb_name($row['image']);
			$thumbsize=getimagesize($thumb);
			echo '<td width="33%" align="center">';
			echo '<a href="' . $image . '" rel="lightbox[galerie]" title="' . $row['legende'] . '"><img src="' . $thumb . '" width="' . $thumbsize[0] . '" height="' . $thumbsize[1] . '" border="0" /></a></td>';
			if (($count%3)==0)
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
				echo '<td width="25%"></td><td width="25%"></td></tr>';
			}
			elseif ($count==3)
			{
				echo '<td width="25%"></td></tr>';
			}
			else
			{
				echo '</tr>';
			}
		} else {
			echo '<td colspan="3"></td></tr>';
		}
		echo '</table>';
			  
	  
	} else {
		echo '<p>Il n\'y a aucune photographies dans cette section pour le moment...</p>';
	}
	mysqli_free_result($r);
	mysqli_close($dbc);
	?>
  </div>
  <div id="navigation2">
    <table border="0" cellpadding="0" align="center">
      <tr>
        <td><a href="concert.php"><img src="images/concertFix.gif" border="0" width="180" height="140" name="pic4" onmouseover="javascript:roll_over('pic4','images/concert.gif')" onmouseout="javascript:roll_over('pic4','images/concertFix.gif')" title="Cliquez ici pour connaitre les dates de concert des Littles" alt="Cliquez ici pour connaitre les dates de concert des Littles" /></a></td>
      </tr>
      <tr>
        <td><a href="contact.html"><img src="images/phoneFix.gif" border="0" width="180" height="140" name="pic5" onmouseover="javascript:roll_over('pic5','images/phone.gif')" onmouseout="javascript:roll_over('pic5','images/phoneFix.gif')" title="Cliquez ici pour nous contacter" alt="Cliquez ici pour nous contacter" /></a></td>
      </tr>
      <tr>
        <td><a href="media.html"><img src="images/mediaFix.gif" border="0" width="180" height="140" name="pic6" onmouseover="javascript:roll_over('pic6','images/media.gif')" onmouseout="javascript:roll_over('pic6','images/mediaFix.gif')" title="Cliquez ici pour retrouver différents médias relatifs aux Littles, et les paroles des chansons..." alt="Cliquez ici pour retrouver différents médias relatifs aux Littles, et les paroles des chansons..." /></a></td>
      </tr>
    </table>
  </div>
  <div id="pied">
  Site réalisé par <a href="http://www.iiidees.com" target="_new" title="Cliquez ici pour aller sur le site www.iiidees.com">iiidees.com</a><br />
  Site hébergé par <a href="http://hebergement-solutions.com/" target="_new" title="Cliquez ici pour aller sur le site de l'hébergeur">hebergement-solutions.com</a>.
  </div>
</div>
</body>
</html>
