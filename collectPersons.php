<?php

/* 
Dieses Skript lädt über die SRU-Schnittstelle des GBV sämtliche Titel, die im Projekt "Erschließung
alchemiegeschichtlicher Quellen" an der HAB erschlossen wurden (Abrufzeichen "Alchemie" in Feld 8600) und extrahiert
die Personeninformationen zur Anzeige im Portal alchemie.hab.de. Sie werden dafür in einer XML-Datei abgelegt.

Folgende Variablen können einfach angepasst werden:

$maximumRecords: Zahl der Titel, die gleichzeitig geladen werden (es wird so lange weitergeladen, bis keine 
Datensätze mehr kommen)

$personList->makeXML('{Dateiname}'): Pfad (inclusive Endung) zum Speichern der XML-Datei

$evaluateFields: Assoziatives Array, in dem als Schlüssel die Feldnummer in PicaXML, als Wert die Beziehungs-
kennzeichnung für darin enthaltene Personen angegeben ist. Als Beziehungskennzeichnung sind 'autor', 
'beteiligt' und 'verleger' möglich, alles andere hat keinen Effekt.

$target: Die abzufragende SRU-Schnittstelle

Korrekturen an den heruntergelandenen Namensformen können in der Datei korrekturliste.php vorgenommen werden.

Das Skript reichert die Daten außerdem mit Links an, die aus Beacon-Dateien gebildet werden. Die Dateien liegen im 
Verzeichnis beaconFiles, die zugehörigen Funktionen in storeBeacon.php. In der Datei beaconSources.php ist festgelegt, 
welche online erreichbaren Beacon-Dateien ausgewertet werden. Die Funktion cacheBeacon sorgt dafür, dass die 
Beacon-Dateien vor dem Auswerten neu gespeichert werden, wenn sie älter als die im Parameter festgelegte Anzahl 
von Sekunden sind.

*/

header('Content-Type:text');
date_default_timezone_set('Europe/Amsterdam');
ini_set("max_execution_time", 600);

$personList = new personList;

$startRecord = 1;
$maximumRecords = 200;
$test = 'not_finished';
while($test == 'not_finished') {
	$test = $personList->loadFromSRU($startRecord, $maximumRecords);
	$startRecord += $maximumRecords;
}
$personList->dumpToFile('cache');

//$personList->loadFromFile('cache');
//var_dump($personList);
$personList->insertAmendmentsGND();
$personList->insertBeacon();
$personList->makeSearchNames();
$personList->makeXML('personList.xml');

class personList {
	
	public $content = array();
	public $evaluateFields = array(
		'028A' => 'autor',
		'028B' => 'autor',
		'028L' => 'beteiligt',
		'028C' => 'beteiligt',
		'033J' => 'verleger'
		);
	
	function addPerson($person) {
		if(is_object($person) == FALSE) {
			return;
		}
		elseif(get_class($person) != 'person') {
			return;
		}
		elseif(preg_match('~[0-9X]{7}~', $person->sortiername) or trim($person->sortiername) == '') {
			/* echo 'Nicht aufgenommen, da ohne Sortiername:'."\r\n";
			var_dump($person);
			echo "\r\n"; */
			return;
		}
		foreach($this->content as $personOld) {
			// Wenn die neue Person eine GND hat und diese bereits vorkommt, wird sie nicht eingefügt, sondern das Vorkommen in der vorhandenen addiert.
			if($person->gnd == $personOld->gnd and $person->gnd != '') {
				$personOld->vorkommenAutor += $person->vorkommenAutor;
				$personOld->vorkommenBeteiligt += $person->vorkommenBeteiligt;
				$personOld->vorkommenVerleger += $person->vorkommenVerleger;
				return;
			}
		}
		foreach($this->content as $personOld) {
			// Wenn die neue Person auf diese Art nicht zugeordnet werden konnte, wird geprüft, ob es bereits eine mit identischem Sortiernamen gibt.
			if($person->sortiername == $personOld->sortiername) {
				//Fall 1: Die vorhandene Person hat eine GND
				if($personOld->gnd != '') {
					$personOld->vorkommenAutor += $person->vorkommenAutor;
					$personOld->vorkommenBeteiligt += $person->vorkommenBeteiligt;
					$personOld->vorkommenVerleger += $person->vorkommenVerleger;
					return;
				}
				//Fall 2: Die vorhandene Person hat keine GND
				else {
					$personOld->vorkommenAutor += $person->vorkommenAutor;
					$personOld->vorkommenBeteiligt += $person->vorkommenBeteiligt;
					$personOld->vorkommenVerleger += $person->vorkommenVerleger;
					$personOld->searchNameArray = array_merge($person->searchNameArray, $personOld->searchNameArray);
					$personOld->searchNameArray = array_unique($personOld->searchNameArray);
					$personOld->gnd = $person->gnd;
					return;
				}
			}
		}
		if($person->sortiername) {
			$this->content[] = $person;
		}
	}
	
