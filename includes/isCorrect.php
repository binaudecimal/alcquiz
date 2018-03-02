<?php
	include 'dbh.php';
	include_once '../header.php';
	$s_qid = mysqli_real_escape_string($conn, $_GET['qid']);
	$s_answer = mysqli_real_escape_string($conn, $_GET['answer']);
	$query = "SELECT * from questions where qid = '$s_qid';";
	$result = mysqli_query($conn, $query);
	$result_check = mysqli_num_rows($result);
	$row = mysqli_fetch_assoc($result);
	if($result_check <= 0){
		header('Location: home.php?result=error');
		exit();
	}
	else{//theres result
		$quizlist = $_SESSION['quizlist'];
		$item = array_pop($quizlist);
		$_SESSION['item'] = $item;
		$_SESSION['quizlist'] = $quizlist;
		
		if($s_answer != $row['answer1']){ //wrong answer
			header('Location: ../displayquiz.php?result=next');
			exit();
		}
		else{//Correct answer
			$_SESSION['score']+= 1;
			if(is_null($item)){//list done
				
				echo "
					<h1> Quiz Completed! </h1>
					<a href='home.php'>BACK HOME </a>
				";
				exit();
			}
			else{//has more
								
				header('Location: ../displayquiz.php?result=next');
				exit();
			
			}
			
			
		
		}
		
		
	}