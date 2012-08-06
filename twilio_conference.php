<?php
    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<Response>
	<Say>You are now live, deliver your report</Say>
	<Dial action="http://live.whitmanlocalreport.net:8080/twilio/twilio_conference_entered.php" record="true">
		<Conference waitUrl="http://live.whitmanlocalreport.net:8080/twilio/in_c.mp3" beep="true">liveconference</Conference>
	</Dial>
</Response>
