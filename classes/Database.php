<?php
	class Database{

		public static $host = 'localhost';
		public static $dbname = 'quiz_game';
		public static $username ='root';
		public static $password = '';

		private static function connect(){
			$pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$dbname, self::$username, self::$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}

		public static function insertSignup($username, $password, $first, $last, $type){ //return true if success, fail if not
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			  $pdo->beginTransaction();
			  $statement = $pdo->prepare("INSERT into users (first, last, username, password, type) values (?,?,?,?,?)");
				$statement->execute(array($first, $last, $username, $password, $type));
			  $pdo->commit();
				return true;
			} catch (Exception $e) {
			  $pdo->rollBack();
				return false;
			}
		}

		public static function insertAddQuestion($question, $region, $answer_correct, $answer_wrong1, $answer_wrong2, $answer_wrong3){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $pdo->beginTransaction();
			  $statement = $pdo->prepare("INSERT into questions (question, region, answer_correct, answer_wrong1,answer_wrong2,answer_wrong3, active_status) values (?,?,?,?,?,?,?)");
				$statement->execute(array($question, $region, $answer_correct, $answer_wrong1, $answer_wrong2, $answer_wrong3, true));
			  $pdo->commit();
				return true;
			} catch (Exception $e) {
			  $pdo->rollBack();
				return false;
			}
		}
		public static function insertActivateQuiz($items, $duration){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if(($students = self::selectStudents())!=null){
					$pdo->beginTransaction();
					//deactivate all quizzes
					$statement = $pdo->prepare("UPDATE quiz_instance set date_finished = NOW() where date_finished IS NULL");
					$statement->execute();

					foreach($students as $row){
						$user_id = $row['user_id'];
						$statement = $pdo->prepare("INSERT into quiz_instance (user_id, items, duration) values (?,?,?)");
						$statement->execute(array($user_id, $items, $duration));
					}
					$pdo->commit();
					return true;
				}
				else return false;
			} catch (Exception $e) {
			  	$pdo->rollBack();
					return false;
			}
		}

		public static function insertQuiz($user_id, $qinstance_id, $region, $limit){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $pdo->beginTransaction();
				//setting region
			  $statement = $pdo->prepare("UPDATE quiz_instance set region = ? where qinstance_id = ?");
				$result = $statement->execute(array($region, $qinstance_id));
				//generate the quiz itself
				$sql = "SELECT * from questions where region = ? order by RAND() limit " . $limit;
				$statement = $pdo->prepare("SELECT * from questions where region = ? order by RAND() limit " . $limit);
				$statement->execute(array($region));
				$question_set = $statement->fetchAll();
				foreach($question_set as $row){
					//insert into ainstance for each questions
					$statement = $pdo->prepare("INSERT into answer_instance (user_id, question_id, qinstance_id) values (?,?,?)");
					$statement->execute(array($user_id, $row['question_id'], $qinstance_id));
				}
			  $pdo->commit();
				return true;
			} catch (Exception $e) {
			  $pdo->rollBack();
				return false;
			}
		}



		public static function selectStudents(){
			$pdo = self::connect();
			try {
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  $statement = $pdo->prepare("SELECT * from users where type='STUDENT'");
				$statement->execute();
				return $statement->fetchAll();
			} catch (Exception $e) {
			  	$pdo->rollBack();
					return false;
			}
		}

		public static function selectNextQuestion($qinstance_id){
			$pdo = self::connect();
			$question_row = self::fetch("SELECT question_id from answer_instance where qinstance_id = ? and weighted_score is NULL order by RAND() limit 1",array($qinstance_id));
			if($question_row!= false){
				Controller::setSession();
				$_SESSION['question_id'] = $question_row['question_id'];
				$_SESSION['qinstance_id'] = $qinstance_id;
				return true;
			}
			else{
				//must be done, set quiz to date_finished
				return false;
			}
		}
		public static function query($query, $params = array()){
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			if(explode(' ', $query)[0] == 'SELECT'){
				$data = $statement->fetchAll();
				//print_r($data);
				return $data;
			}
			elseif(explode(' ', $query)[0] == 'INSERT'){

				//do something for insert
				return true;
			}
		}

		public static function quote($string){
			return self::connect()->quote($string);
		}

		public static function isExist($query, $params = array()){
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			$row = $statement->fetch(PDO::FETCH_ASSOC);
			if($row==null){
				return false;

			}
			else {

				return true;
			}
		}

		public static function fetch($query, $params = array()){
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			$data = $statement->fetch(PDO::FETCH_ASSOC);
			return $data;
		}


	}
?>
