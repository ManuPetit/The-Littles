<?php		//configuration.php
			
	//ensemble de fonction pour la programmation du site
	
	
	//retrouve le mois en français en fonction d'une date
	function get_mois($date)
	{
		//array des mois
		$mois = array(1=> 'janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'ao&ucirc;t', 'septembre', 'octobre', 'novembre', 'd&eacute;cembre');
		$lemois = $mois[date('n',$date)];
		return $lemois;
	}// FIN de function get_mois($date)
	
	//creation du nom du thumbnail
	function get_thumb_name($fichier) {
		$name = explode('.',$fichier);
		return $name[0].'_th.'.$name[1];
	}
	