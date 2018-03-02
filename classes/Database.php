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
			if(!$row){
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