<?php

include('personList.php');
include('person.php');
include('functions.php');

header('Content-Type:text');
date_default_timezone_set('Europe/Amsterdam');
ini_set("max_execution_time", 600);

function sortPersons($personA, $personB) {
	$a = replaceSpecial($personA->sortiername);
	$b = replaceSpecial($personB->sortiername);
	return strcasecmp($a, $b);
}

function replaceSpecial($string) {
	$translation = array('Č'  => 'C', 'Ḫ'  => 'H', 'Ǧ'  => 'G', 'Ö' => 'Oe');
	return(strtr($string, $translation));
}

function makeHTML(person $person) {
	$lebensdaten = '';
	if($person->lebensdaten) {
		$lebensdaten = ' ('.$person->lebensdaten.')';
	}
	$gnd = '';
	if($person->gnd) {
		$gnd = 'GND: <a href="http://d-nb.info/gnd/'.$person->gnd.'" title="Normdatensatz der DNB" target="_blank">'.$person->gnd.'</a><br />';
	}
	$vorkommenString = '';
	$vorkommen = array('vorkommenAutor' => 'Autor', 'vorkommenBeteiligt' => 'Beteiligte Person', 'vorkommenVerleger' => 'Verleger');
	foreach($vorkommen as $category => $label) {
		if($person->$category != 0) {
			$vorkommenString .= $label.' ('.$person->$category.') ';
		}
	}
	trim($vorkommenString);
	$beaconArray = array();
	foreach($person->beaconResults as $string) {
		$parts = explode('#', $string);
		$beaconArray[] = '<a href="'.$parts[0].'" target="_blank">'.$parts[1].'</a>';
	}
	$beaconString = implode(' | ', $beaconArray);
	if($beaconString) {
		$beaconString = '<br />
		Weiterführende Infomationen: '.$beaconString.'';
	}
	
	$content = '
	<h1>'.$person->sortiername.$lebensdaten.'</h1>
	<p>'.$gnd.'Vorkommen: '.$vorkommenString.'<br />
		<a href="'.$person->searchURL.'" target="_blank" title="'.$person->sortiername.' im OPAC suchen">Titel im OPAC in Verbindung mit dieser Person</a>
	</p>
	<p>&nbsp;</p>
	';
	return($content);
}

$personList = new personList;
$personList->loadFromFile('cache');
usort($personList->content, 'sortPersons');

$letters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '#');
$remaining = $letters;
array_shift($remaining);
$count = 0;
$collect = '';

foreach($personList->content as $person) {
	//Prüfen, ob der Anfangsbuchstabe einer der folgenden im Alphabet ist, wenn nein, wird der Eintrag zwischengespeichert
	if(in_array(strtolower(substr($person->sortiername, 0, 1)), $remaining) == FALSE) {
		$collect .= makeHTML($person);
	}
	//Sind wir schon bei einem folgenden Buchstaben im Alphabet, wird abgespeichert und alle Variablen werden zurückgesetzt
	else {
		file_put_contents('html/'.$letters[$count], $collect);
		$collect = '';
		$collect .= makeHTML($person);
		$count += 1;
		array_shift($remaining);
	}
}
file_put_contents('html/'.$letters[$count], $collect);

?>