<?php

class thesaurusTerm {
	public $id;
	public $begriff;
	public $definition;
	public $art = array();
	public $synonym = array();
	public $synonymModern = array();
	public $symbol;
	public $oberbegriff = array();
	public $unterbegriff = array();
	public $verwandt = array();
	public $quellen = array();
	public $abbildung = array();
	public $bildlink = array();
	public $forschungsliteratur = array();
	
	public function __construct($nodeRow) {
		$children = $nodeRow->childNodes;
		foreach($children as $field) {
			if ($field->nodeName != '#text' and $field->textContent) {
				$this->insertField($field->nodeName, $field->textContent);
			}
		}
		$this->id = $this->makeID($this->begriff);
		$this->oberbegriff = array_map("makeInternalLink", $this->oberbegriff);
		$this->unterbegriff = array_map("makeInternalLink", $this->unterbegriff);
		$this->verwandt = array_map("makeInternalLink", $this->verwandt);
	}
	private function insertField($nodeName, $content) {
		$field = $this->translateNodeName($nodeName);
		$simpleFields = array('begriff', 'definition', 'symbol');
		if(in_array($field, $simpleFields)) {
			$this->$field = $content;
		}
		else {
			$contentArray = explode('|', $content);
			$this->$field = array_merge($this->$field, $contentArray);
		}
	}
	public function makeID($begriff) {
		$id = strtolower($begriff);			
		$translation = array('-' => '', '.' => '', ',' => '', ';' => '', ':' => '', 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 's');
		$id = strtr($id, $translation);
		$id = strtr($id, ' ', '-');
		return($id);
	}
	private function translateNodeName($string) {
		$translation = array(
			'Begriff' => 'begriff',
			'Definition' => 'definition',
			'Art_des_Begriffs' => 'art',
			'Synonym' => 'synonym',
			'Synonym_-_modern' => 'synonymModern',
			'Modernes_chemisches_Symbol' => 'symbol',
			'Oberbegriff' => 'oberbegriff',
			'Unterbegriff' => 'unterbegriff',
			'Verwandter_Begriff_im_Thesaurus' => 'verwandt',
			'Ausgewählte_Quellen__OPAC-Signatur_mit_Angabe_der_Aufstellung_' => 'quellen',
			'Abbildung_in_den_Quellen' => 'abbildung',
			'Bildlink' => 'bildlink',
			'Ausgewählte_Forschungsliteratur' => 'forschungsliteratur'
		);
		$result = strtr($string, $translation);
		return($result);
	}		
}


?>