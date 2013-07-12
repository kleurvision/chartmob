<? 

	require('../bootstrap.php');
	
	// Delete certain session
	unset($_SESSION['user']);
	unset($_SESSION['ID']);
	unset($_SESSION['Type']);
	
	// Delete all session variables
	 session_destroy();
	
	// Jump to login page
	header('Location:'.URL);

?>