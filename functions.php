<?php

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

function makeID($string) {	
		$translation = array(
		'-' => '', 
		'.' => '', 
		',' => '', 
		';' => '', 
		':' => '', 
		'ä' => 'ae', 
		'ö' => 'oe', 
		'ü' => 'ue', 
		'Č'  => 'C', 
		'Ḫ'  => 'H', 
		'Ǧ'  => 'G', 
		'ā'  => 'a', 
		'Ö' => 'Oe',
		'Ä' => 'Ae',
		'Ü' => 'Ue',
		'ß' => 'ss',
		'é' => 'e',
		'è' => 'e',
		'ê' => 'e',
		'ç' => 'c',
		'ò' => 'o',
		'ô' => 'o',
		'ù' => 'u',
		'û' => 'u',
		'à' => 'a',
		'á' => 'a',
		'â' => 'a',
		'å' => 'a',
		'í' => 'i',
		'ì' => 'i',
		'ï' => 'i',
		'ī' => 'i',
		'ÿ' => 'y',
		'\'' => '',
		'ḥ' => 'h'		
		);
		$id = strtr($string, $translation);
		$id = strtolower($id);				
		$id = strtr($id, ' ', '-');
		return($id);
	}

?>