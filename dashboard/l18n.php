<? // Language Packs

// Get the quiz ID from the URL
$quizID = $_GET['q'];

// Query the database for all necessary data
global $db;
$quiz 		= $db->get_row("SELECT * FROM quiz WHERE id = '$quizID'");
$lng		= $quiz->language;

if($lng == 'English'){
	
	$ln_begin		= 'Begin';
	$ln_back		= 'Back';
	$ln_next		= 'Next';
	$ln_ready		= 'Ready for the Quiz?';
	$ln_ready_txt	= 'Proceed to take the '.$quiz->title.' quiz, or go back and review.';
	$ln_proceed		= 'Proceed with quiz';
	$ln_review		= 'Go back and review';
	$ln_confirm		= 'Confirm and Proceed';
	$ln_error		= 'Incorrect answer. Please read the question carefully and select again.';
	$ln_email_error	= 'Please enter your name and email address.';
	$ln_thanks		= 'Thank you!';
	$ln_close		= 'You may now close this screen by clicking the "X" on your browser tab.';
	$ln_thank_you	= 'Thank you for taking the quiz!';
	$ln_name		= 'Full Name';
	$ln_email		= 'Email';
	$ln_submit 		= 'Submit quiz';

} else if($lng == 'French'){
	
	$ln_begin		= 'Commencer';
	$ln_back		= 'Avant';
	$ln_next		= 'Après';
	$ln_ready		= 'Prêt pour le Quiz?';
	$ln_ready_txt	= 'Continuez de prendre le '.$quiz->title.' quiz, ou revenir en arrière et revoir.';
	$ln_proceed		= 'Procéder au quiz';
	$ln_review		= 'Retourner et reviser';
	$ln_confirm		= 'Confirmer et procéder';
	$ln_error		= stripslashes('Mauvaise réponse. S\'il vous plaît lire attentivement la question et sélectionnez de nouveau.');
	$ln_email_error	= 'Please enter your name and email address.';
	$ln_thanks		= stripslashes('Merci d\'avoir pris le quiz!');
	$ln_close		= 'Vous pouvez maintenant fermer cet écran en cliquant sur le «X» sur votre onglet du navigateur.';
	$ln_thank_you	= stripslashes('Je vous remercie d\'avoir pris le quiz!');
	$ln_name		= 'Nom complet';
	$ln_email		= 'Email';
	$ln_submit 		= 'Confirmer et procéder';

	
}