<?php
  if(!isset($_GET['question_id'])){
    header('Location: home?status=error');
    exit();
  }
  else{
    $question_id = $_GET['question_id'];
    $question_row = Controller::selectQuestion($question_id);
  }
?>

<div class='edit-question-form-wrapper'>
	<h2>Add Question</h2>
		<form action='update-question' method='POST'>
      <input type='hidden' value='<?php echo $question_id;?>' name='question_id'>
		<input type='text' name='region' disabled='true' value='<?php echo $question_row['region'];?>'>
		<input type='text' name='question' placeholder='Question' autofocus="auto" required value='<?php echo $question_row['question'];?>'>
		<input type='text' name='answer_correct' placeholder='Correct Answer'required value='<?php echo $question_row['answer_correct'];?>'>
		<input type='text' name='answer_wrong1' placeholder='Wrong Answer'required value='<?php echo $question_row['answer_wrong1'];?>'>
		<input type='text' name='answer_wrong2' placeholder='Wrong Answer'required value='<?php echo $question_row['answer_wrong2'];?>'>
		<input type='text' name='answer_wrong3' placeholder='Wrong Answer'required value='<?php echo $question_row['answer_wrong3'];?>'>
		<button type='submit'>SUBMIT</button>
	</form>
  <a href=#delete-confirm>DELETE</a>
</div>

<div id="delete-confirm" class="overlay">
  <div class="popup">
    <h2>Start Quiz</h2>
    <a class="close" href="#">&times;</a>
    <div class="content">
      <p>
        This question will be disabled on all further quizzes. Do you with to continue?
      </p>
    </div>
    <a id='conf-del' href='delete-question?question_id=<?php echo $question_id;?>'>CONFIRM DELETE</a>
  </div>
</div>
