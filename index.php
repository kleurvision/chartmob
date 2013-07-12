<? // Get the artist information from iTunes
require('bootstrap.php');

// Load the classes
require('classes.php');


if(isset($_GET['i'])){
	$artist = $_GET['i'];
	$artist_lookup = str_replace(" ", "+", $artist);
} else {
	echo 'no artist';
	exit;
}

// Load artist info
$i = new lastfm($artist_lookup);
$details = $i->get_artist();

// Load artist music
$t = new itunes($artist_lookup);
// $tracks = $t->get_music($artist_lookup);

// Load the header
include('structure/header.php');

?>

<div class="row">
	<div id="artist_image" class="span4">
		<? echo $i->get_artist_image('mega');?>
		<? social_share();?>
	</div>
	<div id="artist_music" class="span8">
		<div class="music_container well">
			<? $t->get_music();?>
		</div>
	</div>
</div>
<div class="row">
	<div id="artist_bio" class="span4">
		<h2>About <?=$artist;?></h2>
		<p><?= strip_tags($details->bio->content);?></p>
	</div>
	<div id="artist_similar" class="span4">
		<? $i->get_similar_artists();?>
	</div>
	<div id="artist_members" class="span4">
		<? $i->get_band_members();?>
	</div>
</div>

<? //

// print_r($details);
// Load the footer
include( 'structure/footer.php');
?>