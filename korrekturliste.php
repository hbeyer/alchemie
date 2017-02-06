<?php

/*
Diese Datei ist eine Ergänzung zum Skript collectPersons.php.
Die Liste ermöglicht es, Namen für einzelne Personen oder Körperschaften vorzugeben.
Für jede einzelne wird ein assoziatives Array in das Array $amendments eingefügt. Als Index 
steht die GND-Nummer. Als Wert steht wiederum ein assoziatives Array, in dem für ein oder 
mehrere Felder Werte nach dem Schema 'Feldname' => 'Feldinhalt' neu vergeben werden können.
Feldname kann sein: vorname, nachname, name, beiname, titel, zaehlung, koerperschaftsname, sortiername.
*/

$amendments = array(
	'1042346275' => array('koerperschaftsname' => 'Helwing, Akademische Verlagsbuchhandlung', 'sortiername' => 'Helwing, Akademische Verlagsbuchhandlung'),
	'118683969' => array('sortiername' => 'Fleury, André Hercule Cardinal de'),
	'120530791' => array('sortiername' => 'Croÿ, Charles III. de'),
	'118557203' => array('sortiername' => 'Jean de Meung'),
	'118577700' => array('sortiername' => 'Navarre, Marguerite de, Frankreich, Königin'),
	'118637649' => array('sortiername' => 'Albertus Magnus'),
	'100942040' => array('sortiername' => 'Del Garbo, Tommaso'),
	'1037525493' => array('sortiername' => 'Bellère, Balthazar', 'nachname' => 'Bellère')
);

?>
