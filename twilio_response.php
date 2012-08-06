<?php
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';

if ($_REQUEST['From'] == "client:whitmanmonitor") {
?>
	<Response>
		<Say>Welcome to Local Report Call Monitor</Say>
		<Dial>
			<Conference muted="true" beep="true" waitUrl="">liveconference</Conference>
		</Dial>
	</Response>
<?php
}
else
{
?>
	<Response>
		<Say>Welcome to Local Report 2012</Say>
		<Say>Please enjoy the music while you wait to be connect to the performance</Say>
		<Play>http://live.whitmanlocalreport.net:8080/twilio/in_c.mp3</Play>
	</Response>
<?php
}
?>
