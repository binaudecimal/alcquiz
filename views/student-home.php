<?php
	include_once 'header.php';
	$scores = Controller::selectStudentScores($_SESSION['u_user_id']);
	$status = (isset($_GET['status']))? $_GET['status']: false;
?>
<div class='student-home-wrapper'>
	<div class='student-home-status'>
		<?php
			if($status){
				switch($status){
					case 'quiz-complete':
						echo "<h2 class='status-green'>Quiz completed! Check Scores using Show Scores button.</h2>";
						break;
					case 'quiz-taken':
						echo "<h2 class='status-red'>You have already completed a quiz with that region.</h2>";
						break;
					case 'startQuiz-failed2':
						echo "<h2 class='status-red'>There is no active quiz.</h2>";
						break;
				}
			}
		 ?>
	</div>
	<div class='quiz-button-left'>
		<a href='start-quiz?region=ncr' accesskey='a'>National Capital Region (NCR)</a>
		<a href='start-quiz?region=region1' accesskey='b'>Ilocos Region (Region 1)</a>
		<a href='start-quiz?region=car' accesskey='c'>Cordillera Administrative Region (CAR)</a>
		<a href='start-quiz?region=region2' accesskey='d'>Cagayan Valley (Region 2)</a>
		<a href='start-quiz?region=region3' accesskey='e'>Central Luzon (Region 3)</a>
		<a href='start-quiz?region=region4a' accesskey='f'>CALABARZOB (Region 4A)</a>
		<a href='start-quiz?region=mimaropa' accesskey='g'>Southwestern Tagalog Region (MIMAROPA)</a>
		<a href='start-quiz?region=region5' accesskey='h'>Bicol Region (Region 5)</a>
		<a href='start-quiz?region=region6' accesskey='i'>Western Visayas (Region 6)</a>
	</div>
	<div class='philippine-map'>
		<img src="includes/PhilippinesStatesMap.png">
	</div>
	<div class='quiz-button-right'>
		<a href='start-quiz?region=region7' accesskey='j'>Central Visayas (Region 7)</a>
		<a href='start-quiz?region=region8' accesskey='k'>Eastern Visayas (Region 8)</a>
		<a href='start-quiz?region=region9' accesskey='l'>Zamboanga Peninsula (Region 9)</a>
		<a href='start-quiz?region=region10' accesskey='m'>Northern Mindanao (Region 10)</a>
		<a href='start-quiz?region=region11' accesskey='n'>Davao Region (Region 11)</a>
		<a href='start-quiz?region=region12' accesskey='o'>SOCCSLSARGEN (Region 12)</a>
		<a href='start-quiz?region=region13' accesskey='p'>Caraga Region (Region 13)</a>
		<a href='start-quiz?region=armm' accesskey='q'>Autonomous Region in Muslim Mindanao (ARMM)</a>
		<a href='#student-score-popup'>Show Scores</a>
	</div>
</div>
<!-- scores popup-->
<div id="student-score-popup" class="overlay">
	<div class="popup">
		<h2>Quiz Scores</h2>
		<a class="close" href="#">&times;</a>
		<div class="content">
			<!-- content here-->
			<table>
				<tr>
					<td>Region</td>
					<td>Score</td>
				</tr>
				<?php
				if($scores){
					foreach($scores as $item) {
						echo "
						<tr>
							<td>".$item['region']."</td>
							<td>".$item['total_score']."</td>
						</tr>
						";
					}
				}
				else{
					echo "
					<tr>
						<td>N/A</td>
						<td>N/A</td>
					</tr>
					";
				}
				?>
			</table>
		</div>
	</div>
</div>
