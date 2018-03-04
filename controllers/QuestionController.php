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
				if(self::insertAddQuestion($question,$region , $answer_correct, $answer_wrong1,$answer_wrong2,$answer_wrong3)){
					header('Location: add-question-form?status=questionAdd-success');
					exit();
				}
				else{
					header('Location: add-question-form?status=questionAdd-failed');
					exit();
				}
			}
		}

		public static function populateQuestions(){
			if(!isset($_SESSION)){
				session_start();
			}
			$sql = "SELECT * from questions;";
			$statement = $pdo->prepare('SELECT * from questions where active_status = true');
			$statement->execute();
			$question_list = $statement->fetchAll(FETCH_ASSOC);
			//	var_dump($question_list);
			$_SESSION['question_list'] = $question_list;
			//$this::set('question_list', $question_list);
		}


		public static function activateQuiz(){
			if(isset($_POST['activate-quiz-submit'])){
				$duration = $_POST['duration-input'];
				$items = $_POST['item-input'];
				if(self::insertActivateQuiz($items, $duration)){
					header('Location: home?status=activate-success');
					exit();
				}
				else{
					header('Location: home?status=activate-failed');
					exit();
				}
			}
		}
		public static function startQuiz(){
			self::setSession();
			$region = $_GET['region'];
			$user_id = $_SESSION['u_user_id'];
			//check for active quiz, then check for
			if(self::fetch("SELECT * from quiz_instance where user_id = ? and region = ? and date_finished is NOT NULL",array($user_id, $region))){
				header('Location: home?status=quiz-taken');
				exit();
			}
			$data = self::fetch("SELECT * from quiz_instance where user_id = ? and date_finished is NULL", array($user_id));

			if($data != false){
				//quiz active check for region
				$qinstance_id = $data['qinstance_id'];

				if($data['region'] == null){
					$limit = $data['items'];
					self::insertQuiz($user_id, $qinstance_id, $region, $limit);
				}
				$_SESSION['qinstance_id'] = $qinstance_id;
				self::selectNextQuestion($qinstance_id);

			}
			else{
				header('Location: home?status=startQuiz-failed2');
				exit();
			}
		}
		public static function processAnswer(){
			self::setSession();
			if(!isset($_POST['answer'])){
				echo "something wrong";
			}
			else{
				$answer = trim($_POST['answer']);
				$qinstance_id = $_SESSION['qinstance_id'];
				$question_id = $_SESSION['question_id'];
				$user_id = $_SESSION['u_user_id'];
				$answer_row = self::fetch("SELECT answer_correct from questions where question_id = ? ",array( $question_id));
				$weighted_score = ($answer_row['answer_correct'] == $answer)? 1.0 : 0.0 ;
				//get ainstance_id
				$ainstance_id = self::fetch("SELECT * from answer_instance where qinstance_id = ? and question_id = ?",array($qinstance_id, $question_id))['ainstance_id'];
				//get total score
				self::updateScores($weighted_score, $ainstance_id);
				self::selectNextQuestion($qinstance_id);
			}
		}

		//EOF
	}
?>