	function loadFromSRU($startRecord, $maximumRecords) {

		$target ='http://sru.gbv.de/opac-de-23?version=1.1&operation=searchRetrieve&query=pica.abr%3Dalchemie%20and%20pica.mak%3Da*&maximumRecords='.$maximumRecords.'&startRecord='.$startRecord.'&recordSchema=picaxml';

		$answer = file_get_contents($target);

		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->loadXML($answer);
		unset($answer);

		$records = $dom->getElementsByTagName('record')->length;
		if($records == 0) {
			return('finished');
		}
		
		foreach($this->evaluateFields as $field => $relation) {
			$xp = new DOMXPath($dom);
			$nodes = $xp->evaluate('//*[namespace-uri()="info:srw/schema/5/picaXML-v1.0" and local-name()="datafield" and @tag="'.$field.'"]');	
			foreach($nodes as $node) {
				$personOccurrence = new person;
				if($relation == 'autor') {
					$personOccurrence->vorkommenAutor = 1;
				}
				elseif($relation == 'beteiligt') {
					$personOccurrence->vorkommenBeteiligt = 1;
				}
				elseif($relation == 'verleger') {
					$personOccurrence->vorkommenVerleger = 1;
				}
				$personData = $node->childNodes;
				$personOccurrence->importNodeList($personData);
				$personOccurrence->rearrangeSubfields();
				$this->addPerson($personOccurrence);
			}
		}
		return('not_finished');
		//return('finished');
	}
	
	function insertAmendmentsGND() {
		include('korrekturliste.php');
		$count = 0;
		foreach($this->content as $person) {
			if(isset($amendmentsGND[$person->gnd]) and $person->gnd != '') {
				foreach($amendmentsGND[$person->gnd] as $key => $value) {
					$person->$key = $value;
				}
			}
			$count++;
		}
	}

	function insertBeacon() {
		$user = 'Dr. Hartmut Beyer, Wolfenbüttel';
		require_once('storeBeacon.php');
		require_once('beaconSources.php');
		cacheBeacon($beaconSources, 1209600, $user);
		$gnds = array();	
		foreach($this->content as $person) {
			if($person->gnd != '') {
				$gnds[] = $person->gnd;
			}
		}
		$beacon = testBeaconMulti($beaconSources, $gnds, $user);
		foreach($this->content as $person) {
			if($person->gnd != '') {
				$person->beaconResults = $this->resolveBeaconKeys($person->gnd, $beacon[$person->gnd], $beaconSources);
			}	
		}
	}

	function resolveBeaconKeys($gnd, $keys, $beaconSources) {
		$result = array();
		require_once('storeBeacon.php');
		foreach($keys as $key) {
			$link = makeBeaconLink($gnd, $beaconSources[$key]['target']);
			$result[] = $beaconSources[$key]['label'].'#'.$link;
		}
		return($result);
	}
	
	function makeSearchNames() {
		foreach($this->content as $person) {
			$person->makeSearchURL();
		}
	}
	
	function dumpToFile($name) {
		$serialize = serialize($this->content);
		file_put_contents($name, $serialize);
	}
	
