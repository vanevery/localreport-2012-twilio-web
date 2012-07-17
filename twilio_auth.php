<?php
include "Services/Twilio/Capability.php";
 
// AccountSid and AuthToken can be found in your account dashboard
$accountSid = "xxxx"; 
$authToken = "xxxx"; 
 
// The app outgoing connections will use:
$appSid = "xxxx"; 
 
// The client name for incoming connections:
$clientName = "monkey"; 
 
$capability = new Services_Twilio_Capability($accountSid, $authToken);
 
// This allows incoming connections as $clientName: 
$capability->allowClientIncoming($clientName);
 
// This allows outgoing connections to $appSid with the "From" 
// parameter being the value of $clientName 
$capability->allowClientOutgoing($appSid, array(), $clientName);
 
// This returns a token to use with Twilio based on 
// the account and capabilities defined above 
$token = $capability->generateToken();
 
echo $token;
?>
