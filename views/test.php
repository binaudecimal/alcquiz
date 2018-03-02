<script>
	$(document).ready(function(){
		var x = 10;
		$('.timer').html(x);
		setInterval(function(){
			x= x-1;
			if(x<0){
				alert("Time is up!");
			
			};
			$('.timer').html(x);
		}, 1000);
	});
</script>

<div class='timer'>

</div>
<p>
	I am test
	</p>
