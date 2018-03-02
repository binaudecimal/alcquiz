<?php
if(isset($_POST['add-question-submit'])){
	include_once "dbh.php";
	
	$question = mysqli_real_escape_string($conn, $_POST["question"]);
	$region = mysqli_real_escape_string($conn, $_POST["region"]);
	$answer1 = mysqli_real_escape_string($conn, $_POST["answer-1"]);
	$answer2 = mysqli_real_escape_string($conn, $_POST["answer-2"]);
	$answer3 = mysqli_real_escape_string($conn, $_POST["answer-3"]);
	$answer4 = mysqli_real_escape_string($conn, $_POST["answer-4"]);
	
	//error handling
	if(empty($question) || empty($answer1) || empty($answer2)|| empty($answer3)|| empty($answer4)){			
		header("Location: ../addQuestion.php?add=empty");
		exit();
	}
	else{
	
		
		$sql = "Insert into questions (question, region, answer1, answer2, answer3,answer4) values ('$question', '$region', '$answer1', '$answer2', '$answer3', '$answer4');";
		mysqli_query($conn, $sql);
		header('Location: ../addQuestion.php?add=success');
		exit();

	}
}
else{
	header('Location: ../home.php');
	exit();
}