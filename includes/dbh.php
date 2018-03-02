<?php
class Database{

	$dbServerName = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "application";

	$handler;
	public static function connect(){
		this->$handler = new PDO('mysqli:host='.$dbServerName.';dbname='.$dbname, $dbUsername, $dbPassword);
		return this->$handler;
	}

	public static function getConnection(){
		return this->$handler;
	}
}