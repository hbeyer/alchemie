<?php

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

?>