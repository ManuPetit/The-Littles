<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contactez The Littles</title>
<script type="text/javascript" src="js/sm/script/soundmanager2.js"></script>
<script type="text/javascript" src="js/contact.js"></script>
<link href="css/littles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
  <div id="entete">
    <p class="accueil">Contactez The Littles</p>
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
    <p><a href="accueil.html">Retour à la page d'accueil</a></p>
<?php  
	if (isset($_POST['submitted'])) {
		//mises à zero des variables
		$n = $e = $s = $t = FALSE;
		
		//annuler les erreurs
		$errCN = $errCE = $errCS = $errCM = FALSE;
		
		//valider le nom
		if (trim($_POST['nom']) != '') {
			if (preg_match('/^[a-zA-Z éèàçâêîôûëöù\'-]{3,45}$/i',stripslashes(trim($_POST['nom'])))) {
				$n = utf8_decode(stripslashes(trim($_POST['nom'])));
			} else {
				$errCN = "Caract&egrave;res non autoris&eacute;s dans votre nom.";
			}
		} else {
			$errCN = "Veuillez entrer votre nom.";
		}
		
		//valider l'email
		if (trim($_POST['email']) != '') {
			if (preg_match('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/',trim($_POST['email']))) {
				$e = trim($_POST['email']);
			} else {
				$errCE = "Mauvais format d'email.";
			}
		} else {
			$errCE = "Veuillez entrer votre email.";
		}
		
		//valider objet
		if (trim($_POST['sub']) != '') {
			//$pattern = "/^[a-zA-Z0-9 éèàçâêîôûëöù\'\.;:,\?]{3,75}$/u";
			if (preg_match('/^[a-zA-Z0-9 éèàçâêîôûùëö\'().,:-]{3,75}$/u',stripslashes(trim($_POST['sub'])))) {
				$s = utf8_decode(stripslashes(trim($_POST['sub'])));
			} else {
				$errCS = "Caract&egrave;res non autoris&eacute;s dans votre objet.";
			}
		} else {
			$errCS = "Veuillez pr&eacute;ciser l'objet de votre message.";
		}
		
		//valider le message
		if (trim($_POST['mess']) != '') {
			//if (preg_match("/^[a-zA-Z0-9 éèàçâêîôûùëö\'+;().,!?:\n\r-]{3,}$/i",trim($_POST['mess']))) {
			//$pattern = "/^[[:alpha:][:punct:]]+$/u";
			if (preg_match('/^[a-zA-Z0-9 éèàçâêîôûùëö+;().,!?\\:\'\n\r-]{3,}$/u',stripslashes(trim($_POST['mess'])))) {
				$t = utf8_decode(stripslashes(trim($_POST['mess'])));
			} else {
				$errCM = "V&eacute;rifiez votre message. Certains caract&egrave;res ne sont pas accept&eacute;s.";
			}
		} else {
			$errCM = "Veuillez entrer un message.";
		}
				
		$flagMailSent = FALSE;
		if ($n && $e && $s && $t) {
			//on a un message
			$body = "Message de : " . $n . "\n\nEmail : " . $e . "\n\n" . $t;
			$addMail = "adrumm19@hotmail.fr";
			$header = "From: " . $n . " <" . $e . ">\r\n";
			//*************************************************************************************************************
			mail($addMail, $s, $body, $header);
			//***********************************************************************************************************
			$flagMailSent = TRUE;
		}
	}//fin de if submitted
	$affi = TRUE;
	if (isset($flagMailSent)) {
		if ($flagMailSent == TRUE) {
			echo '<h1>Message envoyé</h1><p>Votre message a bien &eacute;t&eacute; envoy&eacute;. Nous vous contacterons bient&ocirc;t.</p><p>Mer&ccedil;i.</p><p></p><p></p><p></p><p></p><p></p><p></p>';  
			$affi = FALSE;
		}
	}

	if ($affi == TRUE) {
		echo '<h4>Pour contacter notre agent :</h4>
		<p>06 80 18 94 74 <b>(du lundi au vendredi de 9h à 18h)</b></p>
		<h4>Retrouvez nous sur Facebook <img src="images/fblogo.gif" width="40" height="36" border="0"></h4>
		<p>Pour vous joindre à nous sur Facebook, cliquez <a href="http://www.facebook.com/group.php?gid=137808162926675" target="_new" title="Notre lien Facebook">ce lien</a>. Nous vous y attendons...</p>
		<h4>Envoyez-nous un message :</h4>
			<form action="contact.php" method="post">
			  <fieldset>
				<legend>Veuillez entrer vos d&eacute;tails : </legend>
				<table width="330px" border="0" cellspacing="5">
				  <tr>
					<td width="30%" align="left" valign="top">Votre nom :</td>
					<td width="70%" align="left" valign="top"><input type="text" size="25" maxlength="45" name="nom" value="';
					if (isset($_POST['nom'])) {
						echo $_POST['nom'];
					}
					echo '" />';
					if (isset($errCN)) {
						if ($errCN) {
							echo '<br /><span class="error">' . $errCN . '</span>';
						}
					}
					echo '</td>
				  </tr>
				  <tr>
					<td width="30%" align="left" valign="top">Votre email :</td>
					<td width="70%" align="left" valign="top"><input type="text" size="25" maxlength="75" name="email" value="';
					if (isset($_POST['email'])) {
						echo $_POST['email'];
					}
					echo '" />';
					if (isset($errCE)) {
						if ($errCE) {
							echo '<br /><span class="error">' . $errCE . '</span>';
						}
					}
					echo '</td>
				  </tr>
				  <tr>
					<td width="30%" align="left" valign="top">Objet :</td>
					<td width="70%" align="left" valign="top"><input type="text" size="25" maxlength="75" name="sub" value="';
					if (isset($_POST['sub'])) {
						echo stripslashes($_POST['sub']);
					}
					echo '" />';
					if (isset($errCN)) {
						if ($errCS) {
							echo '<br /><span class="error">' . $errCS . '</span>';
						}
					}
					echo '</td>
				  </tr>
				  <tr>
					<td colspan="2" align="left">Votre message :</td>
				  </tr>
				  <tr>
					<td colspan="2" align="left"><textarea cols="45" rows="6" name="mess">';
					if (isset($_POST['mess'])) {
						echo stripslashes($_POST['mess']);
					}
					echo '</textarea>';
					if (isset($errCN)) {
						if ($errCM) {
							echo '<br /><span class="error">' . $errCM . '</span>';
						}
					}
					echo '</td>
				  </tr>
				</table>
				<div align="center">
				  <input type="submit" name="submit" value="Envoyer email" />
				</div>
				<input type="hidden" name="submitted" value="TRUE" />
			  </fieldset>
			</form>';
	}
?>
  </div>
  <div id="navigation2">
    <table border="0" cellpadding="0" align="center">
      <tr>
        <td><a href="concert.php"><img src="images/concertFix.gif" border="0" width="180" height="140" name="pic4" onmouseover="javascript:roll_over('pic4','images/concert.gif')" onmouseout="javascript:roll_over('pic4','images/concertFix.gif')" title="Cliquez ici pour connaitre les dates de concert des Littles" alt="Cliquez ici pour connaitre les dates de concert des Littles" /></a></td>
      </tr>
      <tr>
        <td><img src="images/phoneFix.gif" border="0" width="180" height="140" name="pic5" title="Vous êtes dans la section contact du site..." alt="Vous êtes dans la section contact du site..." /></td>
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