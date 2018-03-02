<?php

session_start();

if(isset($_POST['login-submit'])){
	include 'dbh.php';
	
	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	//error handlers
	if(empty($uid) || empty($pwd)){
		header('Location: ../index.php?login=empty');
		exit();
	}
	else{
		$sql = "SELECT * from users where uid = '$uid';";
		$results = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($results);
		if($resultCheck <1){
			// user not found
			header('Location: ../index.php?login=notfound');
			exit();
		}
		else{
			//user might be found, check password
			if($row = mysqli_fetch_assoc($results)){
				//dehash
				$hashed_pwd_checked = password_verify($pwd, $row['pwd']);
				if($hashed_pwd_checked == false){
					//password not matched
					header('Location: ../index.php?login=notmatch');
					exit();
				}
				elseif ($hashed_pwd_checked == true){
					//login
					$_SESSION['u_uid'] = $row['uid'];
					$_SESSION['u_pwd'] = $row['pwd'];
					$_SESSION['u_first'] = $row['user_first'];
					$_SESSION['u_last'] = $row['user_last'];
					$_SESSION['u_type'] = $row['user_type'];
					$_SESSION['score'] = 0;
					header('Location: ../home.php?login=success');
					exit();
				
				}
			}
		}
	}
}
else{
	header('Location: ../index.php?login=error');
	exit();
}