<?php
	$data = Controller::selectTopStudents();
	$session = mt_rand(1,999);
?>
<script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
<style>

</style>
<script>
	function fetchItem(){
			var get = document.getElementById('item').value;
			document.getElementById('item-input').value=get;
	};

	function fetchDuration(){
			var get = document.getElementById('duration').value;
			document.getElementById('duration-input').value=get;
	};

	function fetchItemInput(){
			var get = document.getElementById('item-input').value;
			document.getElementById('item').value=get;
	};

	function fetchDurationInput(){
			var get = document.getElementById('duration-input').value;
			document.getElementById('duration').value=get;
	};

	$(document).ready(function(){
			 //$('#item').val($('#item-input').val());
			 itemValue = $('#item').val();
			 durationValue = $('#duration').val();
			 $('#item-input').val(itemValue);
			 $('#duration-input').val(durationValue);
	});
	$(document).ready(function(){
		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, <?php  echo $data?>);
		Chart.defaults.scale.ticks.beginAtZero = true;
	});

	//websocket_server
	jQuery(function($){
		// Websocket
		var websocket_server = new WebSocket("ws://localhost:8080/");
		websocket_server.onopen = function(e) {
			console.log("connected");
		}
		websocket_server.onerror = function(e) {
			// Errorhandling
		}
		websocket_server.onmessage = function(e)
		{
			var json = JSON.parse(e.data);
			switch(json.type) {
				case 'chat':
					$('#chat_output').append(json.msg);
					break;
				case 'logs':
					$('#logs').append(json.msg);
					console.log($("#logs"));
					break;
			}
		}
		// Events
	});
	//eof
</script>

<div class='teacher-home-wrapper'>
		<div class='teacher-buttons'>
			<form action='add-question-form' method='POST'>
				<button type='submit' name='addQuestion'>Add Question </button>
			</form>

			<form action='populate-question' method='POST'>
				<button type='submit' name='editQuestion'>Edit Question </button>
			</form>
			<a href='#popup1' accesskey="a">Start New Quiz</a>
		</div>
		<div class='filler'></div>
		<div class='teacher-home-status'>
			<!-- status here-->

		</div>

		<div class='dashboard'>
			<canvas id='myChart' width='400' height='400'>
			</canvas>
		</div>


		<div class='chats' id="chat_output" overflow='scroll'>
			<!-- chats here -->
		</div>

		<div class='logs' id='logs'>
			<!-- logs here-->
		</div>

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
						<button type='submit' name='activate-quiz-submit' accesskey="q">ACTIVATE QUIZ</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- eof -->
</div>
