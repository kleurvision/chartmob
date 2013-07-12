<? /* 360 American Standard Quiz Template */
require('../../bootstrap.php');

// Get the quiz ID from the URL
$quizID = $_GET['q'];

// Query the database for all necessary data
global $db;
$quiz 		= $db->get_row("SELECT * FROM quiz WHERE id = '$quizID'");
$client		= $db->get_row("SELECT * FROM client WHERE id = '".$quiz->client_id."'");
$slides 	= $db->get_results("SELECT * FROM slides WHERE quiz_id = '$quizID'");
$questions 	= $db->get_results("SELECT * FROM questions WHERE quiz_id ='$quizID'");

// Load in the page header
include( '../../structure/header.php'); ?>

<? if ($_POST['fullname'] && $_POST['email'] && !$_POST['names']){

	$sumbit = $db->query("INSERT INTO respondents (client_id, quiz_id, fullname, email) VALUES ('".$quiz->client_id."', '$quizID', '".$_POST['fullname']."', '".$_POST['email']."')");
	
	$from = "ahumenny@360incentives.com";
	// $to = "Sara Martin <smartin@360incentives.com>";
	$to = 'info@kleurvision.com';
	$subject = "Quiz Results";
	$body = "Full Name: ".$_POST['fullname']."\n"."Email: ".$_POST['email'];

	send_mail($to, $from, $subject, $body, $report = false);
?>
            <div class="contentContainer">
            
           		<div id="titleContainer" class="questionContainer">
                	<div class="question">
						<h1 style="text-align:center; margin-top:150px;padding:0px;"><?=$ln_thanks;?></h1>
                        <p style="text-align:center;"><?=$ln_close;?></p>
                    </div>
           		</div>
           	</div>
<?
	} else { ?>


<form id="quiz" name="quiz" action="" method="post">

<? // Load in title slide // ?>	
<div id="titleContainer" class="questionContainer">
	<div class="slide home" style="background:url(images/<?=$quizID;?>/home.png) no-repeat 0 0;">
		<h1 class="logo">American Standard</h1>
    	<? if($quiz->language == 'English'){?>
    		<p class="tag"><?=$client->tagline;?></p>
    		<?=$client->cover_text;
	    } else if($quiz->language == 'French'){?>
		    <p class="tag"><?=$client->tagline_fr;?></p>
	        <?=$client->cover_text_fr;
		} ?>
        <div class="next">
			<input class="advance" type="button" value="<?=$ln_begin;?>" onclick="slideLeft(0);" />
		</div>
	</div>
</div> 

<? // Loop through training slides //
$count = '1';
if($slides){
	foreach($slides as $slide){ ?>
		<div class="questionContainer">
			<div class="slide" style="background:url(images/<?=$quizID;?>/slide-<?=$count;?>.png) no-repeat 0 0;">
				<h2 class="qq"><? echo $slide->title;?></h2>
				<? echo $slide->content;?>
				<div class="next">
					<input class="goback" type="button" value="<?=$ln_back;?>" onclick="slideRight();" />
					<input class="advance" type="button" value="<?=$ln_next;?>" onclick="slideLeft(0);" /></li>
				</div>
			</div>
		</div>
	<? $count++; } 
}	
// Load in quiz advance slide //	
?>
<div class="questionContainer">
	<div class="slide" style="background:none;">
	    <h2><?=$ln_ready;?></h2>
	    <p><?=$ln_ready_txt;?></p>
	   	<div class="next">
	   		<input class="goback" id="goback" type="button" value="<?=$ln_review;?>" onclick="slideToBeginning();" />
	   		<input class="advance" type="button" value="<?=$ln_proceed;?>" onclick="slideLeft(0);" />
	   	</div>
	</div>
</div>

<? // Load in quiz questions //
$q = 1;
if($questions){
foreach($questions as $question){ ?>
	<div class="questionContainer">
		<div class="question" id="question_q<?=$q;?>">
			<div class="q<?=$q;?>error error"><?=$ln_error;?></div>
			<h2><?=$question->question;?></h2> 
			
			<ul id="q<?=$q;?>">
			<?	$answers = unserialize($question->answer);
				// $answers = uksort($answers, function() { return rand() > rand(); });
				
				if($answers){
					foreach($answers as $answer){ 
						if($answer['correct'] == '1'){
							$value = 'value="correct"';
						} else {
							$value = 'value="incorrect"';
						} ?>
						<li>
							<input type="radio" name="q<?=$q;?>" class="response<?=$q;?>" <?=$value;?>/>
							<label><?=stripslashes($answer['value']);?></label>
						</li>
				<? }
				} ?>
			</ul>
			
			<div class="next">
				<? if($q >= 2){ ?>
				<input class="goback" type="button" value="<?=$ln_back;?>" onclick="slideRight();" />
				<? } ?>
				<input class="advance" type="button" value="<?=$ln_confirm;?>" onclick="submitAnswer('q<?=$q;?>');" />
			</div>
		</div>
	</div>	
		
	<? $q++; } 
}
// Load in final slide //	
?>
<div id="finalContainer" class="questionContainer">
	<div class="question">
		<ul id="final">
	        <div class="lasterror error"><?=$ln_email_error;?></div>
	        <h2><?=$ln_thank_you;?></h2>
	        <li>
	        	<label class="withtext"><?=$ln_name;?></label>
	        	<input id="fullname" type="text" name="fullname" value="Full Name" />
	        </li>
	        <li>
	        	<label class="withtext"><?=$ln_email;?></label>
	        	<input id="email" type="text" name="email" placeholder="Email Address" />
	        </li>
	        	<input id="names" type="text" name="names" placeholder="Names" />
	        <div class="next">
				<? if($q >= 2){ ?>
				<input class="goback" type="button" value="Back" onclick="slideRight();" />
				<? } ?>
				<input type="submit" value="Confirm and Proceed" onclick="submitQuiz();" />
			</div>
	    </ul>
	</div>
</div> 

</form>

<? }; // End form submission check

include( '../../structure/footer.php');
?>