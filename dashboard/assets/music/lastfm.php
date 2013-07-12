<? // Last.FM api for artist lookups

// u. chartmob
// p. KVadmin01


class lastfm{

	var $api;
	var $details;
	var $artist;
	
	function __construct($artist) {
		$this->artist = $artist;
		$this->api	= '2b7c1b97e7d4b65105551227ab3a85d2';		
	}
	
	function get_artist(){
		$details = file_get_contents('http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist='.$this->artist.'&api_key='.$this->api.'&format=json');
		$i = json_decode($details);
		$this->details = $i->artist;
		return $this->details;
	}
	
	function get_band_members(){
		$members = $this->details->bandmembers->member;
		if($members){
			echo '<h2>Band Members</h2>';
			echo '<ul id="member_list">';
			foreach($members as $member){
				echo '<li><a href="'.URL.'/'.str_replace(" ", "+", $member->name).'">'.$member->name.'</a></li>';
			} 
			echo '</ul>';
		}
	}
	
	function get_artist_image($size = 'small', $a =''){
		if($a == ''){
			$images = $this->details->image;
		}
		if($images){
			$count = 0;
			foreach($images as $image){
			 	foreach($image as $key => $item){
				 	if($key == '#text'){
					 	$key = 'url';
				 	}
				 	$i[$key] = $item; 
			 	}
			$s =	$i['size']; 	
			$image_size[$s] = $i;
			}
			return '<img src="'.$image_size[$size]['url'].'" alt="">';
		
		}
	}
	
	function get_similar_artists(){
		$similar = $this->details->similar->artist;
		if($similar){
			echo '<h2>Similar Artists</h2>';
			echo '<ul id="similar_list">';
			foreach($similar as $similar_artist){
				echo '<li><a href="'.URL.'/'.str_replace(" ", "+", $similar_artist->name).'">'.$similar_artist->name.'</a></li>';
			} 
			echo '</ul>';
		}
	}

}