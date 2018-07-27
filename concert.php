<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>The Littles'Tour</title>
<script type="text/javascript" src="js/sm/script/soundmanager2.js"></script>
<script type="text/javascript" src="js/concert.js"></script>
<link href="css/littles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
  <div id="entete">
    <p class="accueil">The Littles'Tour</p>
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
        <td><a href="photo.html"><img src="images/photosFix.gif" border="0" width="180" height="140" name="pic3" onmouseover="javascript:roll_over('pic3','images/photos.gif')" onmouseout="javascript:roll_over('pic3','images/photosFix.gif')" title="Cliquez ici pour voir les photos et les vidéos des Littles" alt="Cliquez ici pour voir les photos et les vidéos des Littles" /></a></td>
      </tr>
    </table>
  </div>
  <div id="principal2">
    <table border="0" width="100%">
      <tr>
        <td width="100%" align="center"><img src="images/plane.gif" width="400" height="120" border="0" align="middle" /></td>
      </tr>
    </table>
    <h3>The Littles'Tour</h3>
    <p><a href="accueil.html">Retour à la page d'accueil</a></p>
      <?php
	require_once('inclusion/configuration.php');
	
	//date du jour
	$aujour = time();
	$ladate = date('Y.m.d',$aujour);
	//retrouvez les concerts
	require_once('../littles_connection.php');
	$q = "SELECT DATE_FORMAT(concert_date,'%d-%m-%Y') AS jour, horaire, ville, lieux FROM concerts WHERE concert_date >= '$ladate' ORDER BY concert_date";
	$r = @mysqli_query($dbc, $q) or trigger_error("Requête :<br />$q\n<br />MySQL Erreur :<br />" . mysqli_error($dbc));
	if (@mysqli_num_rows($r) >= 1)
	{
		echo ' <p>Consultez nos dates de concert...</p><table border="0" width="90%" cellspacing="10">';
		while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$j = substr($row['jour'],0,2);
			$m = substr($row['jour'],3,2);
			$a = substr($row['jour'],6,4);
			$ladate = mktime(0,0,0,$m,$j,$a);
			$mois = get_mois($ladate);
			echo '<tr><td width="40%" valign="top"><i>' . $j . ' ' . $mois . ' ' . $a . '</i></td>';
			echo '<td><b>' . $row['lieux'] . '</b><br />à ' . $row['ville'] . '<br /><i>A partir de ' . $row['horaire'] .'</i></td></tr>';
		}
		echo '</table>';
	} else {
		echo '<p>Il n\'y a pas de concert de prévu pour le moment.</p><p>Cette page est mise à jour régulièrement. N\'hésitez pas à revenir dans quelques jours pour voir nos dates de concerts futurs...</p>';
	}	mysqli_free_result($r);
	mysqli_close($dbc);
	?>
  </div>
  <div id="navigation2">
    <table border="0" cellpadding="0" align="center">
      <tr>
        <td><img src="images/concertFix.gif" border="0" width="180" height="140" name="pic4" title="Vous êtes dans la section des concerts des Littles..." alt="Vous êtes dans la section des concerts des Littles..." /></td>
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
<img src="images/band.gif" class="hiddenPic"> <img src="images/adrien.gif" class="hiddenPic"> <img src="images/sam.gif" class="hiddenPic"> <img src="images/eddie.gif" class="hiddenPic"> <img src="images/yoan.gif" class="hiddenPic"> <img src="images/musique.gif" class="hiddenPic"> <img src="images/photos.gif" class="hiddenPic"> <img src="images/concert.gif" class="hiddenPic"> <img src="images/contact.gif" class="hiddenPic"> <img src="images/media.gif" class="hiddenPic">
<map name="Map" id="Map">
  <area shape="poly" coords="28,178,54,158,60,126,53,99,71,60,105,52,136,64,151,90,144,129,130,150,115,180,140,227,42,223" href="#" alt="Adrien" title="Adrien" onmouseover="javascript:roll_over('pic1','images/adrien.gif');playSound('sAdrien')" onmouseout="javascript:roll_over('pic1','images/bandFix.gif');soundManager.stop('sAdrien')" />
  <area shape="poly" coords="175,317,166,283,171,224,190,194,241,193,267,228,269,262,258,292,253,333,220,353,188,353" href="#" alt="Sam" title="Sam"  onmouseover="javascript:roll_over('pic1','images/sam.gif');playSound('sSam')" onmouseout="javascript:roll_over('pic1','images/bandFix.gif');soundManager.stop('sSam')" />
  <area shape="poly" coords="289,364,294,345,273,294,276,251,304,226,359,235,374,285,364,346,369,373" href="#" alt="Yoan" title="Yoan" onmouseover="javascript:roll_over('pic1','images/yoan.gif');playSound('sYoan')" onmouseout="javascript:roll_over('pic1','images/bandFix.gif');soundManager.stop('sYoan')" />
  <area shape="poly" coords="284,188,296,159,272,143,254,105,257,62,289,36,328,41,346,72,348,112,360,129,380,144,378,184" href="#" alt="Eddie" title="Eddie" onmouseover="javascript:roll_over('pic1','images/eddie.gif');playSound('sEddie')" onmouseout="javascript:roll_over('pic1','images/bandFix.gif');soundManager.stop('sEddie')" />
</map>
</body>
</html>
