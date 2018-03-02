<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>

<!DOCTYPE html>	
	<head>
		<link rel='stylesheet' type='text/css' href='style.css'>
		<script src='js/jquery-3.3.1.min.js'></script>
	</head>
	
	<body>
		<header>
			<nav>
				<div class='main-wrapper'>
					<ul>
						<li><a href='index'>HOME </a> </li>
					</ul>
					<div class='nav-login'>
						<?php
							if(isset($_SESSION['u_username'])){
								echo "<span>Hello! ". $_SESSION['u_first'] . ", you are a ". $_SESSION['u_type'] ."</span><form action='logout' method='POST'>
								<button type='submit' name='logout' accesskey='1'>LOGOUT</button>
								</form>";
							}
							else{
								echo "<form action='login' method='POST'>
								<input type='text' name='uid' placeholder='Username' autofocus='auto'>
								<input type='password' name='pwd' placeholder='Password'>
								<button type='submit' name='login-submit'>LOGIN</button>
								</form>
								<a href='signup-form'>SIGNUP </a>";
							}
						?>
						
					</div>
				</div>
			</nav>
		</header>
