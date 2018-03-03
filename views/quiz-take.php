<?php
	Controller::setSession();
	$question_id = $_SESSION['question_id'];
	$qinstance_id = $_SESSION['qinstance_id'];
	$question_row = Controller::fetch("SELECT * from questions where question_id = ?", array($question_id));
	$qinstance_row = Controller::fetch("SELECT * from quiz_instance where qinstance_id = ?", array($qinstance_id));
	$answers = array($question_row['answer_correct'],$question_row['answer_wrong1'],$question_row['answer_wrong2'],$question_row['answer_wrong3']);
	shuffle($answers);
	$timer = $qinstance_row['duration'];
?>

<div class='main-wrapper'>
	<div class='question-space'>
		<h4 class='question-region'><?php  echo $question_row['region'];?></h4>
		<h4 class='question-timer'><?php echo $timer?></h4>
		<p class='question-question'>
			<?php  echo $question_row['question']; ?>
		</p>
		<div class='question-answers'>
			<span>
			<?php
				foreach ($answers as $row) {
					//remove quotes
					echo "<a href='quiz-answer?answer=".$row."''> ". $row ." </a><br>";
				}
			?>
			</span>
		</div>
	</div>
</div>
