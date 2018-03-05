<?php
	$status = (isset($_GET['status']))? $_GET['status']: false;
?>

<div class='add-question-form-wrapper'>
	<div class='add-question-form-status'>
		<?php
			if($status){
				switch($status){
					case 'questionAdd-success':
						echo "<h2 class='status-green'>Question added successfully.</h2>";
						break;
					case 'empty':
						echo "<h2 class='status-red'>There are required fields that are empty.</h2>";
						break;

				}
			}
		 ?>
	</div>
	<div class='add-question-form'>
		<h2>Add Question</h2>
			<form action='add-question' method='POST'>
			<select name='region'>
				<option value='ncr'>National Capital Region (NCR)</option>
				<option value='region1'>Ilocos Region (Region 1)</option>
				<option value='car'>Cordillera Administrative Region (CAR)</option>
				<option value='region2'>Cagayan Valley (Region 2)</option>
				<option value='region3'>Central Luzon (Region 3)</option>
				<option value='region4a'>CALABARZOB (Region 4A)</option>
				<option value='mimaropa'>Southwestern Tagalog Region (MIMAROPA)</option>
				<option value='region5'>Bicol Region (Region 5)</option>
				<option value='region6'>Western Visayas (Region 6)</option>
				<option value='region7'>Central Visayas (Region 7)</option>
				<option value='region8'>Eastern Visayas (Region 8)</option>
				<option value='region9'>Zamboanga Peninsula (Region 9)</option>
				<option value='region10'>Northern Mindanao (Region 10)</option>
				<option value='region11'>Davao Region (Region 11)</option>
				<option value='region12'>SOCCSLSARGEN (Region 12)</option>
				<option value='region13'>Caraga Region (Region 13)</option>
				<option value='armm'>Autonomous Region in Muslim Mindanao (ARMM)</option>
			</select>
			<input type='text' name='question' placeholder='Question' autofocus="auto" required>
			<input type='text' name='answer_correct' placeholder='Correct Answer'required>
			<input type='text' name='answer_wrong1' placeholder='Wrong Answer'required>
			<input type='text' name='answer_wrong2' placeholder='Wrong Answer'required>
			<input type='text' name='answer_wrong3' placeholder='Wrong Answer'required>
			<button type='submit'>SUBMIT</button>
		</form>
	</div>
</div>
