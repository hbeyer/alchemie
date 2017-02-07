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
	'118577700' => array('sortiername' => 'Margarete, Frankreich, Königin'),
	'118637649' => array('sortiername' => 'Albertus Magnus'),
	'100942040' => array('sortiername' => 'Del Garbo, Tommaso'),
	'104066822' => array('sortiername' => 'Guglielmo, Mantua, Herzog'),
	'118768522' => array('sortiername' => 'Vincenzo I., Mantua, Herzog'),
	'12959203X' => array('sortiername' => 'Christoph, Brixen, Bischof'),
	'119543052' => array('sortiername' => 'Manderscheidt-Blanckenheim, Jean de'),
	'11859169X' => array('sortiername' => 'Paracelsus'),
	'104081589' => array('sortiername' => 'Portaleone, Avraham ben Da&#x1E7F;id'),
	'129746436' => array('sortiername' => 'Tenison, Thomas'),
	'118507036' => array('sortiername' => 'Basilius, Valentinus'),
	'121292215' => array('sortiername' => 'Zur Lippe- Brake, Amalie'),
	'1037525493' => array('sortiername' => 'Bellère, Balthazar', 'nachname' => 'Bellère')
);

?>
