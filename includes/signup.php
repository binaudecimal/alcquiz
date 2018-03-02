<?php

if(isset($_POST["signup-submit"])){
	include_once "dbh.php";
	
	$first = mysqli_real_escape_string($conn, $_POST["first"]);
	$last = mysqli_real_escape_string($conn, $_POST["last"]);
	$uid = mysqli_real_escape_string($conn, $_POST["uid"]);
	$pwd = mysqli_real_escape_string($conn, $_POST["pwd"]);
	
	//error handling
	if(empty($first) || empty($last) || empty($uid) || empty($pwd)){			
		header("Location: ../signup.php?signup=empty");
		exit();
	}
	else{
		//no error here
		if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last) || !preg_match("/^[a-zA-Z]*$/", $uid)){
			header("Location: ../signup.php?signup=invalid");
			exit();
		}
		else{
			//all stuff are valid
			$sql = "Select * from users where uid = '$uid';";
			$result = mysqli_query($conn, $sql);
			$resultChecked = mysqli_num_rows($result);
			if($resultChecked >0){
				header('Location: ../signup.php?signup=usertaken');
				exit();
			}
			else{
				//user not used
				$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
				$sql = "Insert into users (user_first, user_last, uid, pwd, user_type) values ('$first', '$last', '$uid', '$hashed_pwd', 'STUDENT');";
				mysqli_query($conn, $sql);
				header('Location: ../signup.php?signup=success');
				exit();
			}
		}
	}
}
else{
	header("Location: ../signup.php");
	exit();
}