<?php

function cacheBeacon($sources, $seconds, $user) {
	//Get the current date
	$date = date('U');
	//Get the date saved in file changeDate, create this file if not existent
	if (file_exists('beaconFiles/changeDate') == FALSE) {
		file_put_contents('beaconFiles/changeDate', $date);
	}
	$changeDate = file_get_contents('beaconFiles/changeDate');
	$age = $date - $changeDate;
	$test = 0;
	// Calculate how much time has passed since the last update of the files
	if($age > $seconds) {
		$test = 1;
	}
	// Test whether all Beacon files are present in the folder beaconFiles
	foreach($sources as $key => $source) {
		if(file_exists('beaconFiles/'.$key) == FALSE) {
			$test = 1;
		}
	}
	// Download new files if necessary
	if($test == 1) {
		ini_set('user_agent',$user);
		foreach($sources as $key => $source) {
			$beaconFile = file_get_contents($source['location']);
			//$beaconFile = utf8_encode($beaconFile);
			if($beaconFile) {
				file_put_contents('beaconFiles/'.$key, $beaconFile);
			}
		}
		//Set the change date file to the current date
		file_put_contents('beaconFiles/changeDate', $date);
	}
}

function getChangeDate() {
	if (file_exists('beaconFiles/changeDate') == FALSE) {
		$date = date('U');
		file_put_contents('beaconFiles/changeDate', $date);
	}
	$string = file_get_contents('beaconFiles/changeDate');
	$changeDate = date('d.m.Y', $string);
	return($changeDate);
}

function testBeaconMulti($sources, $gnds, $user) {
	$result = array();
	ini_set('user_agent', $user);
	foreach($gnds as $gnd) {
		$result[$gnd] = array();
		}
	foreach($sources as $key => $source) {
		$beaconFile = file_get_contents('beaconFiles/'.$key);
		foreach($gnds as $gnd) {
			preg_match('~'.$gnd.'~', $beaconFile, $treffer);
			if(isset($treffer[0])) {
				$result[$gnd][] = $key;
			}
		}
		unset($beaconFile);
		}
		return($result);
	}

function makeBeaconLink($gnd, $target) {
	$translate = array('{ID}' => $gnd);
	$link = strtr($target, $translate);
	$linkl = urlencode($link);
	return($link);
}

?>
