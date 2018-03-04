<?php
	Controller::setSession();
	$question_id = $_SESSION['question_id'];
	$qinstance_id = $_SESSION['qinstance_id'];
	$question_row = Controller::fetch("SELECT * from questions where question_id = ?", array($question_id));
	$qinstance_row = Controller::fetch("SELECT * from quiz_instance where qinstance_id = ?", array($qinstance_id));
	$answers = array($question_row['answer_correct'],$question_row['answer_wrong1'],$question_row['answer_wrong2'],$question_row['answer_wrong3']);
	shuffle($answers);
	$timer = $qinstance_row['duration'];
	$question_number = Controller::selectQuestionNumber($qinstance_id);
	//var_dump($question_number);
?>
<script>
	$(document).ready(function(){
		var x = <?php echo $timer; ?>;
		$('#timer').val(x);
		setInterval(function(){
			x= x-1;
			if(x<0){
				$('.answer-form').submit();
			};
			$('#timer').val(x);
		}, 1000);
	});

	$(document).ready(function(){
		$('.answer').click(function(){
			$('#answer-value').val($(this).html());
			$('.answer-form').submit();
		});
	});
</script>
<form action='quiz-answer' method='POST' class='answer-form'>
<div class='quiz-take-wrapper'>
	<div class='question-number'>
		<!-- Question number here -->
		<h4>Question Number: <?php echo $question_number;?></h4>
	</div>
	<div class='question-region'>
		<h2 class='question-region'><?php  echo $question_row['region'];?></h2>
	</div>

	<div class='question-timer'>
		<h4>Time left:</h4>
		<input type='text' disabled='true' name='timer' value'<?php echo $timer;?>' id='timer'>
	</div>
	<div class='question-question'>
		<p> <?php echo $question_row['question']; ?></p>
	</div>

	<div class='question-answers'>
			<input type='hidden' value='' name='answer' id='answer-value'>
			<button class='answer' type='button' accesskey="z"><?php echo $answers[0]?></button>
			<button class='answer' type='button' accesskey="x"><?php echo $answers[1]?></button>
			<button class='answer' type='button' accesskey="c"><?php echo $answers[2]?></button>
			<button class='answer' type='button' accesskey="v"><?php echo $answers[3]?></button>
		</form>
	</div>
</div>
