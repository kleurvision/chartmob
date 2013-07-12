<? /*
 * Password hashing with PBKDF2.
 * Author: havoc AT defuse.ca
 * www: https://defuse.ca/php-pbkdf2.htm
 */


function create_hash($password)
{
    // format: algorithm:iterations:salt:hash
    $salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTES, MCRYPT_DEV_URANDOM));
    return PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" .  $salt . ":" .
        base64_encode(pbkdf2(
            PBKDF2_HASH_ALGORITHM,
            $password,
            $salt,
            PBKDF2_ITERATIONS,
            PBKDF2_HASH_BYTES,
            true
        ));
}

function validate_password($password, $good_hash)
{
    $params = explode(":", $good_hash);
    if(count($params) < HASH_SECTIONS)
       return false;
    $pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);
    return slow_equals(
        $pbkdf2,
        pbkdf2(
            $params[HASH_ALGORITHM_INDEX],
            $password,
            $params[HASH_SALT_INDEX],
            (int)$params[HASH_ITERATION_INDEX],
            strlen($pbkdf2),
            true
        )
    );
}

// Compares two strings $a and $b in length-constant time.
function slow_equals($a, $b)
{
    $diff = strlen($a) ^ strlen($b);
    for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
    {
        $diff |= ord($a[$i]) ^ ord($b[$i]);
    }
    return $diff === 0;
}

/*
 * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
 * $algorithm - The hash algorithm to use. Recommended: SHA256
 * $password - The password.
 * $salt - A salt that is unique to the password.
 * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
 * $key_length - The length of the derived key in bytes.
 * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
 * Returns: A $key_length-byte key derived from the password and salt.
 *
 * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
 *
 * This implementation of PBKDF2 was originally created by https://defuse.ca
 * With improvements by http://www.variations-of-shadow.com
 */
function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
{
    $algorithm = strtolower($algorithm);
    if(!in_array($algorithm, hash_algos(), true))
        die('PBKDF2 ERROR: Invalid hash algorithm.');
    if($count <= 0 || $key_length <= 0)
        die('PBKDF2 ERROR: Invalid parameters.');

    $hash_length = strlen(hash($algorithm, "", true));
    $block_count = ceil($key_length / $hash_length);

    $output = "";
    for($i = 1; $i <= $block_count; $i++) {
        // $i encoded as 4 bytes, big endian.
        $last = $salt . pack("N", $i);
        // first iteration
        $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
        // perform the other $count - 1 iterations
        for ($j = 1; $j < $count; $j++) {
            $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
        }
        $output .= $xorsum;
    }

    if($raw_output)
        return substr($output, 0, $key_length);
    else
        return bin2hex(substr($output, 0, $key_length));
}


/* RANDOM STRING GENERATOR FOR NEW USER PASSWORDS
*************************************************************/

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function to_permalink($str)
{
	    if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
	        $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
	    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
	    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
	    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
	    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
	    $str = strtolower( trim($str, '-') );
	    return $str;
}


function social_share(){ ?>
	<div class="socialShare">
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_tweet"></a>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
		</div>
		<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-517716fb6915be24"></script>
		<!-- AddThis Button END -->
	</div>
<? }


function get_theme($artist_name = ''){
	global $db;
	$theme_id	= $db->get_var("SELECT theme_id FROM artists WHERE artist_name = '$artist_name'");
	if($theme_id != ''){
		$theme 	= $db->get_row("SELECT * FROM themes WHERE id = '$theme_id'");
	} else {
		$theme = 'NA';
	}
		
	return $theme;
}


function do_login(){
	if ($_POST['LoginButton']){
		$user 		= $_POST['userName'];
		$password 	= $_POST['Password'];
		
		// EZ SQL as a global
		global $db;
		
		// Check for user info
		$userInfo = $db->get_row("SELECT email, password, ID FROM users WHERE email = '$user'");
		
		// Password check
		$encrptedPassword	= $userInfo->password;
		$passwordCheck		= validate_password($password, $encrptedPassword);
		
		// Set sessions and redirect to logged in or set error messages
		if($passwordCheck == 1){
    		$_SESSION['user']	= $userInfo->email;
			$_SESSION['ID']		= $userInfo->ID;
			header('Location:'.URL.'/dashboard');
		} else {
        	$messages['loginFailed'] = "Login Failed";
			return $messages;
		}
	}
}

function login_messages($messages = ''){
	if($messages){
 		foreach ($messages as $message){ ?>
	    	<div class="alert alert-error">
				<?= $message;?>                
			</div>
		<? }
	}
}