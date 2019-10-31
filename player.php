

<?php
	/**
	 * Author: Jacob Mills
	 * Date: 03/16/2018
	 * Description: This file is a basic template for pages on the site
	 */
	
	ini_set('display_errors', 1);
	
	// Report simple running errors
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	// Reporting E_NOTICE can be good too (to report uninitialized
	// variables or catch variable name misspellings ...)
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	
	// Report all errors except E_NOTICE
	error_reporting(E_ALL & ~E_NOTICE);
	
	// Report all PHP errors (see changelog)
	error_reporting(E_ALL);
	
	// Report all PHP errors
	error_reporting(-1);
	
	// Same as error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	
	
	include_once("DAL/File.php");
	
	session_start();
	
	$viewmodel = File::search(null,null,null,null,null,null,null,'audio/mp3',1,null);
    $viewmodel = array_reverse($viewmodel);
	?>
<!DOCTYPE html>
<html>
	<head>
		<title>TAFers mp3 player</title>
		<!-- Include font -->
		<link href="https://fonts.googleapis.com/css?family=Lato:400,400i" rel="stylesheet">
		<!-- Include Amplitude JS -->
		<script type="text/javascript" src="vendor/amplitude/amplitude.min.js"></script>
		<!-- Include Style Sheet -->
		<link rel="stylesheet" type="text/css" href="vendor/amplitude/css/app.css"/>
	</head>
	<body>
		<div id="flat-black-player-container">
			<div id="list-screen" class="slide-in-top">
				<div id="list-screen-header" class="hide-playlist">
					<img id="up-arrow" src="vendor/amplitude/img/up.svg"/>
					Hide Playlist
				</div>
				<div id="list">
					<?php
						$count = 0;                
						foreach($viewmodel as $file)
						{
						    
						?>
					<div class="song amplitude-song-container amplitude-play-pause" data-amplitude-song-index="<?php echo $count; ?>">
						<span class="song-number-now-playing">
						<span class="number"><?php echo $count + 1; ?></span>
						<img class="now-playing" src="vendor/amplitude/img/now-playing.svg"/>
						</span>
						<div class="song-meta-container">
							<span class="song-name" data-amplitude-song-info="<?php echo $file->getFileName(); ?>" data-amplitude-song-index="<?php echo $count; ?>"></span>
							<span class="song-artist-album"><span data-amplitude-song-info="name" data-amplitude-song-index="<?php echo $count; ?>"></span> - <span data-amplitude-song-info="artist" data-amplitude-song-index="<?php echo $count; ?>"></span></span>
						</div>
						<!--<span class="song-duration">
						3:30
						<span>-->
					</div>
						<?php
							$count = $count + 1;
                            echo $count;
				        }
						?>
				</div>
				<div id="list-screen-footer">
					<div id="list-screen-meta-container">
						<span data-amplitude-song-info="name" class="song-name"></span>
						<div class="song-artist-album">
							<span data-amplitude-song-info="artist"></span>
						</div>
					</div>
					<div class="list-controls">
						<div class="list-previous amplitude-prev"></div>
						<div class="list-play-pause amplitude-play-pause"></div>
						<div class="list-next amplitude-next"></div>
					</div>
				</div>
			</div>
			<div id="player-screen">
				<div class="player-header down-header">
					<img id="down" src="vendor/amplitude/img/down.svg"/>
					Show Playlist
				</div>
				<div id="player-top">
					<img data-amplitude-song-info="cover_art_url"/>
				</div>
				<div id="player-progress-bar-container">
					<progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
					<progress id="song-buffered-progress" class="amplitude-buffered-progress" value="0"></progress>
				</div>
				<div id="player-middle">
					<div id="time-container">
						<span class="amplitude-current-time time-container"></span>
						<span class="amplitude-duration-time time-container"></span>
					</div>
					<div id="meta-container">
						<span data-amplitude-song-info="name" class="song-name"></span>
						<div class="song-artist-album">
							<span data-amplitude-song-info="artist"></span>
						</div>
					</div>
				</div>
				<div id="player-bottom">
					<div id="control-container">
						<div id="shuffle-container">
							<div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle"></div>
						</div>
						<div id="prev-container">
							<div class="amplitude-prev" id="previous"></div>
						</div>
						<div id="play-pause-container">
							<div class="amplitude-play-pause" id="play-pause"></div>
						</div>
						<div id="next-container">
							<div class="amplitude-next" id="next"></div>
						</div>
						<div id="repeat-container">
							<div class="amplitude-repeat" id="repeat"></div>
						</div>
					</div>
					<div id="volume-container">
						<img src="vendor/amplitude/img/volume.svg"/><input type="range" class="amplitude-volume-slider" step=".1"/>
					</div>
				</div>
			</div>
		</div>
	</body>
	<!--
		Include UX functions JS
		
		NOTE: These are for handling things outside of the scope of AmplitudeJS
		-->
	<script>
		(function() {
		    window.onkeydown = function(e) {
		        return !(e.keyCode == 32);
		    };
		
		    /*
		      Handles a click on the down button to slide down the playlist.
		    */
		    document.getElementsByClassName('down-header')[0].addEventListener('click', function(){
		      var list = document.getElementById('list');
		
		      list.style.height = ( parseInt( document.getElementById('flat-black-player-container').offsetHeight ) - 135 ) + 'px';
		
		      document.getElementById('list-screen').classList.remove('slide-out-top');
		      document.getElementById('list-screen').classList.add('slide-in-top');
		      document.getElementById('list-screen').style.display = "block";
		    });
		
		    /*
		      Handles a click on the up arrow to hide the list screen.
		    */
		    document.getElementsByClassName('hide-playlist')[0].addEventListener('click', function(){
		      document.getElementById('list-screen').classList.remove('slide-in-top');
		      document.getElementById('list-screen').classList.add('slide-out-top');
		      document.getElementById('list-screen').style.display = "none";
		    });
		
		    /*
		      Handles a click on the song played progress bar.
		    */
		    document.getElementById('song-played-progress').addEventListener('click', function( e ){
		      var offset = this.getBoundingClientRect();
		      var x = e.pageX - offset.left;
		
		      Amplitude.setSongPlayedPercentage( ( parseFloat( x ) / parseFloat( this.offsetWidth) ) * 100 );
		    });
		
		    document.querySelector('img[data-amplitude-song-info="cover_art_url"]').style.height = document.querySelector('img[data-amplitude-song-info="cover_art_url"]').offsetWidth + 'px';
		
		    Amplitude.init({
		      "bindings": {
		        37: 'prev',
		        39: 'next',
		        32: 'play_pause'
		      },
		      "songs": [
		        
		        <?php
                 $count = 1;
			     foreach($viewmodel as $file)
			     {
			    ?>
		          {
		          "name": "<?php echo $file->getFileName(); ?>",
		          "artist": "TAFers.net",
		          "album": "typ",
		          "url": "https://www.tafers.net/files/<?php echo $file->getFileName(); ?>",
		          "cover_art_url": "https://tafers.net/files/horselogo.png"
                   }
		          <?php
                     if ($count < count($viewmodel)){
                         echo ",\n";
                     }
                     $count = $count + 1;
                  }
                ?>
		        
		      ]
		    });
		})();
		  
	</script>
</html>