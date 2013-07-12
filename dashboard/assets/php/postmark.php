<? // Setup mail using Postmark API and shell command
function send_mail($to = 'concierge@kleurvision.com', $from = 'info@kleurvision.com', $subject = 'Test', $messageText = 'Test' , $report = true){
	
	$postmark_key	=	'1acc031b-49b8-489d-9e7e-c47a8319e4c9'; // 360 Incentives PM Key
	$mail = shell_exec('
			curl -X POST "http://api.postmarkapp.com/email/batch" \
			-H "Accept: application/json" \
			-H "Content-Type: application/json" \
			-H "X-Postmark-Server-Token:'.$postmark_key.'" \
			-v \
			-d "[{
					From: 		\''.$from.'\',
					To: 		\''.$to.'\',
					Subject: 	\''.$subject.'\',
					TextBody: 	\''.$messageText.'\'
				}]"
		');
	
	// Decode mail response
	if($report == true){
		if($mail){
			$msg = json_decode($mail);
			
			if ($msg[0]->Message == 'OK'){
				
				$message['email_success'] = 'Email successfully sent';
			
			} else {
				$message['error_code'] = $msg[0]->ErrorCode;
				$message['error_message'] = $msg[0]->Message;
			
			};
			
			echo '<ul>';
			foreach($message as $response){
				echo '<li>'.$response.'</li>';
			}
			echo '</ul>';
		} else {
			echo 'MailFail';
		}
	}

}

?>