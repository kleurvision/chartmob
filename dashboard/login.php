<? // Login Page

// Load bootstrap file
require('../bootstrap.php');

// Page Variables
$page_title	= 'Chartmob Administration Login';
$page_slug	= 'login';

// Login logic
$messages	= do_login();

// Load header
require( ROOT .'assets/php/header.php');

// Login messaging
login_messages($messages);

?>

<div class="row">        
	<form class="form-signin" method="POST" action="">
		<h2 class="form-signin-heading">Please sign in</h2>
		<input type="text" class="input-block-level" name="userName" placeholder="Email address">
		<input type="password" class="input-block-level" name="Password" placeholder="Password">
		<button class="btn btn-large btn-primary" name="LoginButton" value="Signin" type="submit">Sign in</button>
	</form>
</div>

<? // Load footer
require( ROOT .'assets/php/footer.php');?>
