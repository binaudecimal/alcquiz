<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>

<!DOCTYPE html>
	<head>
        <link rel='stylesheet' type='text/css' href='bootstrap.min.css'>
		<script type="text/javascript" src='js/jquery.min.js'></script>
        <script type="text/javascript" src='js/popper.min.js'> </script>
        <script type="text/javascript" src='js/bootstrap.min.js'></script>
		<script type="text/javascript" src='js/chart.min.js'></script>
	</head>

	<body>
		<header>
				<div class='container-fluid'>
                    <nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
					 <a class="navbar-brand" href="home">Home</a>
                        
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <?php
							if(isset($_SESSION['u_username'])){
								echo "<form action='logout' method='POST'>
                                <li class='nav-item'>
								    <button type='submit' name='logout' accesskey='2' class='btn btn-light'>LOGOUT</button>
                                </li>
								</form>";
							}
                            else{
								echo "<form action='login' method='POST' class='form-horizontal>
                                <div class='container-fluid ml-auto'>
                                    <div class='row'>
                                        <li class='nav-item'>
                                            <input type='text' name='uid' placeholder='Username' autofocus='auto' class='form-control ml-auto'>
                                        </li>
                                        <li class='nav-item'>
                                            <input type='password' name='pwd' placeholder='Password' class='form-control ml-auto'>
                                        </li>
                                        <button type='submit' name='login-submit' class='btn btn-light ml-1'>LOGIN</button>
                                        </form>
                                        <li class='nav-item'>
                                            <a href='signup-form' class='btn btn-light ml-1 mr-1' role='button'>SIGNUP </a>
                                        </li>
                                    </div>
                                </div>
                                    ";
                                
							}
						  ?>
                            
                        </ul>
                    </div>
			     </nav>
            </div>
		</header>