	function loadFromFile($name) {
		$string = file_get_contents($name);
		$this->content = unserialize($string);
	}
	
	function makeXML($path) {
		$xml = new DOMDocument('1.0', 'UTF-8');
		$xml->formatOutput = true;
		$xml->loadXML('<personList></personList>');
		$rootNode = $xml->getElementsByTagName('personList')->item(0);
		foreach($this->content as $person) {
			if($person->sortiername) {
				$personNode = $xml->createElement('person');
				foreach($person as $key => $value) {
					if($key == 'beaconResults' and $value != array()) {
						$propertyNode = $xml->createElement($key);
						foreach($value as $link) {
							$linkNode = $xml->createElement('link');
							$linkValue = $xml->createTextNode($link);
							$linkNode->appendChild($linkValue);
							$propertyNode->appendChild($linkNode);
						}
						$personNode->appendChild($propertyNode);
					}
					//elseif($value != '' and $value != array()) {
					elseif($value != '' and is_array($value) == FALSE) {
						$propertyNode = $xml->createElement($key);
						$propertyValue = $xml->createTextNode($value);
						$propertyNode->appendChild($propertyValue);
						$personNode->appendChild($propertyNode);
					}
				}
				$rootNode->appendChild($personNode);
			}
		}
		$handle = fopen($path, 'w');
		fwrite($handle, $xml->saveXML(), 3000000);
	}
	
}


class person {
	public $vorname;
	public $nachname;
	public $name;
	public $beiname;
	public $titel;
	public $zaehlung;
	public $koerperschaftsname;
	public $sortiername;
	public $gnd;
	public $searchURL;
	public $searchNameArray = array();
	public $lebensdaten;
	public $geburtsjahr;
	public $sterbejahr;
	public $beziehungskennzeichnung;
	public $vorkommenAutor = 0;
	public $vorkommenBeteiligt = 0;
	public $vorkommenVerleger = 0;
	public $beaconResults = array();
	public $subfields = array();
	
	function importNodeList($nodeList) {
		if(is_object($nodeList) == FALSE) {
			return;
		}
		elseif(get_class($nodeList) != 'DOMNodeList') {
			return;
		}
		
		foreach($nodeList as $propertyNode) {
			$attributes = $propertyNode->attributes;
			if($attributes != NULL) {
				$code = $attributes->getNamedItem('code')->value;
				$this->subfields[$code] = $propertyNode->nodeValue;
			}
		}
	}
	
	function rearrangeSubfields() {
		if(isset($this->subfields['0'])) {
			$this->gnd = $this->trimGND($this->subfields['0']);
		}
		$concordance = array(
			'd' => 'vorname', 
			'a' => 'nachname', 
			'c' => 'titel', 
			'n' => 'zaehlung', 
			'E' => 'geburtsjahr', 
			'F' => 'sterbejahr', 
			'P' => 'name', 
			'l' => 'beiname', 
			'B' => 'beziehungskennzeichnung');
		foreach($concordance as $code => $field) {
			if(isset($this->subfields[$code])) {
				$this->$field = $this->subfields[$code];
			}
		}
		if($this->geburtsjahr and $this->sterbejahr) {
			$this->lebensdaten = $this->geburtsjahr.'–'.$this->sterbejahr;
		}
		//Bisweilen sind Verleger nur über das Subfeld B zu erkennen, in diesen Fällen wird das Vorkommen nachkorrigiert.
		if($this->beziehungskennzeichnung == 'Verlag' or $this->beziehungskennzeichnung == 'Vertrieb') {
			$this->vorkommenVerleger = 1;
			$this->vorkommenAutor = 0;
			$this->vorkommenBeteiligt = 0;
		}
		$this->makeSortingName();
		$this->removeRedundant();
	}
	
