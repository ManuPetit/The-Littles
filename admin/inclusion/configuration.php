<?php #configuration.php		
	/*
	Fichier de configuration de la gestion administrative
	*/
	
	//SETTINGS
	
	//status du site
	define('LIVE', TRUE);
	
	//email du contact administration
	define('EMAIL','e.petit18@laposte.net');
	
	//URL du site
	define('BASE_URL','http://localhost/littles/admin/');
		
	//zone de temps
	date_default_timezone_set('Europe/Paris');
	
	//array des horaires
	$horaire = array('12h00', '12h30', '13h00', '13h30', '14h00', '14h30', '15h00', '15h30', '16h00', '16h30', '17h00', '17h30', '18h00', '18h30', '19h00', '19h30','20h00', '20h30', '21h00', '21h30', '22h00', '22h30', '23h00', '23h30');
	/*
	
			FONCTIONS
			
	*/
	
	//create function pour faire un mot de passe
	function make_password($length) {
		$vowels = 'aeiouyAEIUY0123456789';
		$consonants = 'bdghjlmnpqrstvwxzBDGHJLMNPQRSTVWXZ';
		$password = '';
		$alt = time() % 2;
		srand(time());
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
			    $alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
			  	$alt = 1;
			}
		}
		return $password;
	}// fin de make_password
	
	//This function takes in the current width and height of an image
	//and also the max width and height desired.
	//It then returns an array with the desired dimensions.
	function setWidthHeight($width, $height, $maxwidth, $maxheight){
		if ($width > $height){
			if ($width > $maxwidth){
				//Then you have to resize it.
				//Then you have to resize the height to correspond to the change in width.
				$difinwidth = $width / $maxwidth;
				$height = intval($height / $difinwidth);
				//Then default the width to the maxwidth;
				$width = $maxwidth;
				//Now, you check if the height is still too big in case it was to begin with.
				if ($height > $maxheight){
					//Rescale it.
					$difinheight = $height / $maxheight;
					$width = intval($width / $difinheight);
					//Then default the height to the maxheight;
					$height = $maxheight;
				}
			} else {
				if ($height > $maxheight){
					//Rescale it.
					$difinheight = $height / $maxheight;
					$width = intval($width / $difinheight);
					//Then default the height to the maxheight;
					$height = $maxheight;
				}
			}
		} else {
			if ($height > $maxheight){
				//Then you have to resize it.
				//You have to resize the width to correspond to the change in width.
				$difinheight = $height / $maxheight;
				$width = intval($width / $difinheight);
				//Then default the height to the maxheight;
				$height = $maxheight;
				//Now, you check if the width is still too big in case it was to begin with.
				if ($width > $maxwidth){
					//Rescale it.
					$difinwidth = $width / $maxwidth;
					$height = intval($height / $difinwidth);
					//Then default the width to the maxwidth;
					$width = $maxwidth;
				}
			} else {
				if ($width > $maxwidth){
					//Rescale it.
					$difinwidth = $width / $maxwidth;
					$height = intval($height / $difinwidth);
					//Then default the width to the maxwidth;
					$width = $maxwidth;
				}
			}
		}
		$widthheightarr = array ("$width","$height");
		return $widthheightarr;
	}	// FIN DE 		function setWidthHeight($width, $height, $maxwidth, $maxheight){
	
	//This function creates a thumbnail and then saves it.
	function createthumb ($img, $constrainw, $constrainh){
		//Find out the old measurements.
		$oldsize = getimagesize ($img);
		//Find an appropriate size.
		$newsize = setWidthHeight ($oldsize[0], $oldsize[1], $constrainw, $constrainh);
		//Create a duped thumbnail.
		$exp = explode (".", $img,4);
		//Check if you need a gif or jpeg.
		if ($exp[3] == "gif"){
			$src = imagecreatefromgif ($img);
		} else {
			$src = imagecreatefromjpeg ($img);
		}
		//Make a true type dupe.
		$dst = imagecreatetruecolor ($newsize[0],$newsize[1]);
		//Resample it.
		imagecopyresampled ($dst,$src,0,0,0,0,$newsize[0],$newsize[1],$oldsize[0],$oldsize[1]);
		//Create a thumbnail.
		$thumbname = '..' . $exp[2] . "_th." . $exp[3];
		if ($exp[3] == "gif"){
			imagejpeg ($dst,$thumbname);
		} else {
			imagejpeg ($dst,$thumbname);
		}
		//And then clean up.
		imagedestroy ($dst);
		imagedestroy ($src);
	}	//FIN DE		function createthumb ($img, $constrainw, $constrainh){
	
	//cette function resize une image pour être sur qu'elle n'est pas supérieur à 400 x 400
	function resize_jpg($inputFilename, $name, $direct){
		//creation du path de l'image
		$curimage = $direct . $inputFilename;
		//on retrouve sa taille
		$imagedata = getimagesize($curimage);
		$w = $imagedata[0];
		$h = $imagedata[1];
		//on crée les nouvelles taille en respectant le sens de l'image
		if ($h > $w) {
			$new_w = (400 / $h) * $w;
			$new_h = 400;	
		} else {
			$new_h = (400 / $w) * $h;
			$new_w = 400;
		}
		//s'agit-il d'un gif ou jpeg	
		if ($name == 'image/gif') {
			$im2= imagecreate($new_w, $new_h);
			$image= imagecreatefromgif($curimage);
		} else {
			$im2 = imagecreatetruecolor($new_w, $new_h);
			$image = imagecreatefromjpeg($curimage);
		}	
		//nom du nouveau fichier temporaire qui sera crée sur le serveur
		$newfilename= 'temp_';
		$file = $newfilename . $inputFilename;
		
		//nom du path avec nouveau fichier
		$fullpath = $direct . $file;
	
		//on retaille l'image
		imagecopyresized($im2,  $image,  0,  0,  0,  0,  $new_w,  $new_h,  $w,  $h);
	
		//on sauvegarde l'image avec une qualité de 80
		imagejpeg($im2,  $fullpath,  80);
		
		//maintenant on détruit le fichier original
		unlink($curimage);
		
		//finalement on change le nom du fichier
		rename($fullpath,$curimage);
		
		//CREATING FILENAME TO WRITE TO DATABSE
		$filepath = $curimage;
		
		//RETURNS FULL FILEPATH OF IMAGE ENDS FUNCTION
		return $filepath; 
	}	//FIN DE function resize_jpg($inputFilename, $name, $direct){

	//retrouve l'extension d'un fichier
	function findexts($filename) 
	{	 
		$filename = strtolower($filename) ; 
		$exts = explode('.', $filename) ; 
		$n = count($exts)-1; 
		$exts = $exts[$n]; 
		return $exts; 
	} 	// FIN DE 	function findexts ($filename) 

	//creation du nom du thumbnail
	function get_thumb_name($fichier) {
		$name = explode('.',$fichier);
		return $name[0].'_th.'.$name[1];
	}
	
	//fonction du jour de la semaine en francais en fonction d'une date
	function get_jour($unedate)
	{
		$lejour = date('D', $unedate);
		switch($lejour)
		{
			case "Sat" : $jour = "samedi" ; break;
			case "Sun" : $jour = "dimanche" ; break;
			case "Mon" : $jour = "lundi" ; break;
			case "Tue" : $jour = "mardi" ; break;
			case "Wed" : $jour = "mercredi" ; break;
			case "Thu" : $jour = "jeudi" ; break;
			case "Fri" : $jour = "vendredi" ; break;
		}
		return $jour;
	}// FIN de function get_jour($unedate)
	
	//retrouve le mois en français en fonction d'une date
	function get_mois($date)
	{
		//array des mois
		$mois = array(1=> 'janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'ao&ucirc;t', 'septembre', 'octobre', 'novembre', 'd&eacute;cembre');
		$lemois = $mois[date('n',$date)];
		return $lemois;
	}// FIN de function get_mois($date)
	
	//creation erreur handler
	function mon_erreur_handler($e_number, $e_message, $e_file, $e_line, $e_vars)
	{
		//message d'erreur
		$message="<p>Une erreur est apparue dans le fichier de script '$e_file' à la ligne $e_line :<br />$e_message\n<br />";
		
		//ajouter l'heure
		$message .= "Date et heure : " . date('j-n-Y H:i:s') . "\n<br />";
		
		//ajouter les variables
		$message .= "<pre>" . print_r ($e_vars, 1) . "</pre>\n</p>";
		
		if (!LIVE)
		{
			//developpement
			echo '<div id="error">' . $message . '</div><br />';
		}
		else
		{
			//on ne fait pas voir l'erreur
			//envoyer email à l'administrateur
			mail(EMAIL, 'Erreur thelittles', $message, 'From:erreur@thelittles.fr');
			
			//mettre un message
			if ($e_number != E_NOTICE)
			{
				echo '<div id="error">Une erreur s\'est produise sur le système. Veillez nous en excuser.</div><br />';
			}
		}// FIN de if (!LIVE)
	} //FIN de function mon_erreur_handler($e_number, $e_message, $e_file, $e_line, $e_vars)
	
	//utiliser ce système d'erreur
	set_error_handler('mon_erreur_handler');
	
?>