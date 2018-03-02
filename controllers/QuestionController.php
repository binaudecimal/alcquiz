<?php
	class QuestionController extends Controller{
		public static function addQuestion(){
			$region = $_POST['region'];
			$question = $_POST['question'];
			$answer_correct = $_POST['answer_correct'];
			$answer_wrong1 = $_POST['answer_wrong1'];
			$answer_wrong2 = $_POST['answer_wrong2'];
			$answer_wrong3 = $_POST['answer_wrong3'];

			if(empty($region) || empty($question) || empty($answer_correct)  || empty($answer_wrong1)  || empty($answer_wrong2)  || empty($answer_wrong3) ){ //check for blanks
				header('Location: add-question-form?status=empty');
				exit();
			}
			else{
				$sql = "INSERT into questions (question, answer_correct, answer_wrong1, answer_wrong2, answer_wrong3,region, active_status) values (?,?,?,?,?,?,?)";
				self::query($sql, array($question, $answer_correct, $answer_wrong1,$answer_wrong2,$answer_wrong3,$region, true));
				header('Location: add-question-form?status=addsuccess');		
				exit();		
			}
		}

		public static function populate(){
			if(!isset($_SESSION)){
				session_start();
			}
			$sql = "SELECT * from questions;";
			$question_list = self::query($sql);
			//	var_dump($question_list);
			$_SESSION['question_list'] = $question_list;
			//$this::set('question_list', $question_list);
			header('Location: question-edit-list');
			exit();
		}

		public static function activateQuiz(){

			$duration = 10;
			$items = 10;
			$sql = "SELECT user_id from users where type = 'STUDENT'";
			$users = self::query($sql, array());
			if(!is_null($users)){
				foreach ($users as $row) {
					$sql = "INSERT into quiz_instance (items, duration, user_id) values (?,?,?)";
					self::query($sql, array($items, $duration, $row['user_id']));
				}
			}

			header('Location: home?status=activated');
			exit();

		}

		public static function generateQuestionSet(){
			if(!isset($_SESSION)){
				session_start();
			}

			if(isset($_GET['region']) && isset($_SESSION['u_user_id'])){
				$region = $_GET['region'];
				$user_id = $_SESSION['u_user_id'];
				$sql = "SELECT * from quiz_instance where user_id = ?";
				$qinstance = self::fetch($sql, array($user_id));
				if(is_null($qinstance)){ //check if quiz active
					header('Location: home?noactivequiz');
					exit();
				}
				else{ //there is an active quiz
					if(!empty($qinstance['region'])){
						//continue current quiz
						echo "not working";
						header("Location: quiz-take?user_id=".$user_id. '&qinstance_id='.$qinstance['qinstance_id']);
						exit();
					}
					else{	//not yet started, generate quiz set
						$limit = $qinstance['items'];
						$duration = $qinstance['duration'];

						$sql = "SELECT * from questions where region = ? ORDER BY RAND() limit " .$limit;
						$result = self::query($sql, array($region));
						//var_dump($result);
						//insert answer instance for each row
						foreach($result as $row){
							$sql = "INSERT into answer_instance (user_id, question_id, qinstance_id) values (?,?,?)";
							self::query($sql, array($user_id, $row['question_id'], $qinstance['qinstance_id']));
						}
						self::query("UPDATE quiz_instance set region = ? where qinstance_id = ?",array($region, $qinstance['qinstance_id']));

						//quiz generated, send for answers

						header('Location: quiz-take?status=success&qinstance_id =' . $qinstance['qinstance_id'] . '&user_id = ' . $user_id);
						exit();
					}
				}
			}
			else{
				header('Location: home?status=conneror');
				exit();
			}
			
		}

		public static function generateQuestion(){
			if(!isset($_SESSION)){
				session_start();
			}
			$user_id = $_GET['user_id'];
			$qinstance_id = $_GET['qinstance_id'];
			//fetch quiz_instance 
			$sql = "SELECT question_id, ainstance_id from answer_instance where user_id = ? and qinstance_id = ? and weighted_score is null";
			$question_id = self::fetch($sql, array($user_id, $qinstance_id));
			//fetch the question itself
			$sql = 'SELECT * from questions where question_id = ?';
			$question_row = self::fetch($sql, array($question_id['question_id']));
			$answer_array = array($question_row['answer_correct'],$question_row['answer_wrong1'],$question_row['answer_wrong2'],$question_row['answer_wrong3']);
			$_SESSION['ainstance_id'] =  $question_id['ainstance_id'];
			$_SESSION['question_id'] = $question_id['question_id'];
			$_SESSION['question'] = $question_row['question'];
			$_SESSION['region'] = $question_row['region'];
			shuffle($answer_array);
			$_SESSION['answers'] = $answer_array;
			//get duration
			
			$_SESSION['duration'] = (self::fetch("SELECT duration from quiz_instance where qinstance_id = ?",array($qinstance_id)))['duration'];
			//var_dump($_SESSION);
		}

		public static function processAnswer(){
			self::setSession();
			if(!isset($_GET['answer'])){
				header('Location: quiz-start?status=error');
				exit();
			}
			else{ //check for answer match
				//get ainstance
				$answer = $_GET['answer'];
				$sql = "SELECT * from answer_instance where ainstance_id = ?";
				$ainstance_row = self::fetch($sql, array($_SESSION['ainstance_id']));
				if(is_null($ainstance_row)){
					echo "Something went wrong";
				}	
				else{
					//find the question
					$question_id = $_SESSION['question_id'];
					$ainstance_id = $_SESSION['ainstance_id'];

					$question_row = self::fetch("SELECT answer_correct from questions where question_id = ?", array($question_id));
					$correct_answer = $question_row['answer_correct'];
					echo strcmp($correct_answer, $answer);
					
				}

			}
		}
	}
?>