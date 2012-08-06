<?php

//$_REQUEST['RecordingUrl'] should be passed in

file_put_contents("recording_urls.txt",$_REQUEST['RecordingUrl'] . "\n", FILE_APPEND);
?>