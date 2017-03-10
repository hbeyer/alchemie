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

?>