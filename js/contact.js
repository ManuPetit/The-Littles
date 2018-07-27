	
	//Fonctions de la page d'intro 
	
	//initalise les musiques pour la musique
	soundManager.url = 'js/sm/swf/';
	soundManager.debugMode = false;
	
	var lastSound = null;
	
	soundManager.onload = function() {
	  var sIntro = soundManager.createSound({
		  id: 'intro',
		  url: 'music/contactMusic.mp3'
	  });
	  sIntro.play();
	  lastSound =  soundManager.getSoundById('intro');
	}
	
	function playSound(soundID) {
		var thisSound = soundManager.getSoundById(soundID);
		if (lastSound) {
			if (lastSound == thisSound) {
				lastSound.togglePause();
			} else {
				lastSound.stop();
				thisSound.togglePause();
			}
		} else {
			thisSound.togglePause();
		}
		lastSound = thisSound;
	}
	
	//changement d'images
	function roll_over(img_name, img_src)
   	{
   		document[img_name].src = img_src;
   	}
