<?php
	class LoginController extends Controller{
		public static function login(){
			session_start();
			if(isset($_POST['login-submit'])){
				
				$uid = self::quote($_POST['uid']);
				$pwd = self::quote($_POST['pwd']);
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
								header('Location: ../home?status=failed');
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

			if(isset($_POST["signup-submit"])){
				$first = self::quote($_POST['first']);
				$last = self::quote($_POST['last']);
				$uid = self::quote($_POST['uid']);
				$pwd =self::quote($_POST['pwd']);
				
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
						echo "exists";
						//header('Location: signup?status=error');
						//exit();
					}
					else{
						//user not used
						$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
						$sql = "Insert into users (first, last, username, password, type) values (?, ?, ?, ?, 'STUDENT');";
						self::query($sql, array($first, $last, $uid, $hashed_pwd));
						header('Location home?status=signupsuccess');
						exit();
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