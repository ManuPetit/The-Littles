	
	//Fonctions de la page musique
	
	//initalise les musiques pour la musique
	soundManager.url = 'js/sm/swf/';
	soundManager.debugMode = false;
	
	var lastSound = null;
	
	soundManager.onload = function() {
	  var sIntro = soundManager.createSound({
		  id: 'intro',
		  url: 'music/musicMusic.mp3'
	  });
	  var s07 = soundManager.createSound({
		  id: 'so1',
		  url: 'music/song01.mp3'
	  });
	  var s08 = soundManager.createSound({
		  id: 'so2',
		  url: 'music/song02.mp3'
	  });
	  var s09 = soundManager.createSound({
		  id: 'so3',
		  url: 'music/song03.mp3'
	  });
	  var s10 = soundManager.createSound({
		  id: 'so4',
		  url: 'music/song04.mp3'
	  });
	  var s11 = soundManager.createSound({
		  id: 'so5',
		  url: 'music/song05.mp3'
	  });
	  var s12 = soundManager.createSound({
		  id: 'so6',
		  url: 'music/song06.mp3'
	  });
	  var s13 = soundManager.createSound({
		  id: 'so7',
		  url: 'music/song07.mp3'
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
	
	function stopMusic(){
		lastSound.stop();
	}
	
	//changement d'images
	function roll_over(img_name, img_src)
   	{
   		document[img_name].src = img_src;
   	}
