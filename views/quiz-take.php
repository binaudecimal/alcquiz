<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>

<div class='main-wrapper'>
	<div class='question-space'>
		<h4 class='question-region'><?php  echo $_SESSION['region'];?></h4>
		<h4 class='question-timer'>10</h4>
		<p class='question-question'>
			<?php  echo $_SESSION['question']; ?>
		</p>
		<div class='question-answers'>
			<span>
			<?php
				foreach ($_SESSION['answers'] as $row) {
					//remove quotes
					echo "  <a href='quiz-answer?answer=".$row."''> ". $row ." </a><br>";
				}
			?>
			</span>
		</div>
	</div>
</div>
