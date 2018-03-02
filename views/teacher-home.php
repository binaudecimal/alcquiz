<?php


?>
<script>
	function fetchItem(){
			var get = document.getElementById('item').value;
			document.getElementById('item-input').value=get;
	}

	function fetchDuration(){
			var get = document.getElementById('duration').value;
			document.getElementById('duration-input').value=get;
	}

	function fetchItemInput(){
			var get = document.getElementById('item-input').value;
			document.getElementById('item').value=get;
	}

	function fetchDurationInput(){
			var get = document.getElementById('duration-input').value;
			document.getElementById('duration').value=get;
	}
	$(document).ready(function(){
			 //$('#item').val($('#item-input').val());
			 itemValue = $('#item').val();
			 durationValue = $('#duration').val();
			 $('#item-input').val(itemValue);
			 $('#duration-input').val(durationValue);
	});

</script>
<div class='main-wrapper'>
	<form action='add-question-form' method='POST'>
		<button type='submit' name='addQuestion'>Add Question </button>
	</form>
	<form action='edit-question-populate' method='POST'>
		<button type='submit' name='editQuestion'>Edit Question </button>
	</form>

	<a href='#popup1'>Activate Quiz for Students</a>
	<div id="popup1" class="overlay">
		<div class="popup">
			<h2>Start Quiz</h2>
			<a class="close" href="#">&times;</a>
			<div class="content">
				<p>
					Do you wish to start a quiz for all of the students? All active quiz
					will be marked complete and scores will be finalized.
				</p>
				<form action='activate-quiz' method='POST'>
					<input type='range' name='items' min='5' max='15' label='Items: ' id='item' onchange='fetchItem()'><input type='text' id='item-input' name='item-input' onchange="fetchItemInput()"><br>
					<input type='range' name='duration' min='5' max='15' label='Duration: ' id='duration' onchange='fetchDuration()'><input type='text' id='duration-input' name='duration-input' onchange="fetchDurationInput()"></p><br>
					<button type='submit' name='activate-quiz-submit'>ACTIVATE QUIZ</button>
				</form>
			</div>
		</div>
	</div>
</div>
