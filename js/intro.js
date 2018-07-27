	
	//Fonctions de la page d'intro 
	
	//initalise les musiques pour la musique
	soundManager.url = 'js/sm/swf/';
	soundManager.debugMode = false;
	
	var lastSound = null;
	
	soundManager.onload = function() {
	  var sIntro = soundManager.createSound({
		  id: 'intro',
		  url: 'music/intro.mp3'
	  });
	  var s01 = soundManager.createSound({
		  id: 'sAdrien',
		  url: 'music/sonAdrien.mp3'
	  });
	  var s02 = soundManager.createSound({
		  id: 'sYoan',
		  url: 'music/sonYoan.mp3'
	  });
	  var s03 = soundManager.createSound({
		  id: 'sSam',
		  url: 'music/sonSam.mp3'
	  });
	  var s04 = soundManager.createSound({
		  id: 'sEddie',
		  url: 'music/sonEddie.mp3'
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
