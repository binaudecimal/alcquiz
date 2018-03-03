<?php
	include_once 'header.php';
?>
<section class='main-container'>
			<div class='main-wrapper'>
				<h2>SIGNUP</h2>
				<?php
					if(isset($_GET['status'])){
						switch($_GET['status']){
							case 'signup-success':
								echo "<h2 style='color: #0F0'>Account Successfully created.</h2>
									";break;
						}
					}
				 ?>
				<form class='signup-form' action='signup' method='POST'>
					<input type='text' placeholder='First Name' name='first' required autofocus='auto' autocomplete="off">
					<input type='text' placeholder='Last Name' name='last' required autocomplete="off">
					<input type='text' placeholder='Username' name='uid' required autocomplete="off">
					<input type='password' placeholder='Password' name='pwd' required autocomplete="off">
					<select name='type'>
						<option>ADMIN</option>
						<option>STUDENT</option>
						<option>TEACHER</option>
					</select>
					<button type='submit' name='signup-submit'>Sign up</button>
				</form>
			</div>
		</section>
	</body>
<html>
<?php
	include_once 'footer.php';
?>
