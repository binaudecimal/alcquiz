<?php
	include_once '../header.php';
if(isset($_SESSION['u_uid'])){
	
	if($_SESSION['u_type'] == 'ADMIN'){
		header('Location: ../index.php');
		exit();
	}
	elseif($_SESSION['u_type'] == 'TEACHER'){
		header('Location: ../dashboard.php');
		exit();
	}
	else{
		header('Location: ../studentHome.php');
		exit();
	}
}
else{
	header('Location: ../index.php');
	exit();
}