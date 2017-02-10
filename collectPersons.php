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
Die Fuktion $personList->insertAmendments sorgt dafür, dass jeweils die angegebenen Felder im Datensatz mit der
angegebenen GND-Nummer überschrieben werden.

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
$personList->insertAmendments();
$personList->insertBeacon();
$personList->makeXML('personList-test.xml');


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
			echo 'Fehlerhaft:'."\r\n";
			var_dump($person);
			echo "\r\n";
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
					$person->vorkommenAutor += $personOld->vorkommenAutor;
					$person->vorkommenBeteiligt += $personOld->vorkommenBeteiligt;
					$person->vorkommenVerleger += $personOld->vorkommenVerleger;
					$personOld = $person;
					var_dump($personOld);
					echo "\r\nErsetzt durch:";
					echo "\r\n";
					var_dump($person);
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

	function insertAmendments() {
		require_once('korrekturliste.php');
		foreach($this->content as $person) {
			if(isset($amendmentsGND[$person->gnd])) {
				foreach($amendmentsGND[$person->gnd] as $field => $value) {
					$person->$field = $value;
				}
			}		
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
	
	function makeXML($path) {
		$xml = new DOMDocument('1.0', 'UTF-8');
		$xml->formatOutput = true;
		$xml->loadXML('<personList></personList>');
		$rootNode = $xml->getElementsByTagName('personList')->item(0);

		foreach($this->content as $person) {
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
				elseif($value != '' and $value != array()) {
					$propertyNode = $xml->createElement($key);
					$propertyValue = $xml->createTextNode($value);
					$propertyNode->appendChild($propertyValue);
					$personNode->appendChild($propertyNode);
				}
			}
			$rootNode->appendChild($personNode);
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
		$this->replaceSortingName();
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
	
	//Diese Funktion ersetzt in den angegebenen Fällen den Sortiernamen, um Dubletten vor dem Einfügen in die personList abzufangen.
	//Auf Ebene der personList wird anschließend die Funktion personList->insertAmendments() aufgerufen, die aus der Datei korrekturliste.php 
	//Ersetzungen für bestimmte GND-Nummern einfügt.
	function replaceSortingName() {
		$amendmentsSortingName = array(
			'Dillenius, Justus Fridericus' => 'Dillenius, Justus Friedrich',
			'Adolphus-Fridericus Dux Megapolitano' => 'Adolf Friedrich I., Mecklenburg, Herzog',
			'Adolphus-Fridericus Dux Megapolitanus' => 'Adolf Friedrich I., Mecklenburg, Herzog',
			'Adolphus-Fridericus Megapolitano, Dux' => 'Adolf Friedrich I., Mecklenburg, Herzog',
			'Anomaeus, Joh. Joachimus' => 'Anomoeus, Johannes Joachim',
			'Antonius Gunterus Comes in Oldenburg' => '',
			'Antonius Guntherus Comes in Oldenburg & Delmenhorst' => '',
			'Arndt. Joh.' => 'Arndt, Johann',
			'Arnoldus de Villaenova' => 'Arnoldus de Villa Nova',
			'Artephius' => 'Artephius Philosophus',
			'August Wolfenbüttel, Herzog' => 'August Braunschweig-Lüneburg, Herzog, 1579-1666',
			'Augustus Juniorus Dux Brunswicensis & Lünaeburgensis &c.' => 'August Braunschweig-Lüneburg, Herzog, 1579-1666',
			'Augustus Fürst zu Anhalt' => 'August Anhalt-Köthen, Fürst',
			'Augustus Princeps Anhaltinus' => 'August Anhalt-Köthen, Fürst',
			'Bacon, Rogerus' => 'Bacon, Roger',
			'Balbian, Joos' => 'Balbian, Joos a',
			'Beyerus, Johannes Hartmannus' => 'Beyer, Johann Hartmann',
			'Bollingerus, Ulricus' => 'Bollinger, Ulrich',
			'Bomsdorf, Jobus a' => 'Bomsdorf, Jacob von',
			'Brelerus, Melchior' => 'Breler, Melchior',
			'Brendelius, Zacharias' => 'Brendel, Zacharias',
			'Burenneus, Rudolphus' => 'Burennaeus, Rudolph',
			'Burennus, Rudolphus' => 'Burennaeus, Rudolph',
			'Burggravius, Johannes Ernestus' => 'Burggrav, Johann Ernst',
			'Burmeister, Johannes' => 'Burmeister, Johann',
			'Burmeisterus, Johannes' => 'Burmeister, Johann',
			'Buttet' => 'Buttet, Marc-Claude de',
			'Bütnerus, Johannes' => 'Büttner, Johann',
			'Christianus Ascanieae, Comes' => 'Christian I., Anhalt-Bernburg, Fürst',
			'Christianus Comes Ascaniae' => 'Christian I., Anhalt-Bernburg, Fürst',
			'Clauderus, Gabriel' => 'Clauder, Gabriel',
			'Colbertus, Joannes Baptista' => 'Colbert, Jean Baptiste',
			'Conringius, Hermannus' => 'Conring, Hermann',
			'Dietzel, Caspar' => 'Dietzel, Kaspar',
			'Dornau, Caspar' => 'Dornavius a Dornaw, Caspar',
			'Drexel, Joannes' => 'Drexel, Johannes',
			'DuChesne, Joseph' => 'Du Chesne, Joseph',
			'Duval, Robert' => 'Duval, Robert, Vallensis',
			'Ellenberger, Henricus' => 'Ellenberger, Heinrich',
			'Ellenbergerus, Henricus' => 'Ellenberger, Heinrich',
			'Enoc, Pierre' => 'Enoch, Pierre',
			'Enochus, Petrus' => 'Enoch, Pierre',
			'Ernest Köln, Erzbischof' => 'Ernestus Erzbischof und Kurfürst zu Köln',
			'Ernestus Archiepiscopus Coloniensis' => 'Ernestus Erzbischof und Kurfürst zu Köln',
			'Faber, Georgius' => 'Faber, Georg',
			'Faber, Petrus Johannes' => 'Fabre, Pierre Jean',
			'Fabricius, Johan. Georgius' => 'Fabricius, Johann Georg',
			'Fabricius, Iohannes Georgius' => 'Fabricius, Johann Georg',
			'Fachs, Ludovicus Wolffg.' => 'Fachs, Ludwig Wolfgang',
			'Fausius, Johannes Casparus' => 'Fausius, Johann Caspar',
			'Fehr, Joh. Micahel' => 'Fehr, Johann Michael',
			'Feyrabendt, Sigmuindt' => 'Feyerabend, Sigmund',
			'Fischer, Joh. Andr.' => 'Fischer, Johann Andreas',
			'Forberger, Georgius' => 'Forberger, Georg',
			'Franken-Berg, Abraham vom' => 'Frankenberg, Abraham von',
			'Franckenberg, Abraham vom' => 'Frankenberg, Abraham von',
			'François France, Prince, 1554-1584' => 'Franz Frankreich, Prinz, 1554-1584',
			'Fridericus Dux Wirtembergicus & Teccensis' => 'Friedrich Herzog von Württemberg',
			'Fridercus Ulricus Dux Brunsvicensis & Lunaeburgensis' => 'Friedrich Ulrich, Herzog von Braunschweig-Wolfenbüttel',
			'Fridericus Ulricus Dux Brunsvicensium ac Lunaeburgensium' => 'Friedrich Ulrich, Herzog von Braunschweig-Wolfenbüttel',
			'Friedrich Ulrich Herzog zu Braunschweig und Lüneburg' => 'Friedrich Ulrich, Herzog von Braunschweig-Wolfenbüttel',
			'Furck, S.' => 'Furck, Seb.',
			'Gabler, Johan' => 'Gabler, Johann',
			'Gentersbergerus, Samuel' => 'Genttersberger, Samuel',
			'Georg Wilhelm Herzog zu Braunschweig und Lüneburg' => 'Georg Wilhelm Braunschweig-Lüneburg, Herzog',
			'Gerhard, Joannes' => 'Gerhard, Johann',
			'Goclenius, Rudolphus' => 'Goclenius, Rudolph',
			'Goclenius, Rudolph, der Ältere' => 'Goclenius, Rudolph',
			'Gratarolus, Gulielmus' => 'Grataroli, Guglielmo',
			'Greiff, Sebastianus' => 'Greiff, Sebastian',
			'Guggerus, Joannes Jacobus' => 'Guggerus, Johannes Jacobus',
			'Götze, Thomas Matth.' => 'Götze, Thomas Mattihas',
			'Haffner, M.' => 'Haffner, Melchior',
			'Hagendornius, Ehrenfridus' => 'Hagendorn, Ehrenfried',
			'Hannemann, J. L.' => 'Hannemann, Johann Ludwig',
			'Hartigius, Jo.' => 'Hartigius, Johannes',
			'Hartmann, Joh.' => 'Hartmann, Johann',
			'Hartmannus, Joh.' => 'Hartmann, Johann',
			'Hartmannus, Johan.' => 'Hartmann, Johann',
			'Hartmannus, Johannes' => 'Hartmann, Johann',
			'Hartungus, Valentinus' => 'Hartung, Valentinus',
			'Helmont, Jan Baptista' => 'Helmont, Jan Baptista van',
			'Helmont, Jan Baptiste van' => 'Helmont, Jan Baptista van',
			'Henricus Julius Dux Brunsvicensi ac Lunaeburgensi' => 'Heinrich Julius Braunschweig-Wolfenbüttel, Herzog',
			'Hermann IV., Hessen-Kassel, Landgraf' => 'Hermann IV., Landgraf von Hessen-Kassel',
			'Hermann Köln, Erzbischof, V.' => 'Hermann V., Erzbischof von Köln',
			'Hoffmannus, Joannes' => 'Hoffmann, Johann',
			'Holland, Johann Isaac' => 'Hollandus, Johan Isaac',
			'Horstius, Gregorius' => 'Horst, Gregor',
			'Hubnerus, Bartolomaeus' => 'Hubner, Bartolomäus',
			'Jacobi, Johannes' => 'Jacobi, Johann',
			'Jennis, Lukas' => 'Jennis, Lucas',
			'Jennisius, Lucas' => 'Jennis, Lucas',
			'Joachim Friderich Brandenburg, Kurfürst' => 'Joachim Friedrich Kurfürst zu Brandenburg',
			'Joachim Friderich Markgraf zu Brandenburg' => 'Joachim Friedrich Kurfürst zu Brandenburg',
			'Joachim Friedrich Brandenburg, Kurfürst' => 'Joachim Friedrich Kurfürst zu Brandenburg',
			'Joachim Friedrich Markgraf zu Brandenburg' => 'Joachim Friedrich Kurfürst zu Brandenburg',
			/* '' => '',
			'' => '',
			'' => '',
			'' => '', */
			'Doude, Arnoldus' => 'Doude, Aernout'
			);
			
			if(isset($amendmentsSortingName[$this->sortiername])) {
				$this->sortiername = $amendmentsSortingName[$this->sortiername];
			}
	}

}

?>
