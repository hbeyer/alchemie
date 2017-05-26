<?php

/* 
Dieses Skript lädt über die SRU-Schnittstelle des GBV sämtliche Titel, die im Projekt "Erschließung
alchemiegeschichtlicher Quellen" an der HAB erschlossen wurden (Abrufzeichen "Alchemie" in Feld 8600) und extrahiert
die Personeninformationen zur Anzeige im Portal alchemie.hab.de. Sie werden dafür in einer XML-Datei abgelegt.

Folgende Variablen können einfach angepasst werden:

$maximumRecords: Zahl der Titel, die gleichzeitig geladen werden (es wird so lange weitergeladen, bis keine 
Datensätze mehr kommen)

personList::makeXML: Pfad (inclusive Endung) zum Speichern der XML-Datei

personList::evaluateFields: Assoziatives Array, in dem als Schlüssel die Feldnummer in PicaXML, als Wert die Beziehungs-
kennzeichnung für darin enthaltene Personen angegeben ist. Als Beziehungskennzeichnung sind 'autor', 
'beteiligt' und 'verleger' möglich, alles andere hat keinen Effekt.

$target in personList::loadFromSRU(): Die abzufragende SRU-Schnittstelle

Korrekturen an den heruntergelandenen Namensformen können in der Datei korrekturliste.php vorgenommen werden.

Das Skript reichert die Daten außerdem mit Links an, die aus Beacon-Dateien gebildet werden. Die Dateien liegen im 
Verzeichnis beaconFiles, die zugehörigen Funktionen in storeBeacon.php. In der Datei beaconSources.php ist festgelegt, 
welche online erreichbaren Beacon-Dateien ausgewertet werden. Die Funktion cacheBeacon() sorgt dafür, dass die 
Beacon-Dateien vor dem Auswerten neu gespeichert werden, wenn sie älter als die im Parameter festgelegte Anzahl 
von Sekunden sind.

*/

header('Content-Type:text');
date_default_timezone_set('Europe/Amsterdam');
ini_set("max_execution_time", 600);

include('personList.php');
include('person.php');
include('functions.php');

$personList = new personList;

$startRecord = 1;
$maximumRecords = 500;
$test = 'not_finished';
while($test == 'not_finished') {
	$test = $personList->loadFromSRU($startRecord, $maximumRecords);
	$startRecord += $maximumRecords;
}
//$personList->loadFromFile('cache');
//var_dump($personList);
$personList->insertAmendmentsGND();
$personList->insertBeacon();
$personList->makeSearchNames();
$personList->dumpToFile('cache');
$personList->makeXML('personList.xml');

var_dump($personList->content);

?>