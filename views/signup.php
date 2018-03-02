<?php
	include_once 'header.php';
?>
<section class='main-container'>
			<div class='main-wrapper'>
				<h2>SIGNUP</h2>
				<form class='signup-form' action='signup' method='POST'>
					<input type='text' placeholder='First Name' name='first'>
					<input type='text' placeholder='Last Name' name='last'>
					<input type='text' placeholder='Username' name='uid'>
					<input type='password' placeholder='Password' name='pwd'>
					<button type='submit' name='signup-submit'>Sign up</button>
				</form>
			</div>
		</section>
	</body>
<html>
<?php
	include_once 'footer.php';
?>