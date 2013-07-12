<? 
	require('../bootstrap.php');
	$quizID = $_GET['id'];
			
	// ADD QUESTION 
	$addNote = $_POST['addSlide'];
	if($addNote){
		$title		= $_POST['title'];
		$content	= $db->escape($_POST['content']);
		$order		= $_POST['order'];
		
		$db->query("INSERT INTO slides (quiz_id, title, content, slide_order) VALUES ('$quizID', '$title', '$content', $order)");
	}
	
	// GET quiz INFO
	$quiz = $db->get_row("SELECT * FROM quiz WHERE id= '$quizID'");
	
	// Get QUESTIONS
	$slides = $db->get_results("SELECT * FROM slides WHERE quiz_id= '$quizID'");
	
	include( ROOT .'assets/php/header-loggedin.php');
?>

      <div class="row-fluid">
	      <div class="span12 well">
	      
	      <? $form = new Form("AddSlide");
		     $form->configure(array(
				 "action" => "",
				));
		     $form->addElement(new Element_HTML('<legend>Add slides to ' . $quiz->title . '</legend>'));
		     $form->addElement(new Element_Textbox("Title:", "title"));
		     $form->addElement(new Element_TinyMCE("Content:", "content"));
		     $form->addElement(new Element_Textbox("Order:", "order"));
		     $form->addElement(new Element_Button("Submit"));
		     $form->addElement(new Element_Hidden("addSlide", "true"));
		     $form->render();
		  ?>
	      </div>
	      <div class="span9 well">
	      	<? if( is_null($slides)){?> 
	      		<h3>Currently no sliodes for <?= $quiz->title?></h3>
	      	<? } else {?>
	      	    <h2>Questions for <?= $quiz->title?></h2>  
        	<table class="table table-hover">
	        	 <thead>
					<tr>
						<th>Side ID</th>
						<th>Title</th>
						<th>Order</th>
					</tr>
				</thead>
				<tbody>
				<? foreach ($slides as $slide){?>
					<tr>
						<td><?= $slide->id;?></td>
						<td><?= $slide->title;?></td>
						<td><?= $slide->slide_order;?></td>
					</tr>
				<? } ?>
				</tbody>
	       </table>
	       <? } ?>
        </div><!--/span-->
        
      </div><!--/row-->
      
      <hr>
<? require(ROOT .'assets/php/footer-loggedin.php');?>
