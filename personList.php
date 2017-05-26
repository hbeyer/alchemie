<?php

class personList {
	
	public $content = array();
	private $evaluateFields = array(
		'028A' => 'autor',
		'028B' => 'autor',
		'028L' => 'beteiligt',
		'028C' => 'beteiligt',
		'033J' => 'verleger'
		);
	
	function addPerson(person $person) {
		if(preg_match('~[0-9X]{7}~', $person->sortiername) or trim($person->sortiername) == '') {
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
		$xp = new DOMXPath($dom);
		$nodeList = $xp->query('//zs:record');
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

?>
