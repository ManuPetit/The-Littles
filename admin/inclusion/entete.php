<?php		//script	entete.php
	//ce script commence l'entête du fichier
	
	//début du beffering
	ob_start();
	//début de session
	session_start();
	
	//vérification d'un titre
	if (!isset($page_titre)) {
		$page_titre = 'Identification';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_titre; ?></title>
<link rel="stylesheet" href="css/cssjour.css" type="text/css" />
</head>
<body>
<div id="Header">Interface administrative du site &quot;www.thelittles.fr&quot;</div>
<div id="Content">
<!-- End of Header -->