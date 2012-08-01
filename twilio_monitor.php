<?php
	// Include the Twilio PHP API
	include "Services/Twilio/Capability.php";

	// Gives us a $accountSid, $authToken and $appSid
	include('twilio_include.inc'); 

	// The client name for incoming connections:
	$clientName = "whitmanmonitor"; 

	$capability = new Services_Twilio_Capability($accountSid, $authToken);
 
	// This allows incoming connections as $clientName: 
	$capability->allowClientIncoming($clientName);
 
	// This allows outgoing connections to $appSid with the "From" 
	// parameter being the value of $clientName 
	$capability->allowClientOutgoing($appSid, array(), $clientName);
 
	// This returns a token to use with Twilio based on 
	// the account and capabilities defined above 
	$token = $capability->generateToken();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Local Report 2012 Phone Monitor</title>
		<script type="text/javascript"
src="//static.twilio.com/libs/twiliojs/1.0/twilio.min.js"></script>
    	<script type="text/javascript"
      src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    	<!-- <link href="http://static0.twilio.com/packages/quickstart/client.css"
      type="text/css" rel="stylesheet" /> -->
	    <script type="text/javascript">
 
			Twilio.Device.setup("<?php echo $token; ?>");
 
			Twilio.Device.ready(function (device) {
				$("#log").text("Ready");
			});
 
			Twilio.Device.error(function (error) {
				$("#log").text("Error: " + error.message);
			});
 
			Twilio.Device.connect(function (conn) {
				$("#log").text("Successfully established call");
			});
 
			Twilio.Device.disconnect(function (conn) {
				$("#log").text("Call ended");
			});
 
		function hangup() {
			Twilio.Device.disconnectAll();
		}
      
		function call() {
			Twilio.Device.connect();
		}
    </script>
	</head>
	<body>
		<button class="call" onclick="call();">Call</button>
	    <button class="hangup" onclick="hangup();">Hangup</button>
	    <div id="log">Loading pigeons...</div>
	</body>
</html>
		