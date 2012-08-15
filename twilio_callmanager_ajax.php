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

} else if (isset($_REQUEST['conference_hangup'])) {

	// This isn't working, not getting the active conferences

	$cclient = new Services_Twilio($accountSid, $authToken);
	$conferences = $cclient->account->conferences->getIterator(0, 100, array('Status' => 'in-progress'));
	
	foreach ($conferences as $conf) {
	
		print $conf->sid;
		
		$conference = $client->account->conferences->get($conf->sid);
		$page = $conference->participants->getPage(0, 50);
		$participants = $page->participants;
		foreach ($participants as $p) {
			$chcall = $hclient->account->calls->get($p->call_sid);
			print_r($chcall);
			if ($chcall->from != "client:whitmanmonitor") {
				$chcall->hangup();
			}
		}
	}
}

$client = new Services_Twilio($accountSid, $authToken);
$filteredCalls = $client->account->calls->getIterator(0, 100, array("Status" => "in-progress"));

$myFilteredCalls = array();
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

	$currentIndex = sizeof($myFilteredCalls);
	
	$myFilteredCalls[$currentIndex]['sid'] = $call->sid;
	$myFilteredCalls[$currentIndex]['date_created'] = $call->date_created;
	$myFilteredCalls[$currentIndex]['date_updated'] = $call->date_updated;
	$myFilteredCalls[$currentIndex]['parent_call_sid'] = $call->parent_call_sid;
	$myFilteredCalls[$currentIndex]['to'] = $call->to;
	$myFilteredCalls[$currentIndex]['to_formatted'] = $call->to_formatted;
	$myFilteredCalls[$currentIndex]['from'] = $call->from;
	$myFilteredCalls[$currentIndex]['from_formatted'] = $call->from_formatted;
	$myFilteredCalls[$currentIndex]['phone_number_sid'] = $call->phone_number_sid;
	$myFilteredCalls[$currentIndex]['status'] = $call->status;
	$myFilteredCalls[$currentIndex]['start_time'] = $call->start_time;
	$myFilteredCalls[$currentIndex]['parent_call_sid'] = $call->parent_call_sid;
	$myFilteredCalls[$currentIndex]['end_time'] = $call->end_time;
	$myFilteredCalls[$currentIndex]['duration'] = $call->duration;
	$myFilteredCalls[$currentIndex]['price'] = $call->price;
	$myFilteredCalls[$currentIndex]['direction'] = $call->direction;
	$myFilteredCalls[$currentIndex]['answered_by'] = $call->answered_by;
	$myFilteredCalls[$currentIndex]['annotation'] = $call->annotation;
	$myFilteredCalls[$currentIndex]['api_version'] = $call->api_version;
	$myFilteredCalls[$currentIndex]['forwarded_from'] = $call->forwarded_from;
	$myFilteredCalls[$currentIndex]['group_sid'] = $call->group_sid;
	$myFilteredCalls[$currentIndex]['caller_name'] = $call->caller_name;
	$myFilteredCalls[$currentIndex]['uri'] = $call->uri;
}
$filteredCallsJSON = json_encode($myFilteredCalls);
echo($filteredCallsJSON);
?>
