<?php
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';

//$_REQUEST['From']
?>
<Response>
	<Say>Welcome to Twilio Client!</Say>
	<Play loop="100">http://demo.twilio.com/hellomonkey/monkey.mp3</Play>
</Response>

