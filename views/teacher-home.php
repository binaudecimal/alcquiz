<?php
	$data = Controller::selectTopStudents();
	$session = mt_rand(1,999);
?>
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
    $(document).ready(function(){
            //$('#myModal').modal(options);    
              $("#quizStart").click(function(event){
            $('#quizModal').modal('show'); 
            });
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


<div class='container-fluid'>
		<div class='row'>
            <div class='col-9'>
                <div class='row'>
                    <div class='container'>
                        <div class='btn-group' role='group'>
                            <form action='add-question-form' method='POST'>
                                <button type='submit' name='addQuestion' class='btn btn-light btn-lg'>Add Question</button>
                            </form>

                            <form action='populate-question' method='POST'>
                                <button type='submit' name='editQuestion' class='btn btn-light btn-lg'>Edit Question</button>
                            </form>
                            <button type="button" id='quizStart' class="btn btn-light" data-toggle="modal" data-target="#quizModal">
                                  Activate Quiz
                            </button>
                        </div>
                    </div>
                </div>
            </div>
		</div> <!-- row of buttons-->
        <div class='row justify-content-center'> <!-- Row of status -->
            <?php 
                if(isset($_GET['status'])){
                    switch($_GET['status']){
                        case 'activate-success': echo "
                            <div class='alert alert-success' role='alert'>
                                Quiz successfully started.
                            </div>
                        ";
                    }
                }
            ?>
        </div>
        <div class='row'> <!-- Row of chart and logs -->
            <div class='col-9'>
                <div class='container' style='height:400px;'>
                    <div class='dashboard'>
                    <canvas id='myChart' width='400px' height='400px'>
                    </canvas>
                
                </div>
            </div>
		</div>
            <div class='col-3'>
                <div class='card' style='height:400px;'>
                    <div class='card-header'>
                        Student's chat
                    </div>
                    <div class='card-body'>
                        
                        <div class='chats' id="chat_output" style='overflow-y: scroll;
                            height: 300px;'>
                            <!-- chats here -->
                        </div>

                    </div>
                </div>
                <div class='card' style='height:400px;'>
                    <div class='card-header'>
                        Logs
                    </div>
                    <div class='card-body'>
                        <div class='logs' id='logs' style='overflow-y: scroll;
                            height: 300px;'>
                            <!-- logs here-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
		<div id="quizModal" class="modal fade" role='dialog' tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
				        <h5 class='modal-title'>Start Quiz</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <p class='lead'>
                            Do you wish to start a quiz for all of the students? All active quiz
                            will be marked complete and scores will be finalized.
                        </p>
                    </div>
                    <div class='modal-footer'>
                        <form action='activate-quiz' method='POST'>
                            <div class='row'>
                                <input type='range' name='items' min='5' max='15' label='Items: ' id='item' onchange='fetchItem()'>
                                <input type='text' id='item-input' name='item-input' onchange="fetchItemInput()" class='form-control'>
                            </div>
                            <div class='row'>
                                <input type='range' name='duration' min='5' max='15' label='Duration: ' id='duration' onchange='fetchDuration()'>
                                <input type='text' id='duration-input' name='duration-input' onchange="fetchDurationInput()">
                            </div>
                            <div class='row'>
                                <button type='submit' name='activate-quiz-submit' accesskey="q" class='btn btn-primary'>ACTIVATE QUIZ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
			</div>
		</div>

