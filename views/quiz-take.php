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
<div class='main-wrapper'>
	<div class='question-space'>
		<h4 class='question-region'><?php  echo $question_row['region'];?></h4>
		<form action='quiz-answer' method='POST' class='answer-form'>
			<input type='text' disabled='true' name='timer' value'<?php echo $timer;?>' id='timer'>
			<input type='hidden' value='' name='answer' id='answer-value'>
			<p> <?php echo $question_row['question']; ?></p>
			<br>
			<button class='answer' type='button' accesskey="z"><?php echo $answers[0]?></button>
			<button class='answer' type='button' accesskey="x"><?php echo $answers[1]?></button>
			<button class='answer' type='button' accesskey="c"><?php echo $answers[2]?></button>
			<button class='answer' type='button' accesskey="v"><?php echo $answers[3]?></button>
		</form>
	</div>
</div>
