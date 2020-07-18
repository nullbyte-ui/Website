<?php

set_time_limit(0);
function downloadfile()
{
	$options = array(
	  CURLOPT_TIMEOUT =>  5,
	  CURLOPT_URL     => "https://api.mcsrvstat.us/2/play.totalfreedom.me",
	  CURLOPT_RETURNTRANSFER => true 
	);

	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	curl_close($ch);

	if ($result)
	{
		$fp = fopen("ping.json", "w");
		fwrite($fp, $result);
		fclose($fp);
	}
}

function timeAgo($timestamp) {

  $now = new DateTime("now");
  $seconds = $now->getTimestamp() - $timestamp;

  $interval = floor($seconds / 31536000);
  
  #echo ($interval);

  if ($interval > 1) {
    return $interval." years";
  }
  else if ($interval == 1) {
    return ($interval." year");
  }
  $interval = floor($seconds / 2592000);
  if ($interval > 1) {
    return $interval." months";
  }
  else if ($interval == 1) {
    return ($interval." month");
  }
  $interval = floor($seconds / 86400);
  if ($interval > 1) {
    return $interval." days";
  }
  else if ($interval == 1) {
    return ($interval." day");
  }
  $interval = floor($seconds / 3600);
  if ($interval > 1) {
    return $interval." hours";
  }
  else if ($interval == 1) {
    return ($interval." hour");
  }
  $interval = floor($seconds / 60);
  if ($interval > 1) {
    return ($interval." minutes");
  }
  else if ($interval == 1) {
    return ($interval." minute");
  }
  if ($seconds == 1) {
    return ($seconds." second");
  }
  else
  {
    return floor($seconds)." seconds";
  }
}

$rawtime = filemtime("ping.json");

$filetime = date("F d Y H:i:s.", $rawtime);
$nfiletime = new DateTime($filetime);
$now = date("m/d/Y H:i:s");
$fnow = new DateTime($now); 

$difference = date_diff($fnow, $nfiletime);


$diff_format = $difference->format('%h:%i:%s');

$minutes = $difference->format('%i');

$intmin = intval($minutes);

if ($intmin >= 5)
{
  downloadfile();
}


$json = file_get_contents("ping.json");

$json = json_decode($json, true);
// Have to add 5 minutes because for some reason the timestamp is 5 minutes off sometimes recheck later
$json["lastupdated"] = timeAgo($rawtime);
$json = json_encode($json);

header("Content-Type: application/json");
echo $json;

?>
