<?php
$session = mt_rand(1,999);
$message = $_GET['message'];
$type = $_GET['type'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
</head>
<body>
	<div id="wrapper">
		<div id="chat_output"></div>
		<script type="text/javascript">
		jQuery(function($){
			// Websocket
			var websocket_server = new WebSocket("ws://localhost:8080/");
			websocket_server.onopen = function(e) {
        var chat_msg = '<?php echo $message; ?>';
        websocket_server.send(
          JSON.stringify({
            'type':'<?php echo $type; ?>',
            'user_id':<?php echo $session; ?>,
            'chat_msg':chat_msg
          })
        );
			};
			websocket_server.onerror = function(e) {
				// Errorhandling
			}
			websocket_server.onmessage = function(e)
			{
				var json = JSON.parse(e.data);
				switch(json.type) {
					case 'chat':
						$('#chat_output').append(json.msg);
						break;
          case 'logs':
  					$('#logs').append(json.msg);
  					console.log($("#logs"));
  					break;
				}
			}
			// Events
      //
		});
		</script>
	</div>
</body>
</html>
