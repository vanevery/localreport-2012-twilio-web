<?php
	// Include the Twilio PHP API
	include "Services/Twilio/Capability.php";

	// Gives us a $accountSid, $authToken and $appSid
	include('twilio_include.inc'); 
	 
	// The client name for incoming connections:
	$clientName = "whitmanphones"; 
	
	$capability = new Services_Twilio_Capability($accountSid, $authToken);
	 
	// This allows incoming connections as $clientName: 
	$capability->allowClientIncoming($clientName);
	 
	// This allows outgoing connections to $appSid with the "From" 
	// parameter being the value of $clientName 
	$capability->allowClientOutgoing($appSid, array(), $clientName);
	 
	// This returns a token to use with Twilio based on 
	// the account and capabilities defined above 
	$token = $capability->generateToken();	
	
 	// Echo that for our clients
 	// In this case, the Android App
	echo $token;
?>
