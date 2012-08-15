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
		<title>Local Report 2012 Call Manager</title>
		<script type="text/javascript"
src="//static.twilio.com/libs/twiliojs/1.0/twilio.min.js"></script>
    	<script type="text/javascript"
      src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	    <script type="text/javascript">
 			// Twilio Web Client Portion
 
			Twilio.Device.setup("<?php echo $token; ?>");
 
			Twilio.Device.ready(function (device) {
				$("#monitorlog").text("Ready");
			});
 
			Twilio.Device.error(function (error) {
				$("#monitorlog").text("Error: " + error.message);
			});
 
			Twilio.Device.connect(function (conn) {
				$("#monitorlog").text("Successfully established call");
				callInProgress = true;
			});
 
			Twilio.Device.disconnect(function (conn) {
				$("#monitorlog").text("Call ended");
				callInProgress = false;
			});
 
			function hangup() {
				Twilio.Device.disconnectAll();
				$("#callbutton").text("Call");
			}
		  
			function call() {
				Twilio.Device.connect();
				$("#callbutton").text("Hangup");			
			}
			
			var callInProgress = false;
			function callButtonClicked() {
				if (callInProgress) {
					hangup();
				} else {
					call();
				}
			}
			
			// Call Manager Portion
			var currentLiveSID = null;
			
			var callDataRequestTimer = null;
			callDataRequestTimer = setTimeout(function() {getCallData()}, 1000);
	
			var callDataRequest = null;
			
			function getCallData() {
				
				callDataRequest = $.ajax({
					url: 'twilio_callmanager_ajax.php'
				});
				
				callDataRequest.done(function(callDataJSON) {
					gotCallData(callDataJSON);
					callDataRequestTimer = setTimeout(function() {getCallData()}, 1000);
				});
				
				callDataRequest.fail(function(jqXHR, textStatus) {
					$("#datalog").html("Request failed: " + textStatus);
				});
			}
			
			function gotCallData(callDataJSON) {
				$("#datalog").html(callDataJSON);	
				var callDataArray = JSON.parse(callDataJSON);
				//alert(callDataArray.length);
				if (callDataArray.length > 0)
				{
					$("#calls").html("");
					for (var i = 0; i < callDataArray.length; i++) {
						var call = callDataArray[i];
						if (call.from != "client:whitmanmonitor") {
							if (call.sid == currentLiveSID) {
								$("#calls").append("<p class=\"live\">" + call.start_time + ": " + '<a href="#" onclick="hangupCall(\'' + call.sid + '\')">Hangup</a></p>');
							}
							else
							{
								$("#calls").append("<p class=\"notlive\">" + call.start_time + ": " + '<a href="#" onclick="conferenceCall(\'' + call.sid + '\')">Conference</a></p>');
							}
					
						}
						else {
							//alert("Monitor Here");
						}
					}
				}
			}
			
			function conferenceCall(sid) {
				if (currentLiveSID != null) {
					hangupCall(currentLiveSID);
				}
				currentLiveSID = sid;
				callDataRequest = $.ajax({
					url: 'twilio_callmanager_ajax.php',
					data: {send: sid}
				});
				
				callDataRequest.done(function(callDataJSON) {
					gotCallData(callDataJSON);
				});
			}
			
			function hangupCall(sid) {
				if (currentLiveSID == sid) {
					currentLiveSID = null;
				}	
				callDataRequest = $.ajax({
					url: 'twilio_callmanager_ajax.php',
					data: {hangup: sid}
				});
				
				callDataRequest.done(function(callDataJSON) {
					gotCallData(callDataJSON);
				});
			}

			function hangupConference() {
				currentLiveSID = null;
				callDataRequest = $.ajax({
					url: 'twilio_callmanager_ajax.php',
					data: {conference_hangup: "yes"}
				});
				
				callDataRequest.done(function(callDataJSON) {
					gotCallData(callDataJSON);
				});
			}

    </script>
    <style>
		p.live{color:red;}
		p.notlive{color:green;}
	</style>
    
	</head>
	<body>
		<button id="callbutton" onclick="callButtonClicked();">Call</button>
		<!--<button class="call" onclick="call();">Call</button>
	    <button class="hangup" onclick="hangup();">Hangup</button>-->
	    <div id="monitorlog">Loading Local Report...</div>
	    
	    <div id="calls">No Call Data Yet</div>

		<button id="requestconferencehangup" onclick="hangupConference();">Hangup Conference</button>		
		<button id="requestcalldatabutton" onclick="getCallData();">Request Call Data</button>
		<div id="datalog"></div>

	</body>
</html>


