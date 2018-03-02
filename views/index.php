<h1>Hello there!</h1>
<?php
	
	if(!empty($_GET['status'])){
		echo "<p class='status'>" .$_GET['status']."</p><br>";
	}
	else{
		echo "Nothing to report";
	}
?>