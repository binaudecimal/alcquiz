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
			$data = self::fetch("SELECT * from quiz_instance where user_id = ? and date_finished is NULL", array($user_id));

			if($data != false){
				//quiz active check for region
				$qinstance_id = $data['qinstance_id'];
				if($data['region'] == null){
					$limit = $data['items'];
					self::insertQuiz($user_id, $qinstance_id, $region, $limit);
				}
				if(self::selectNextQuestion($qinstance_id)){
					header('Location: quiz-take');
					exit();
				}
				else{
					header('Location: home?status=quizTake=complete');
					exit();
				}
			}
			else{
				header('Location: home?status=startQuiz-failed2');
				exit();
			}
		}
		public static function processAnswer(){
			self::setSession();
			if(!isset($_GET['answer'])){
				echo "something wrong";
			}
			else{
				$answer = $_GET['answer'];
				$qinstance_id = $_SESSION['qinstance_id'];
				$question_id = $_SESSION['question_id'];
				$user_id = $_SESSION['u_user_id'];

				$ainstance_row = self::fetch("SELECT * from answer_instance where user_id = ? and qinstance_id = ? and question_id = ? and weighted_score is NULL", array($user_id, $qinstance_id, $question_id));
				$quiz_row = self::fetch("SELECT * from questions where question_id = ?",array($question_id));
				$weighted_score = ($answer == $quiz_row['answer_correct']) ? 1.0 : 0.0;
				self::query("UPDATE answer_instance set weighted_score = ? where ainstance_id = ?",array($weighted_score, $ainstance_row['ainstance_id']));
				$qinstance_row = self::fetch('SELECT * from quiz_instance where qinstance_id = ?', array($qinstance_id));
				$qinstance_score = ($qinstance_row['total_score'] == null)? 0 : 1;
				$qinstance_score += $weighted_score;
				self::query("UPDATE quiz_instance set total_score = ? where qinstance_id = ?",array($qinstance_score,$qinstance_id));
				header('Location: start-quiz');
				exit();
			}
		}

		//EOF
	}
?>
