<? 
	require('../bootstrap.php');
	$quizID = $_GET['id'];
	
	
	// GET quiz INFO
	$quiz = $db->get_row("SELECT * FROM quiz WHERE id= '$quizID'");
	
	// Get QUESTIONS
	$questions = $db->get_results("SELECT * FROM questions WHERE quiz_id= '$quizID'");

			
	// ADD QUESTION 
	$addNote = $_POST['addQuestion'];
	if($addNote){
		$question	= $_POST[question];
		$answer		= $_POST[answer];
		$answer		= serialize($answer);
		$db->query("INSERT INTO questions (quiz_id, question, answer) VALUES ('$quizID','$question','$answer')");
	}
	
	include( ROOT .'assets/php/header-loggedin.php');
?>
	<script>
		function make_the_donuts() {
    
		    // Create a new set of event inputs
		    newDiv = jQuery('.answer:last').clone(true).insertAfter('.answer:last');
		    var val = parseInt(jQuery('.answer:last').attr('value'));	
		   
		    // Increase the value
		    newDiv.attr("value", (val + 1));
		    newDiv.attr("id", "answer" + (val + 1)); 
		    newVal = val + 1;
		    
		    // Set the Remove button
		    if (jQuery('div').hasClass('removeBtn')){
			    newDiv.find('.removeBtn').remove();
			    newDiv.append('<div class="btn-small removeBtn btn btn-danger" id="remove'+newVal+'" onclick="remove_the_donuts('+newVal+')"><i class="icon-remove icon-white"></i> Remove</div>');
		    } else {
		    	newDiv.append('<div class="btn-small removeBtn btn btn-danger" id="remove'+newVal+'" onclick="remove_the_donuts('+newVal+')"><i class="icon-remove icon-white"></i> Remove</div>');
		    }
		    	    
		    newDiv.find('input, select').each(function(){
		        this.name = this.name.replace(/\[(\d+)\]/,function(str,p1){return '[' + (parseInt(p1,10)+1) + ']'});
		    });
		        
		}
		
		function remove_the_donuts(remove){	
			jQuery('#remove'+remove).parent('.answer').fadeOut(function(){
				jQuery('#remove'+remove).parent('.answer').remove();
			});
		};
	</script>

      <div class="row-fluid">
	      <div class="span4 well">
	      
	      <? $form = new Form("AddQuestion");
		     $form->configure(array(
				 "action" => "",
				 
				));
		     $form->addElement(new Element_HTML('<legend>Add Question for ' . $quiz->title . '</legend>'));
		     $form->addElement(new Element_Textbox("question:", "question"));
		     $form->addElement(new Element_HTML('<div id="answer" value="1" class="answer">'));
		     $form->addElement(new Element_Textbox("answer:", "answer[1][value]"));
		     $form->addElement(new Element_YesNo("Correct Answer:", "answer[1][correct]"));
		     $form->addElement(new Element_HTML('</div>'));
		     $form->addElement(new Element_HTML('<a class="btn btn-success" onclick="make_the_donuts()"><i class="icon-plus icon-white"></i> Add Answer</a>'));
		     $form->addElement(new Element_Button("Submit"));
		     $form->addElement(new Element_Hidden("addQuestion", "true"));
		     $form->render();
		  ?>
	      </div>
	      <div class="span8 well">
	      	<? if( is_null($questions)){?> 
	      		<h3>Currently no questions for <?= $quiz->title?></h3>
	      	<? } else {?>
	      	    <h2>Questions for <?= $quiz->title?></h2>  
        	<table class="table table-hover">
	        	 <thead>
					<tr>
						<th>Order</th>
						<th>Question</th>
					</tr>
				</thead>
				<tbody>
				<? $q = 1; 
				foreach ($questions as $question){?>
					<tr>
						<td><?= $q;?></td>
						<td><?= $question->question;?></td>
					</tr>
					<tr>
						<td></td>
						<td>
					<?	$answers = unserialize($question->answer);
					// $answers = uksort($answers, function() { return rand() > rand(); });
					
					if($answers){ ?>
							<? foreach($answers as $answer){ 
								if($answer['correct'] == '1'){
									$value = 'correct';
								} else {
									$value = '';
								} ?>
								
									<span class="answer"><?=stripslashes($answer['value']);?></span> <span class="value"><?=$value;?></span><br/>
							<? } ?>
					<?	} ?>
						</td>
					</tr>
				<? $q++; } ?>
				</tbody>
	       </table>
	       <? } ?>
        </div><!--/span-->
        
      </div><!--/row-->
      
      <hr>
<? require(ROOT .'assets/php/footer-loggedin.php');?>
