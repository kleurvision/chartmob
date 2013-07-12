<? 	/*  EzSQL 
	***********************************************************************/
	error_reporting(E_ALL ^ E_NOTICE);

	// Include ezSQL core
	include_once "dashboard/assets/ezsql/ez_sql_core.php";

	// Include ezSQL database specific component
	include_once "dashboard/assets/ezsql/ez_sql_mysql.php";

	// Initialise database object and establish a connection
	// at the same time - db_user / db_password / db_name / db_host
	$db = new ezSQL_mysql('dev','KVdevftp2012','chartmob','dev1.kleurvision.com');
	
	/*  PostMark 
	***********************************************************************/

	// Include PostMark Function
	include_once "dashboard/assets/php/postmark.php";

	// Include PHP Form Class Builder
	include_once "dashboard/assets/PFBC/Form.php";
	
	/*  Constant Variables 
	***********************************************************************/
	// Site Root Folder Path
	$root = '/Users/dev/Sites/pocketfuel/dashboard/';
	define ('ROOT', $root );
	
	// Site URL
	$url = 'http://dev1.kleurvision.com/pocketfuel';
	define ('URL', $url );
	
	session_start();
	
	if($_SESSION){	
		$user = $_SESSION['user'];
		define ('USER', $user);
		
		$userID = $_SESSION['ID'];
		define('USERID', $userID);
		
	}
	
	
	/* SALTED PASSWORD 
	*********************************************************************/
	// These constants may be changed without breaking existing hashes.
	define("PBKDF2_HASH_ALGORITHM", "sha256");
	define("PBKDF2_ITERATIONS", 1000);
	define("PBKDF2_SALT_BYTES", 24);
	define("PBKDF2_HASH_BYTES", 24);
	
	define("HASH_SECTIONS", 4);
	define("HASH_ALGORITHM_INDEX", 0);
	define("HASH_ITERATION_INDEX", 1);
	define("HASH_SALT_INDEX", 2);
	define("HASH_PBKDF2_INDEX", 3);
	
	include_once "dashboard/assets/php/functions.php";


	/* Include Language */
	// include_once "dashboard/l18n.php";

?>