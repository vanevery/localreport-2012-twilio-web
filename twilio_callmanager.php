<?PHP
include "Services/Twilio.php";

// Gives us a $accountSid, $authToken and $appSid
include('twilio_include.inc'); 

if (isset($_REQUEST['send'])) {

	$sclient = new Services_Twilio($accountSid, $authToken);
	$sid = $_REQUEST['send'];
	$scall = $sclient->account->calls->get($sid);
	$scall->update(array('Url' => 'http://live.whitmanlocalreport.net:8080/twilio/twilio_conference.php', 'Method' => 'POST'));

} else if (isset($_REQUEST['hangup'])) {

	$hclient = new Services_Twilio($accountSid, $authToken);
	$sid = $_REQUEST['hangup'];
	$hcall = $hclient->account->calls->get($sid);
	$hcall->hangup();
}

$client = new Services_Twilio($accountSid, $authToken);
$filteredCalls = $client->account->calls->getIterator(0, 100, array("Status" => "in-progress"));

?>
<html>
	<head>
		<title>Local Report Call Manager</title>
	</head>
	<body>

<?PHP
foreach($filteredCalls as $call) {

    //print_r($call);
/*
    [sid] => CA4cbb3fc657fd2b48497b15bc4f09e79e
    [date_created] => Tue, 17 Jul 2012 15:19:27 +0000
    [date_updated] => Tue, 17 Jul 2012 15:19:35 +0000
    [parent_call_sid] => 
    [account_sid] => AC91650cb6478772fb52fef4a6d96ed5dc
    [to] => 
    [to_formatted] => 
    [from] => client:sandbox
    [from_formatted] => sandbox
    [phone_number_sid] => 
    [status] => completed
    [start_time] => Tue, 17 Jul 2012 15:19:27 +0000
    [end_time] => Tue, 17 Jul 2012 15:19:35 +0000
    [duration] => 8
    [price] => -0.00250
    [direction] => inbound
    [answered_by] => 
    [annotation] => 
    [api_version] => 2010-04-01
    [forwarded_from] => 
    [group_sid] => 
    [caller_name] => 
    [uri] => /2010-04-01/Accounts/AC91650cb6478772fb52fef4a6d96ed5dc/Calls/CA4cbb3fc657fd2b48497b15bc4f09e79e
*/

    print($call->start_time . " <a href=\"twilio_callmanager.php?send=" . $call->sid . "\">Conference</a> <a href=\"twilio_callmanager.php?hangup=" . $call->sid . "\">Hangup</a>");

    print("<br /><br />");
}
?>
	</body>
</html>