	function makeSortingName() {
		$titel = '';
		$zaehlung = '';
		$beiname = '';
		if($this->vorname and $this->nachname) {
			$titel = '';
			$zaehlung = '';
			$beiname = '';
			if($this->zaehlung) {
				$zaehlung = ' '.$this->zaehlung;
			}
			if($this->titel) {
				$titel = ' '.$this->titel;
			}
			if($this->beiname) {
				$beiname = ', '.$this->beiname;
			}			
			$this->sortiername = $this->nachname.', '.$this->vorname.$zaehlung.$titel.$beiname;
		}
		elseif($this->name and $this->beiname) {
			if($this->zaehlung) {
				$zaehlung = ' '.$this->zaehlung.',';
			}
			if($this->titel) {
				$titel = ' '.$this->titel;
			}
			$this->sortiername = $this->name.$zaehlung.' '.$this->beiname.$titel;
		}
		elseif($this->nachname != '' and $this->vorname == '') {
			$this->koerperschaftsname = $this->nachname;
			$this->sortiername = $this->nachname;
			$this->nachname = '';
		}
		elseif($this->name != '') {
			$this->sortiername = $this->name;
		}
		$this->searchNameArray[] = $this->sortiername;
		$this->insertAmendments();
	}
	
	function removeRedundant() {
		$this->subfields = array();
		$this->geburtsjahr = '';
		$this->sterbejahr = '';
		$this->beziehungskennzeichnung = '';
	}
	
	function trimGND($string) {
		$translation = array('gnd/' => '');
		$string = strtr($string, $translation);
		return($string);
	}
	
	function insertAmendments() {
		include('korrekturliste.php');
		if(isset($amendmentsSortingName[$this->sortiername])) {
			$amendment = $amendmentsSortingName[$this->sortiername];
			$test = checkTextDiff($this->sortiername, $amendment);
			if($test == 'diff') {
				$this->searchNameArray[] = $amendment;
			}
			$this->sortiername = $amendment;
		}
	}

	function makeSearchURL() {
		$request = '';
		//Kleine Pfuscherei, um Dopplungen bei den Suchnamen zu vermeiden
		$this->searchNameArray = array_unique($this->searchNameArray);
		$searchString = implode('|', $this->searchNameArray);
		if(isset($this->searchNameArray[1])) {
			$searchString = '('.$searchString.')';
		}
		$testPer = 0;
		$testDru = 0;
		$testInit = 0;
		if($this->vorkommenAutor > 0 or $this->vorkommenBeteiligt > 0) {
			$testPer = 1;
		}
		if($this->vorkommenVerleger > 0) {
			$testDru = 1;
		}
		if(preg_match('~^[A-Z]\. [A-Z]\.~', $this->sortiername)) {
			$testInit = 1;
		}
		$personKey = 'aut';
		if($testInit == 1) {
			$personKey = 'per';
		}
		
		if($this->gnd) {
			if($testDru == 1 and $testPer == 1) {
				$request = '(gnd+'.$this->gnd.'+or+'.$personKey.'+'.$searchString.'+or+dru+'.$searchString.')';
			}
			elseif($testDru == 1) {
				$request = 'dru+'.$searchString;
			}
			elseif($testPer == 1) {
				$request = '(gnd+'.$this->gnd.'+or+'.$personKey.'+'.$searchString.')';
			}			
		}
		else {
			if($testDru == 1 and $testPer == 1) {
				$request = '('.$personKey.'+'.$searchString.'+or+dru+'.$searchString.')';
			}
			elseif($testDru == 1) {
				$request = 'dru+'.$searchString;
			}
			elseif($testPer == 1) {
				$request = ''.$personKey.'+'.$searchString;
			}						
		}
		$this->searchURL = 'http://opac.lbs-braunschweig.gbv.de/DB=2/CMD?ACT=SRCHA&TRM='.$request.'+and+abr+alchemie';
		$this->searchArray = array();
	}

}

function checkTextDiff($name1, $name2) {
	$return = 'diff';
	$translation = array(',' => '', '.' => '');
	$name1 = strtr($name1, $translation);
	$name2 = strtr($name2, $translation);
	$name1 = strtolower($name1);
	$name2 = strtolower($name2);
	if($name1 == $name2) {
		$return = 'noDiff';
	}
	return($return);
}

?>
