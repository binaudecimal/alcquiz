<?php
	Controller::setSession();
	//populate the list
	$list = Controller::selectAllQuestions();
?>

<?php
if(isset($_GET['status'])){
	$status = $_GET['status'];
	switch($status){
		case 'updateQuestion-success': echo "<h2 class='status-green' style='color:green'>Question updated successfully.</h2>";break;
	}
}
 ?>
<div class='edit-question-table'>
	<table>
		<tr>
			<td>Question ID</td>
			<td>Question</td>
			<td>Correct Answer</td>
			<td>Wrong Answer 1</td>
			<td>Wrong Answer 2</td>
			<td>Wrong Answer 3</td>
			<td>Region</td>
			<td></td>
		</tr>
		<?php
			if(!$list){
				echo "
					<tr>
						<td>N/A</td>
						<td>N/A</td>
						<td>N/A</td>
						<td>N/A</td>
						<td>N/A</td>
						<td>N/A</td>
						<td>N/A</td>
						<td></td>
					</tr>
				";
			}
			else{ //populate
				foreach($list as $row){
					echo "
						<tr>
							<td>". $row['question_id']."</td>
							<td>". $row['question']."</td>
							<td>". $row['answer_correct']."</td>
							<td>". $row['answer_wrong1']."</td>
							<td>". $row['answer_wrong2']."</td>
							<td>". $row['answer_wrong3']."</td>
							<td>". $row['region']."</td>
							<td><a href='edit-question?question_id=". $row['question_id'] ."'>Edit</a></td>
						</tr>
					";
				}
			}
		?>
	</table>
</div>
