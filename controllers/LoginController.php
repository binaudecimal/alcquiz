<?php
	class LoginController extends Controller{
		public static function login(){
			self::setSession();
			if(isset($_POST['login-submit'])){

				$uid = $_POST['uid'];
				$pwd = $_POST['pwd'];
				//error handlers
				if(empty($uid) || empty($pwd)){
					header('Location: home?status=empty');
					exit();
				}
				else{
					$sql = "SELECT * from users where username = ? Limit 1;";
					$results = self::query($sql, array($uid));
					if(!self::isExist($sql, array($uid))){
						// user not found
						header('Location: home?status=loginfail');
						exit();
					}
					else{
						//user might be found, check password

						if(!empty($results[0])){
							//dehash
							$row = $results[0];
							$hashed_pwd_checked = password_verify($pwd, $row['password']);
							if($hashed_pwd_checked == false){
								//password not matched
								header('Location: home?status=failedpw');
								exit();
							}
							elseif ($hashed_pwd_checked == true){
								//login
								$_SESSION['u_user_id'] = $row['user_id'];
								$_SESSION['u_username'] = $row['username'];
								$_SESSION['u_first'] = $row['first'];
								$_SESSION['u_last'] = $row['last'];
								$_SESSION['u_type'] = $row['type'];
								header('Location: home?status=loginsuccess');
								exit();
							}
						}
					}
				}
			}
			else{
				header('Location: home?status=failed');
				exit();
			}
		}
		public static function signup(){
			self::setSession();
			if(isset($_POST["signup-submit"])){
				$first = $_POST['first'];
				$last = $_POST['last'];
				$uid = $_POST['uid'];
				$pwd =$_POST['pwd'];
				$type = $_POST['type'];

				//error handling
				if(empty($first) || empty($last) || empty($uid) || empty($pwd)){
					header("Location: signup?status=empty");
					exit();
				}
				else{
					//no error here

					//all stuff are valid
					$sql = "Select * from users where username = ?";
					$resultChecked = self::isExist($sql, array($uid));

					if($resultChecked ==true){
						header('Location: signup-form?status=username-existing');
						exit();
					}
					else{
						//user not used
						$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
						if(self::insertSignup($first, $last, $uid, $hashed_pwd, $type)){
								header('Location: signup-form?status=signup-success');
								exit();
						}
						else{
								header('Location: signup-form?status=signup-failed');
								exit();
						}
					}

				}
			}
			else{
				header("Location: home");
				exit();
			}
		}
		public static function logout(){
			if(isset($_POST['logout'])){
				session_start();
				session_unset();
				session_destroy();
				header('Location: home?status=logout');
				exit();
			}
		}
	}
?>
