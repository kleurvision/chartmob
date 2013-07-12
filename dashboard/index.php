<? 
	require('../bootstrap.php');
	include( 'assets/php/header-loggedin.php');
	
	// ADD Client
	$addClient = $_POST['AddClient'];
	if($addClient){
		$client		= $_POST['client'];
		$slug		= to_permalink($client);
		$db->query("INSERT INTO client (name, slug) VALUES ('$client','$slug')");
	}
	
	// ADD Quiz
	$addQuiz = $_POST['AddQuiz'];
	if($addQuiz){
		$title		= $_POST['title'];
		$desc		= $db->escape($_POST['description']);
		$client		= $_POST['client'];
		$client 	= $db->get_row("SELECT id FROM client WHERE name= '$client'");
		$language	= $_POST['language'];
		$clientID = $client->id;

		$db->query("INSERT INTO quiz (title, description, language, client_id) VALUES ('$title', '$desc', '$language', '$clientID')");
	}
	
	$clients = $db->get_results("SELECT name FROM client ORDER BY name DESC");
	$clientList = array();
	foreach($clients as $client){
		$clientList[] = $client->name;
	}
	
	
	$quizes = $db->get_results("SELECT * FROM quiz ORDER BY id DESC");
	

?>

      <div class="row-fluid">
	      <div class="span3">
			<div class="well">	      
		      	<? $form = new Form("AddClient");
				     $form->configure(array(
						 "action" => "",
						 "view" => new View_Vertical
						));
				     $form->addElement(new Element_HTML('<legend>Add New Client</legend>'));
				     $form->addElement(new Element_Textbox("Client:", "client"));
				     $form->addElement(new Element_Button("Add Client"));
				     $form->addElement(new Element_Hidden("AddClient", "true"));
				     $form->render();
				  ?>
			</div>
			
			<div class="well">	      
		      	<? 
		      		$langOptions = array('English','French');
		      		$form = new Form("AddQuiz");
				     $form->configure(array(
						 "action" => "",
						 "view" => new View_Vertical,
						));
				     $form->addElement(new Element_HTML('<legend>Add New Quiz</legend>'));
				     $form->addElement(new Element_Select("Client:", "client", $clientList));
   				     $form->addElement(new Element_Textbox("Title:", "title"));
				     $form->addElement(new Element_Textarea("Description:", "description"));
				     $form->addElement(new Element_Radio("Language:", "language", $langOptions));
				     $form->addElement(new Element_Button("Add Quiz"));
				     $form->addElement(new Element_Hidden("AddQuiz", "true"));
				     $form->render();
				  ?>
			</div>
			
	      </div>
        <div class="span9 well">
        	<h1>Quizzes</h1>
					<? if(!$quizes){
						echo('Currently no Quizzes');
					} else {?>
					<table class="table table-hover">
			        	 <thead>
							<tr>
								<th>Quiz ID</th>
								<th>Title</th>
								<th>Description</th>
								<th>Language</th>
								<th>No. Of Enteries</th>
								<th>Client ID</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<? foreach ($quizes as $quiz){
							$currentQuiz = $quiz->id;
							$respondentsNo = $db->get_var("SELECT count(*) FROM respondents WHERE quiz_id = $currentQuiz");
						?>
						<tr>
						<td><?= $quiz->id;?></td>
						<td><?= $quiz->title;?></td>
						<td><?= $quiz->description;?></td>
						<td><?= $quiz->language;?></td>
						<td><?= $respondentsNo?></td>
						<td><?= $quiz->client_id;?></td>
						<td> 
							<a class="btn btn-small btn-primary" href="questions?id=<?= $quiz->id;?>" ><i class="icon-plus icon-white"></i> Questions</a>
							<a class="btn btn-small btn-primary" href="slides?id=<?= $quiz->id;?>" ><i class="icon-plus icon-white"></i> Slides</a>
						</td>
						</tr>
						<? } ?>
						</tbody>
			       </table>
				<? } ?>
        </div><!--/span-->
      </div><!--/row-->

      <hr>
<? require('assets/php/footer-loggedin.php');?>
