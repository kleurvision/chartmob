<? // iTunes api for artist lookups


class itunes{

	var $artist;
	
	function __construct($artist){
		$this->artist = $artist;
	}
	
	function get_music($tol = '80'){
		$clean_artist = str_replace('+', ' ', $this->artist);
		$tracks	= file_get_contents('https://itunes.apple.com/search?term='.$this->artist.'&entity=song&country=CA&attribute=artistTerm');
		if($tracks){
			$t = json_decode($tracks);
			// print_r($t);
			if($t){
				echo '<h2>Sample Tracks</h2>';
				echo '<div class="trackList">';
				$count = 0;
				foreach($t->results as $track){
					// print_r($track);
					if($count <= 4){
						// Tolerance for artist groups, etc. - designed to match artist query - default 80%
						similar_text($track->artistName, $clean_artist, $p);
						if($track->kind == 'song' || $track->kind == 'music-video' && $p > $tol){
							// rewrite to remove clickable links
							similar_text($prevTrack[$count-1], $track->trackName, $tn);
							if($tn < '30' || $tn == '0'){
								echo '<div class="ui360"><a href="'.$track->previewUrl.'">'.$track->trackName.'</a></div>';
								$prevTrack[$count] = $track->trackName;
								$count ++;
							} else {
								continue;
							}		
						} else {
							continue;
						} 
					}
				} 
				echo '</div>';
			}
		}
	}
}
