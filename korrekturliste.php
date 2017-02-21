<?php

/*
Diese Datei enthält Korrekturen für die Personendaten. Eingefügt werden sie von der Funktion person->insertAmendments().
Das Array $amendmentsSortingName wirkt sich nur auf den Sortiernamen aus, unabhängig davon, ob die Person eine GND-Nummer hat.
Im Array $amendmentsGND wird jeweils einer GND-Nummer ein assoziatives Array zugeordnet, in dem Überschreibungen beliebiger Felder
des Objekts nach dem Schema {Feldname} => {Feldinhalt} vorgenommen werden können.
*/

$amendmentsSortingName = array(

	'Adolphus-Fridericus Dux Megapolitano' => 'Adolf Friedrich I., Herzog von Mecklenburg',
	'Adolphus-Fridericus Dux Megapolitanus' => 'Adolf Friedrich I., Herzog von Mecklenburg',
	'Adolphus-Fridericus Megapolitano, Dux' => 'Adolf Friedrich I., Herzog von Mecklenburg',
	'Aemilia Elisabetha Hassiae, Landgravia' => 'Amalie Elisabeth Landgräfin von Hessen-Kassel',
	'Albertus Comes Palatinus ad Rhenum, Dux Boiariaeae' => 'Albrecht V., Bayern, Herzog', // Umleitung auf GND
	'Albertus Episcopus Ratisponensis' => 'Albert IV., Bischof von Regensburg',
	'Albrecht Sigismund Bischof zu Freising' => 'Albert Sigmund, Bischof von Freising',
	'Alfonso Castilla, Rey, X.' => 'Alfonso X., König von Kastilien',
	'Anna Margaretha Hessen-Darmstadt, Landgräfin' => 'Anna Margaretha Landgräfin von Hessen-Darmstadt',
	'Anomaeus, Joh. Joachimus' => 'Anomoeus, Johannes Joachim',
	'Anselmus Franciscus Moguntiae Archiepiscopus' => 'Anselm Franz Erzbischof von Mainz',
	'Anton Ulrich Braunschweig-Wolfenbüttel, Herzog' => 'Anton Ulrich, Herzog zu Braunschweig-Wolfenbüttel',
	'Antonius Gunterus Comes in Oldenburg' => 'Anton Günther Graf von Oldenburg',
	'Antonius Guntherus Comes in Oldenburg & Delmenhorst' => 'Anton Günther Graf von Oldenburg',
	'Arndt. Joh.' => 'Arndt, Johann',
	'Arnoldus de Villaenova' => 'Arnoldus de Villa Nova',
	'Artephius' => 'Artephius Philosophus',
	'August Wolfenbüttel, Herzog' => 'August der Jüngere, Herzog zu Braunschweig-Lüneburg',
	'Augustus Juniorus Dux Brunswicensis & Lünaeburgensis &c.' => 'August der Jüngere, Herzog zu Braunschweig-Lüneburg',
	'August Braunschweig-Lüneburg, Herzog, 1579-1666' => 'August der Jüngere, Herzog zu Braunschweig-Lüneburg',
	'Augustus Fürst zu Anhalt' => 'August Fürst von Anhalt-Köthen',
	'Augustus Princeps Anhaltinus' => 'August Fürst von Anhalt-Köthen',
	'August Anhalt-Köthen, Fürst' => 'August Fürst von Anhalt-Köthen',
	'August Anhalt-Plötzkau, Fürst' => 'August Fürst von Anhalt-Köthen',
	'August Sachsen, Herzog' => 'August Kurfürst von Sachsen',
	'August Sachsen, Kurfürst' => 'August Kurfürst von Sachsen',
	'Augustus Dux Saxoniae' => 'August Kurfürst von Sachsen',
	'August Wilhelm Braunschweig-Wolfenbüttel, Herzog' => 'August Wilhelm Herzog zu Braunschweig-Lüneburg',

	'Bacon, Rogerus' => 'Bacon, Roger',
	'Bautzmannus, Christoph' => 'Bautzmann, Christophorus',
	'Balbian, Joos' => 'Balbian, Joos a',
	'Becker, Eduart' => 'Becker, Eduard',
	'Bellevreus, Pomponius' => 'Belleureus, Pomponius',
	'Bemelberg et Hohenburg, Conradus a' => 'Bemelberg, Konrad',
	'Beyerus, Johannes Hartmannus' => 'Beyer, Johann Hartmann',
	'Bierbach, Christoph.' => 'Bierbach, Christophorus',
	'Billich, Anton-Gunther' => 'Billich, Anton Günther',
	'Boe, Franciscus de le' => 'Boe, Frans de le',
	'Bollingerus, Ulricus' => 'Bollinger, Ulrich',
	'Bomsdorf, Jobus a' => 'Bomsdorf, Jacob von',
	'Brelerus, Melchior' => 'Breler, Melchior',
	'Brendelius, Zacharias' => 'Brendel, Zacharias',
	'Bruxius, Adamus' => 'Bruxius, Adam',
	'Burenneus, Rudolphus' => 'Burennaeus, Rudolph',
	'Burennus, Rudolphus' => 'Burennaeus, Rudolph',
	'Burggravius, Johannes Ernestus' => 'Burggrav, Johann Ernst',
	'Burmeister, Johannes' => 'Burmeister, Johann',
	'Burmeisterus, Johannes' => 'Burmeister, Johann',
	'Buttet' => 'Buttet, Marc-Claude de',
	'Bütnerus, Johannes' => 'Büttner, Johann',
	
	'Carolus Dux Megapolitanus' => 'Karl Herzog von Mecklenburg',
	'Carolus I. Hassiae Landgravio' => 'Karl I., Landgraf von Hessen-Kassel',
	'Carolus Philippus Dux Finlandiae' => 'Karl Philipp Herzog von Finnland',
	'Catharina Brandenburg, Kurfürstin' => 'Katharine Kurfürstin von Brandenburg',
	'Catharina geb. Markgräfin und Kurfürstin zu Brandenburg' => 'Katharine Kurfürstin von Brandenburg',
	'Christian Albrecht Schleswig-Holstein-Gottorf, Herzog' => 'Christian Albrecht Herzog von Schleswig-Holstein-Gottorf',
	'Christian August Pfalz-Sulzbach, Pfalzgraf' => 'Christian August Pfalzgraf von Sulzbach',
	'Christian August Rhein, Pfaltzgraf' => 'Christian August Pfalzgraf von Sulzbach',
	'Christian Brandenburg-Kulmbach, Markgraf' => 'Christian Markgraf von Brandenburg-Kulmbach',
	'Christian Marggraf zu Brandenburg' => 'Christian Markgraf von Brandenburg-Kulmbach',
	'Christianus Marchio Brandenburgensis' => 'Christian Markgraf von Brandenburg-Kulmbach',
	'Christian Günther Graf in Schwarzburg und Hohenstein' => 'Christian Günther Graf zu Schwartzburg und Honstein',
	'Christian Wilhelm Brandenburg, Markgraf' => 'Christian Wilhelm Markgraf zu Brandenburg',
	'Christianus Albertus Princeps' => 'Christian Albrecht Herzog von Schleswig-Holstein-Gottorf',
	'Christianus Guilelmus Archiepiscopus Magdeburgensis' => 'Christian Wilhelm Erzbischof von Magdeburg',
	'Christianus Wilhelmus Archiepiscopus Magdeburgensis' => 'Christian Wilhelm Erzbischof von Magdeburg',
	'Christianus Wilhelmus Postulatus Administrator Archiepiscopatus Magdeburgensis Marchio Brandenburgicus' => '', // redundant
	'Christianus Wilhelmus Marggraff zu Brandenburg' => 'Christian Wilhelm Markgraf zu Brandenburg',
	'Christianus Herzog in Schlesien zur Liegnitz und Brieg' => '	Christian Herzog von Schlesien-Liegnitz-Brieg',
	'Christianus Ascanieae, Comes' => 'Christian Fürst von Anhalt-Bernburg',
	'Christianus Comes Ascaniae' => 'Christian Fürst von Anhalt-Bernburg',
	'Christian Anhalt-Bernburg, Fürst' => 'Christian Fürst von Anhalt-Bernburg',
	'Christianus Princeps Anhaldinus' => 'Christian Fürst von Anhalt-Bernburg',
	'Christian Anhalt-Bernburg, Fürst, I.' => 'Christian I., Fürst von Anhalt-Bernburg',
	'Christian I., Anhalt-Bernburg, Fürst' => 'Christian I., Fürst von Anhalt-Bernburg',	
	'Christianus der Eltere Fürst zu Anhalt' => 'Christian I., Fürst von Anhalt-Bernburg',	
	'Clauderus, Gabriel' => 'Clauder, Gabriel',
	'Colbertus, Joannes Baptista' => 'Colbert, Jean Baptiste',
	'Conringius, Hermannus' => 'Conring, Hermann',
	'Croydenus, Thom.' => 'Croyden, Thom.',
	
	'Dietzel, Caspar' => 'Dietzel, Kaspar',
	'Dillenius, Justus Fridericus' => 'Dillenius, Justus Friedrich',
	'Doldius, Leonhardus' => 'Dold, Leonhard',
	'Dornau, Caspar' => 'Dornavius a Dornaw, Caspar',
	'Doude, Arnoldus' => 'Doude, Aernout',	
	'Drexel, Joannes' => 'Drexel, Johannes',
	'DuChesne, Joseph' => 'Du Chesne, Joseph',
	'Duval, Robert' => 'Duval, Robert, Vallensis',
	
	'Eberhardus Hertzogen zu Würtemberg und Teck' => 'Eberhard Herzog von Württemberg',
	'Eberhardus Herzog zu Würtemberg und Teck' => 'Eberhard Herzog von Württemberg',
	'Ellenberger, Henricus' => 'Ellenberger, Heinrich',
	'Ellenbergerus, Henricus' => 'Ellenberger, Heinrich',
	'Enoc, Pierre' => 'Enoch, Pierre',
	'Enochus, Petrus' => 'Enoch, Pierre',
	'Endter, Iohann Andreas' => 'Endter, Johann Andreas',
	'Endter, Johan-Andreas' => 'Endter, Johann Andreas',
	'Ernest Köln, Erzbischof' => 'Ernestus Erzbischof und Kurfürst zu Köln',
	'Ernestus Archiepiscopus Coloniensis' => 'Ernestus Erzbischof und Kurfürst zu Köln',
	'Ernst Köln, Erzbischof' => 'Ernestus Erzbischof und Kurfürst zu Köln',
	'Ernestus Comes Holsatiae' => 'Ernst Graf von Holstein-Schaumburg',
	'Ernestus Holsatia-Schaumburg-Sternberk, Comes' => 'Ernst Graf von Holstein-Schaumburg',	
	'Ernst Holstein-Schaumburg, Graf' => 'Ernst Graf von Holstein-Schaumburg',	
	'Ernestus Comes de Oetingen, Dominus in Wallerstain' => 'Oettingen-Wallerstein, Ernst', //Person ohne Titel?
	'Ernst August Hannover, Kurfürst, I.' => 'Ernst August I., Hannover, Kurfürst', // Umleitung auf GND
	
	'Faber, Georgius' => 'Faber, Georg',
	'Faber, Petrus Johannes' => 'Fabre, Pierre Jean',
	'Fabricius, Johan. Georgius' => 'Fabricius, Johann Georg',
	'Fabricius, Iohannes Georgius' => 'Fabricius, Johann Georg',
	'Fachs, Ludovicus Wolffg.' => 'Fachs, Ludwig Wolfgang',
	'Fausius, Johannes Casparus' => 'Fausius, Johann Caspar',
	'Fehr, Joh. Micahel' => 'Fehr, Johann Michael',
	'Ferdinand Deutschland, Kaiser, I.' => 'Ferdinand I, Kaiser des Römisch-deutschen Reichs',
	'Ferdinand Maria Bayern, Kurfürst' => 'Ferdinand Maria Kurfürst von Bayern',	
	'Ferdinandus Maria Dux Bavariae' => 'Ferdinand Maria Kurfürst von Bayern',	
	'Ferdinand Ortenburg, Graf' => 'Ferdinand Graf von Ortenburg',	
	'Ferdinand Römisch-Deutsches Reich, König, IV.' => 'Ferdinand IV., König des Römisch-Deutschen Reichs',	
	'Ferdinand Ungarn, König' => 'Ferdinand König von Ungarn',	
	'Ferdinandus II. Medices Magnus Aetruriae Dux' => 'Ferdinando II., Großherzog der Toskana',	// Umleitung auf GND
	'Ferdinandus Johannes Lichtenstein-Nicolspurg, Princeps' => 'Liechtenstein-Nikolsburg, Ferdinand von',	//Person ohne Titel
	'Ferrarius, Bruder' => 'Ferrarius, Frater',
	'Feyrabendt, Sigmuindt' => 'Feyerabend, Sigmund',
	'Fischer, Joh. Andr.' => 'Fischer, Johann Andreas',
	'Foillet, Jakob' => 'Foillet, Jacob',
	'Forberger, Georgius' => 'Forberger, Georg',
	'Franciscus Albertus Saxoniae Dux' => 'Franz Albrecht Herzog von Sachsen-Lauenburg',
	'Franciscus Carolus Saxoniae Dux' => 'Franz Karl Herzog von Sachsen-Lauenburg',
	'Franciscus Heinricus Saxoniae Dux' => 'Franz Heinrich Herzog von Sachsen-Lauenburg',
	'Franciscus Julius Saxoniae Dux' => 'Franz Julius Herzog von Sachsen-Lauenburg',
	'Franciscus Wilhelmus Postulatus Episcopus Osnaburgensis' => 'Franz Wilhelm Bischof von Osnabrück',
	'Franken-Berg, Abraham vom' => 'Frankenberg, Abraham von',
	'Franckenberg, Abraham vom' => 'Frankenberg, Abraham von',
	'François France, Prince, 1554-1584' => 'Franz Frankreich, Prinz, 1554-1584', //Umleitung auf GND
	'Fridericus Dux Wirtembergicus & Teccensis' => 'Friedrich Herzog von Württemberg',
	'Fridercus Ulricus Dux Brunsvicensis & Lunaeburgensis' => 'Friedrich Ulrich, Herzog von Braunschweig-Wolfenbüttel',
	'Fridericus Ulricus Dux Brunsvicensium ac Lunaeburgensium' => 'Friedrich Ulrich, Herzog von Braunschweig-Wolfenbüttel',
	'Friedrich Ulrich Herzog zu Braunschweig und Lüneburg' => 'Friedrich Ulrich, Herzog von Braunschweig-Wolfenbüttel',
	'Fridericus Dux Saxoniae' => 'Friedrich Herzog von Sachsen',
	'Fridericus Dux Saxoniae, Iuliae, Cliviae Et Montium' => 'Friedrich Herzog von Sachsen',
	'Friedrich Herzog zu Sachsen, Jülich, Cleve und Bergen' => 'Friedrich Herzog von Sachsen',
	'Fridericus Dux Schleswici' => 'Friedrich Herzog von Schleswig-Holstein',
	'Fridericus Dux Wirtembergensis' => 'Friedrich Herzog von Württemberg',
	'Fridericus Dux Wirtembergiae et Tecciae' => 'Friedrich Herzog von Württemberg',
	'Friedrich Württemberg, Herzog, I.' => 'Friedrich Herzog von Württemberg',
	'Fridericus Episcopus Verdensis, Dux Sleswigae, Holsatiae' => 'Friedrich Herzog von Schleswig-Holstein',
	'Fridericus Ludolphus Comes Benthemiae' => 'Friedrich Ludolph Graf zu Bentheim',
	'Fridericus Norwagiae Heres, Sleswigae, Holsatiae Dux' => 'Friedrich König von Dänemark-Norwegen, Herzog von Schleswig-Holstein',
	'Fridericus Ulricus Dux Brunsvicensis & Lunaeburgensis' => 'Friedrich Ulrich Herzog zu Braunschweig-Lüneburg',
	'Fridericus Ulricus Dux Brunsvicensis & Lunaeburgensis' => 'Friedrich Ulrich Herzog zu Braunschweig-Lüneburg',
	'Friedrich Ulrich Braunschweig-Lüneburg, Herzog' => 'Friedrich Ulrich Herzog zu Braunschweig-Lüneburg',
	'Friedrich Ulrich, Herzog von Braunschweig-Wolfenbüttel' => 'Friedrich Ulrich Herzog zu Braunschweig-Lüneburg',
	'Friedrich Pfalz, Kurfürst, IV.' => 'Friedrich IV., Kurfürst von der Pfalz',
	'Friedrich Pfalz, Kurfürst, V.' => 'Friedrich V., Kurfürst von der Pfalz',
	'Friedrich Rhein, Pfalzgraf' => 'Friedrich Pfalzgraf bei Rhein',
	'Friedrich Sachsen-Gotha-Altenburg, Herzog, II.' => 'Friedrich II., Herzog von Sachsen-Gotha-Altenburg',
	'Friedrich Schleswig-Holstein-Gottorf, Herzog, III.' => 'Friedrich III., Herzog von Schleswig-Holstein-Gottorf',
	'Frobenius, Georgius Ludovicus' => 'Frobenius, Georg Ludwig',
	'Fugger, Joannes' => 'Fugger, Johannes',
	'Furck, S.' => 'Furck, Seb.',
	
	'Gabler, Johan' => 'Gabler, Johann',
	'Gentersbergerus, Samuel' => 'Genttersberger, Samuel',
	'Georg Wilhelm Braunschweig-Lüneburg, Herzog' => 'Georg Wilhelm Herzog zu Braunschweig und Lüneburg',
	'Georg Friedrich Baden-Durlach, Markgraf' => 'Georg Friedrich Markgraf von Baden-Durlach',
	'Georgius Abbatius Cantvariensis Episcopus' => 'Abbot, George, Erzbischof von Canterbury',
	'Georgius Hassiae Landgravius' => 'Georg Landgraf von Hessen',
	'Georgius Ludovicus Comes a Schwartzberg' => 'Schwarzenberg, Georg Ludwig von',
	'Gerhard, Joannes' => 'Gerhard, Johann',
	'Goclenius, Rudolphus' => 'Goclenius, Rudolph',
	'Goclenius, Rudolph, der Ältere' => 'Goclenius, Rudolph',
	'Gratarolus, Gulielmus' => 'Grataroli, Guglielmo',
	'Greiff, Sebastianus' => 'Greiff, Sebastian',
	'Guggerus, Joannes Jacobus' => 'Guggerus, Johannes Jacobus',
	'Götze, Thomas Matth.' => 'Götze, Thomas Mattihas',
	'Grosse, Henning, V.' => 'Grosse, Henning',
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
	'Henricus Julius Dux Brunsvicensi ac Lunaeburgensi' => 'Heinrich Julius Herzog zu Braunschweig-Lünbeurg',
	'Heinrich Julius Braunschweig-Wolfenbüttel, Herzog' => 'Heinrich Julius Herzog zu Braunschweig-Lünbeurg',
	'Heinricus Julius Saxoniae Dux' => 'Julius Heinrich Herzog von Sachsen-Lauenburg',
	'Henri III., Frankreich, König' => 'Henri III., König von Frankreich',
	'Henry III., Frankreich & Poloigne, Roy' => 'Henri III., König von Frankreich',
	'Hermann IV., Hessen-Kassel, Landgraf' => 'Hermann IV., Landgraf von Hessen-Kassel',
	'Hermann Köln, Erzbischof, V.' => 'Hermann V., Erzbischof von Köln',
	'Hoffmannus, Joannes' => 'Hoffmann, Johann',
	'Holland, Johann Isaac' => 'Hollandus, Johan Isaac',
	'Horstius, Gregorius' => 'Horst, Gregor',
	'Hortulanus' => 'Hortulanus Philosophus',
	'Hubnerus, Bartolomaeus' => 'Hubner, Bartolomäus',
	
	'Jacobi, Johannes' => 'Jacobi, Johann',
	'Jakob VI., Schottland, König' => 'James I., König von Schottland',
	'Jennis, Lukas' => 'Jennis, Lucas',
	'Jennisius, Lucas' => 'Jennis, Lucas',
	'Joachim Ernst Brandenburg-Ansbach, Markgraf' => 'Joachim Ernst Markgraf von Brandenburg-Ansbach',
	'Joachim Friderich Brandenburg, Kurfürst' => 'Joachim Friedrich Kurfürst zu Brandenburg',
	'Joachim Friderich Markgraf zu Brandenburg' => 'Joachim Friedrich Kurfürst zu Brandenburg',
	'Joachim Friedrich Brandenburg, Kurfürst' => 'Joachim Friedrich Kurfürst zu Brandenburg',
	'Joachim Friedrich Markgraf zu Brandenburg' => 'Joachim Friedrich Kurfürst zu Brandenburg',
	'Joachimus Sigismundus Dux Saxoniae, Angriae & Westphaliae' => 'Joachim Sigismund Herzog zu Sachsen',
	'Joachimus Sigismundus Saxoniae Dux' => 'Joachim Sigismund Herzog zu Sachsen',
	'Joannes Albertus Comes de Oetingen, Dominus in Wallerstain' => 'Johann Albert Graf zu Oettingen Wallenstein',
	'Joannes Electus Episcopus Lybecensis Heres Norwegiae Dux Holsatiae Stormariae & Dithmarsiae' => 'Johann Bischof zu Lübeck',
	'Joannes Georgius Senior Lib. Baro in Froburg' => 'Johann Georg d. Ä. von Froburg',
	'Joannes Philippus Archiepiscopus Moguntinus' => 'Johann Philip Erzbischof von Mainz',
	'Jochim Ernst Erbe zu Norwegen, Herzog zu Schleswig-Holstein-Stormarn' => 'Jochim Ernst Herzog zu Schleswig-Holstein-Stormarn',
	'Jochim Ernst Schleswig Holstein, Herzog' => 'Jochim Ernst Herzog zu Schleswig-Holstein-Stormarn',
	'Joachim Ernst Schleswig Holstein, Herzog' => 'Jochim Ernst Herzog zu Schleswig-Holstein-Stormarn',
	'Johann Ernst I., Sachsen-Weimar, Herzog.' => 'Johann Ernst I., Herzog von Sachsen-Weimar',
	'Johann Ernst Sachsen-Eisenach, Herzog' => 'Johann Ernst, Herzog von Sachsen-Eisenach',
	'Johann Friedrich Braunschweig-Lüneburg, Herzog' => 'Johann Friedrich Herzog zu Braunschweig-Lüneburg',
	'Johann II., Pfalz-Zweibrücken, Pfalzgraf' => 'Johann II., Pfalzgraf von Pfalz-Zweibrücken',
	'Johann Philipp Herzog zu Sachsen, Jülich, Cleve und Bergen' => 'Johann Philipp Herzog von Sachsen-Altenburg',
	'Johann Philipp Mainz, Erzbischof' => 'Johann Philipp Erzbischof von Mainz',
	'Johann Wilhelm Herzog zu Sachsen, Jülich, Cleve und Bergen' => 'Johann Wilhelm Herzog zu Sachsen, Jülich, Cleve und Berg', //unklar ob Weimar, Gotha oder Eisenach
	'Johan Philipp Erzbischof zu Mainz' => 'Johann Philipp Mainz, Erzbischof',
	'Johan. Georg Saxonia, Dux' => 'Johann Georg I., Anhalt-Dessau, Fürst',
	'Johann Casimir Herzog zu Sachsen' => 'Johann Casimir Herzog zu Sachsen, Jülich, Cleve und Bergen',
	'Johann Casimirus Hertzog zu Sachsen, Gülich, Cleve und Bergk' => 'Johann Casimir Herzog zu Sachsen, Jülich, Cleve und Bergen',
	'Johann Casimir Sachsen-Coburg, Herzog' => 'Johann Casimir Herzog zu Sachsen, Jülich, Cleve und Bergen',
	'Johann Ernst Sachsen-Weimar, Herzog, I.' => 'Johann Ernst I., Sachsen-Weimar, Herzog.',
	'Johann Friderich Herzog zu Braunschweig und Lüneburg' => 'Johann Friedrich Braunschweig-Lüneburg, Herzog',
	'Johann Georg II., Sachsen, Kurfürst' => 'Johann Georg II., Kurfürst von Sachsen',
	'Johann Georg Sachsen, Kurfürst, I.' => 'Johann Georg I., Kurfürst von Sachsen',
	'Johann Georg der Andere Herzog zu Sachsen, Jülich, Cleve und Berg' => 'Johann Georg I., Kurfürst von Sachsen',
	'Johannes Georgius Dux Saxoniae, Juliae, Cliviae et Montiumum' => 'Johann Georg I., Kurfürst von Sachsen',
	'Johann Pfalz-Zweibrücken, Pfalzgraf, II.' => 'Johann II., Pfalz-Zweibrücken, Pfalzgraf',
	'Johannes Albertus Dux Megapolensius' => 'Johann Albrecht Herzog zu Mecklenburg',
	'Johannes Fridericus Dux Wirtenbergicus & Teccius' => 'Johann Friedrich, Herzog von Württemberg',
	'Johannes de Rupescissa' => 'Johannes de Rupescissa, OFM',
	'Johannßen Pfalzgraf bei Rhein, In Bayern Herzog' => '', //entfällt
	
	'Karl I., Braunschweig-Lüneburg, Herzog' => 'Karl I., Herzog von Braunschweig-Lüneburg',
	'Karl Wilhelm Friedrich Brandenburg-Ansbach, Markgraf' => 'Karl Wilhelm Friedrich Markgraf von Brandenburg-Ansbach',
	'Karpffen, Eberhard von' => 'Karpffen, Eberhardt von',
	'Katarine Markgräfin zu Brandenburg' => 'Katharine Kurfürstin von Brandenburg',
	'Keerwolff, Lorenz' => 'Keerwolf, Laurens',
	'Kegelerus, Johannes' => 'Kegler, Johannes',
	'Kirchner, Herman' => 'Kirchner, Hermann',
	'Kirchnerus, Hermannus' => 'Kirchner, Hermann',
	'Kirstenius, Michael' => 'Kirsten, Michael',
	'Klein, Christianus' => 'Klein, Christian',
	'Kretschmar, Barthol.' => 'Kretschmar, Bartholomäus',
	'Kunckel, Johann' => 'Kunckel, Johannes',
	'Kunigunda Juliana Hassiae Landgravia' => 'Kunigunde Juliane Landgräfin von Hessen',
	
	'La Fin, Jacobus de' => 'La Fin, Jaques de',
	'La Fin, Jacques de' => 'La Fin, Jaques de',
	'Langelottus, Joel' => 'Langellott, Joel',
	'Langus, Johannes' => 'Lange, Johann',
	'Lauremberg, Petrus' => 'Lauremberg, Peter',
	'Laurembergius, Petrus' => 'Lauremberg, Peter',
	'Leichnerus, E.' => 'Leichnerus, Eccardus',
	'Leiden' => '',
	'Leopold I., Römisch-Deutsches Reich, Kaiser' => 'Leopold I., Kaiser des Heiligen Römischen Reichs',
	'Leopold Römisch-Deutsches Reich, Kaiser, I.' => 'Leopold I., Kaiser des Heiligen Römischen Reichs',
	'Leopold Wilhelm Österreich, Erzherzog' => 'Leopold Wilhelm Erzherzog von Österreich',
	'Leupold, J.' => 'Leupold, Jakob',
	'Linck, Paulus' => 'Linck, Paul',
	'Ludovicus Herzog in Schlesien zur Liegnitz und Brieg' => 'Ludwig Herzog in Schlesien zur Liegnitz und Brieg',
	'Ludovicus Wilhelmus Anhalt, Fürst' => 'Ludwig Wilhelm Fürst zu Anhalt',
	'Ludwig Anhalt-Köthen, Fürst' => 'Ludwig Fürst zu  Anhalt-Köthen',
	'Ludwig Fürst zu Anhalt' => 'Ludwig Fürst zu Anhalt-Köthen',
	'Ludwig Fürst zu Anhalt' => 'Ludwig Fürst zu Anhalt-Köthen',
	'Ludwig I., Anhalt-Köthen, Fürst' => 'Ludwig, Fürst zu  Anhalt-Köthen',
	'London' => '', //entfällt
	'Ludwig Leiningen, Graf' => 'Ludwig Graf zu Leiningen',
	'Ludwig VI. von der Pfalz' => 'Ludwig VI., Kurfürst von der Pfalz',
	
	'Maierus, Michael' => 'Maier, Michael',
	'Manßfeldt, Christian Friderich zu' => 'Christian Friedrich Graf zu Mansfeld',
	'Manßfeldt, Hanß Georg Graf zu' => 'Hans Georg Graf zu Mansfeld',
	'Manßfeldt, Joachim Friedrich Graf zu' => 'Joachim Friedrich Graf zu Mansfeld',
	'Manßfeldt, Philipp Graf zu' => 'Philipp Graf zu Mansfeld',
	'Mauricius Dux Saxoniae' => 'Moritz Kurfürst von Sachsen',
	'Mauritius Auracium, Princeps' => 'Maurits van Oranje-Nassau',
	'Mauritius Hassiae Landgravius' => 'Moritz Landgraf zu Hessen-Kassel',
	'Mauritius Landgravius Hassiae' => 'Moritz Landgraf zu Hessen-Kassel',
	'Moritz Hessen-Kassel, Landgraf' => 'Moritz Landgraf zu Hessen-Kassel',
	'Moritz Hessen-Kassel, Landgraf, 1572-1632' => 'Moritz Landgraf zu Hessen-Kassel',
	'Moritz Hessen-Kassel, Landgraf, 1614-1633' => 'Moritz Landgraf zu Hessen-Kassel',
	'Moritz Landgraf von Hessen' => 'Moritz Landgraf zu Hessen-Kassel',
	'Moritz Landgraf zu Hessen' => 'Moritz Landgraf zu Hessen-Kassel',
	'Maximilian Österreich, Erzherzog, 1558-1618' => 'Maximilian Erzherzog von Österreich',
	'Mayer uff Plaussigk, Friederich' => 'Mayer auf Plaussigk, Friederich',
	'Medici, Cosmo de' => 'Medici, Cosimo de',
	'Medici, Franciscus' => 'Medici, Francesco de',
	'Meibomius, Henricus' => 'Meibom, Heinrich',
	'Meibomius, Johan. Heinricus' => 'Meibom, Johann Heinrich',
	'Meibomius, Johannes Heinricus' => 'Meibom, Johann Heinrich',
	'Meisnerus a Commothau, Daniel' => 'Meisnerus, Daniel',
	'Mentzeliuzs, Christianus' => 'Menzelius, Christianus',
	'Merian, M.' => 'Merian, Matthaeus, der Ältere',
	'Merian, Matthaeus' => 'Merian, Matthaeus, der Ältere',
	'Meyer, Heinricus' => 'Meyer, Heinrich',
	'Michael, Joannes' => 'Michael, Johannes',
	'Michaelis, Johannes' => 'Michaelis, Johann',
	'Moltherus, Georgius' => 'Molther, Georg',
	'Moritz Sachsen, Kurfürst' => 'Moritz Kurfürst von Sachsen',
	'Moßbach uff Gönderitz, Ernestus' => 'Moßbach auf Gönderitz, Ernestus',
	'Moßbacher, Ernst' => 'Moßbach, Ernestus',
	'Müller, Jacob' => 'Müller, Jakob',
	'Müllerus, Philippus' => 'Müller, Philipp',
	
	'Naumann, Johann' => 'Naumann, Johann, der Jüngere',
	'Nessenthaler, E.' => 'Nessenthaler, Elias',
	'Neucrantz, Johannes' => 'Neunkrantz, Johann',
	'Nicolaus Flamellus' => 'N. Flamel',
	'Flamellius, Nicolai' => 'N. Flamel',
	'Nollius, Henricus' => 'Nolle, Heinrich',
	
	'Ohm, Laurent.' => 'Ohm, Laurentius',
	'Olearius, Joannes' => 'Olearius, Johannes',
	'Opitius, Martinus' => 'Opitz, Martin',
	'Orthelius, Andreas' => 'Ortel, Andreas',
	
	'Paullus van der doort' => 'Paulus van der Doort',
	'Perna, Petrus' => 'Perna, Peter',
	'Petraeus, Heinricus' => 'Petraeus, Henricus',
	'Petri ab Hartenfelß, Georgius Christophorus' => 'Petri von Hartenfels, Georg Christoph',
	'Petri, Georg. Christoph.' => 'Petri von Hartenfels, Georg Christoph',
	'Petri, Georgius Christophorus' => 'Petri von Hartenfels, Georg Christoph',
	'Philipp Hessen-Kassel, Landgraf, 1604-1626' => 'Philipp Landgraf von Hessen-Kassel',
	'Philippus Sigismundus Dux Brunsvicensis & Lunaeburgensis' => 'Philipp Sigismund Herzog von Braunschweig-Wolfenbüttel',
	'Philipp Pommern-Stettin, Herzog, II.' => 'Philipp II., Herzog zu Pommern-Stettin',
	'Philippus Reinhardus Comes Hanoviensis, Rineccensis et Bipontinus' => 'Philipp Reinhard Graf von Hanau-Münzenberg',
	'Philipp Pommern-Stettin, Herzog, II.' => 'Philipp II., Herzog von Pommern-Stettin',
	'Pico della Mirandola, Giovanni' => 'Pico della Mirandola, Giovanni Francesco',
	'Plener, Joh. Adamus' => 'Plener, Johann Adam',
	'Polemann, Joachimus' => 'Polemann, Joachim',
	'Praetorius, Martinus' => 'Praetorius, Martin',
	
	'Rappoltus, Frider.' => 'Rappoltus, Fridericus',
	'Remmelinus, Johannes' => 'Remmelin, Johann',
	'Renneman, Henningus' => 'Rennemann, Henning',
	'Reusnerus, Hieronymus' => 'Reusner, Hieronymus',
	'Rorscheid, Marcus' => 'Rorscheidt, Marcus',
	'Rudolf August Braunschweig-Lüneburg, Herzog' => 'Rudolf August Herzog von Braunschweig-Lüneburg',
	'Rudolf August Herzog zu Braunschweig und Lüneburg' => 'Rudolf August Herzog von Braunschweig-Lüneburg',
	'Rudolf Römisch-Deutsches Reich, Kaiser, II.' => 'Rudolf II., Kaiser des Heiligen Römischen Reichs',
	'Rudolphus Maximilianus Saxoniae Dux' => 'Rudolf Maximilian Herzog von Sachsen-Lauenburg',
	'Rulandus, Martinus' => 'Ruland, Martin',
	'Rüdinger, Johannes' => 'Rüdinger, Johann',
	
	'Sachs, Philippus Jacobus' => 'Sachs von Lewenheimb, Philipp Jacob',
	'Sachse de Lewenheimb, Philipp Jakob' => 'Sachs von Lewenheimb, Philipp Jacob',
	'Sayn-Wittgenstein, Anna Magdalena zu' => 'Sayn-Wittgenstein, Anna Magdalena Gräfin zu',
	'Schallerus, Wolfgangus' => 'Schaller, Wolfgang',
	'Scharffius, Davidus Jonathanus' => 'Scharffius, David Jonathan',
	'Schefferus, Wilhelmus Ernestus' => 'Scheffer, Wilhelm Ernst',
	'Schennis, Heinricus a' => 'Schennis, Heinrich von',
	'Schiller, Iulius' => 'Schiller, Julius',
	'Schnizerus, Sigismundus' => 'Schnitzer, Sigismund',
	'Scholzius, Laurentius' => 'Scholz, Lorenz',
	'Schonberger, Ulricus' => 'Schönberger, Ulrich',
	'Schoneberger, Ulricus' => 'Schönberger, Ulrich',
	'Schonerus, Johannes' => 'Schoner, Johannes',
	'Schroeckius, Lucas' => 'Schroeck, Lucas',
	'Schröckius, Lucas' => 'Schroeck, Lucas',
	'Schröcklius, Lucas' => 'Schroeck, Lucas',
	'Schröderus, Ioannes' => 'Schröder, Johann',
	'Schulz, Gottfried' => 'Schultze, Gottfried',
	'Schurtz, Joan-Christophorus a' => 'Schurtz, Johann Christoph von',
	'Schönborn, Philips Ehrwein von' => 'Schönborn, Philip Ehrwein von',
	'Schwarzenburg und Hohnstein, Albertus Günther Graf zu' => 'Albrecht Günther Graf zu Schwarzenberg und Hohnstein',
	'Schwarzenburg und Hohnstein, Corolus Günther Graf zu' => 'Karl Günther Graf zu Schwarzenberg und Hohnstein',
	'Schwarzenburg und Hohnstein, Rudolphus Günther Graf zu' => 'Rudolph Günther Graf zu Schwarzenberg und Hohnstein',
	'Seebach, Johannes Baptista von' => 'Seebach, Johann Baptist von',
	'Sitzmanus, Theodorus' => 'Sitzmannus, Theodorus',
	'Sophia Braunschweig-Lüneburg, Herzogin' => 'Sophia Herzogin von Braunschweig-Lüneburg',
	'Sperlingk, Paulus' => 'Sperling, Paulus',
	'Speyser, Johanguntherus' => 'Speyser, Johann Gunther',
	'Stockman, Joachimus' => 'Stockman, Joachim',
	'Stockmannus Joachimus' => 'Stockman, Joachim',
	'Stockmannus, Joachimus' => 'Stockman, Joachim',
	'Stolberg, Christophorus Guilhelmus Comes in' => 'Christoph Wilhelm Graf zu Stolberg',
	'Stolberg, Christophorus Ludovicus Comes in' => 'Christoph Ludwig Graf zu Stolberg',
	'Stolberg, Henrich Graf zu' => 'Heinrich Graf zu Stolberg',
	'Stolberg, Henricus Ernestus zu' => 'Heinrich Ernst Graf zu Stolberg',
	'Stolberg, Johannes Martinus Comes in' => 'Johann Martin Graf zu Stolberg',
	'Stolberg, Ludwig Georg zu' => 'Ludwig Georg Graf zu Stolberg',
	'Stolbergk, Ludwig Georg zu' => 'Ludwig Georg Graf zu Stolberg',
	'Stolcius de Stolcenberg, Daniel' => 'Stoltzius von Stoltzenberg, Daniel ',
	'Sybelist, Wendelinus' => 'Sybelista, Wendelin',
	
	'Tackius, Joannes' => 'Tacke, Johann',
	'Tampach, Gottfried' => 'Tambach, Gottfried',
	'Tanckius, Joachimus' => 'Tancke, Joachim',
	'Tanckius, Johannes' => 'Tancke, Johannes',
	'Thalhauser, Wolffgang' => 'Thalhauser, Wolfgang',
	'Theodoricus, Georgius' => 'Theodorus, Georgius',
	'Tyrrel, E.' => 'Tyrell, E.',
	
	'Ursula Herzogin zu Wirttemberg und Teckh' => '	Ursula Herzogin zu Württemberg-Teck',
	'Ursula Herzogin zu Würtemberg und Teck' => 'Ursula Herzogin zu Württemberg-Teck',
	
	'Verdris, Johannes Melchior' => 'Verdries, Johann Melchior',
	'Volckamerus, Joh. Georgius' => 'Volckamer, Johann Georg',
	'Volckkamerus, Iohannes Georgius' => 'Volckamer, Johann Georg',
	
	'Waldeck, Christian von' => 'Waldeck, Christian zu',
	'Waldeck, Walrad von' => 'Waldeck, Walrad zu',
	'Waldeck, Georg Fridrich zu' => 'Waldeck, Georg Friedrich zu',
	'Wedelius, G. W.' => 'Wedel, Georg Wolfgang',
	'Wedelius, Georg. Wolffgangus' => 'Wedel, Georg Wolfgang',
	'Werdenhagen, Johan. Angelius' => 'Werdenhagen, Johann Angelius von',
	'Westhovius a Westhofen, Willichius' => 'Westhov, Willich',
	'Westonia Angla, Elisabetha Johanna' => 'Weston, Elizabeth Johanna',
	'Westonia, Elisabetha Johanna' => 'Weston, Elizabeth Johanna',
	'Westonia, Elizabetha Johanna' => 'Weston, Elizabeth Johanna',
	'Weyler uff Liechtenberg, Dietrich von und zu' => 'Weyler, Dietrich von und zu',
	'Wichman, Jochim' => 'Wichmann, Joachim',
	'Wilhelm Hessen, Landgraf' => 'Wilhelm Landgraf von Hessen-Kassel',
	'Wilhelmus Hassiae Landgravius' => 'Wilhelm Landgraf von Hessen-Kassel',
	'Wilhelm Sachsen-Weimar, Herzog, IV.' => 'Wilhelm IV., Herzog von Sachsen-Weimar',
	'Wilhelm V., Hessen-Kassel, Landgraf' => 'Wilhelm V., Landgraf von Hessen-Kassel',
	'Wolffard, Marcus' => 'Wolfhard, Marcus',
	'Wolffhard, Marcus' => 'Wolfhard, Marcus',
	'Wust, Balthasar Christoph' => 'Wust, Balthasar Christoph, der Ältere',
	'Wächtler, Caspar' => 'Wächtler, Kaspar',
	'Zvingerus, Theodorus' => 'Zwinger, Theodor',
	'Zwingerus, Jacobus' => 'Zwinger, Jakob'
);

$amendmentsGND = array(
	'1042346275' => array('sortiername' => ''), //Helwing, Akademische Verlagsbuchhandlung
	'118683969' => array('sortiername' => 'André Hercule Cardinal de Fleury'),
	'120530791' => array('sortiername' => 'Charles III. de Croÿ'),
	'118557203' => array('sortiername' => 'Jean de Meung'),
	'118577700' => array('sortiername' => 'Margarete Königin von Frankreich'),
	'118637649' => array('sortiername' => 'Albertus Magnus'),
	'100942040' => array('sortiername' => 'Del Garbo, Tommaso'),
	'104066822' => array('sortiername' => 'Guglielmo, Herzog von Mantua'),
	'118768522' => array('sortiername' => 'Vincenzo I., Herzog von Mantua'),
	'12959203X' => array('sortiername' => 'Christoph Bischof von Brixen'),
	'119543052' => array('sortiername' => 'Manderscheidt-Blanckenheim, Jean de'),
	'11859169X' => array('sortiername' => 'Paracelsus'),
	'104081589' => array('sortiername' => 'Portaleone, Avraham ben Da&#x1E7F;id'),
	'129746436' => array('sortiername' => 'Tenison, Thomas'),
	'118507036' => array('sortiername' => 'Basilius, Valentinus'),
	'121292215' => array('sortiername' => 'Zur Lippe-Brake, Amalie'),
	'1008744-8' => array('sortiername' => ''), //Cambridge University Press
	'10211112X' => array('sortiername' => 'Ludwig VI., Kurfürst von der Pfalz'),
	'119184923' => array('sortiername' => 'Flamel, Nicolas'),
	'118738712' => array('sortiername' => 'Ottheinrich Kurfürst von der Pfalz'),
	'11978291X' => array('sortiername' => 'P. Dr.'),
	'6146279-2' => array('sortiername' => 'Löhneysen, Georg Engelhard von, Privatpresse'),
	'119204150' => array('sortiername' => 'Richard Pfalzgraf zu Pfalz-Simmern'),
	'118647571' => array('sortiername' => 'Albrecht V., Herzog von Bayern'),
	'120064847' => array('sortiername' => 'Anna Sophia Kurfürstin von Sachsen'),
	'1037529774' => array('sortiername' => 'Aubry, Johann II.'),
	'12959203X' => array('sortiername' => 'Christoph Bischof von Brixen'),
	'118638521' => array('sortiername' => 'Cosimo I., Großherzog der Toskana'),
	'101508298' => array('sortiername' => 'Elisabeth Dorothea Landgräfin von Hessen-Darmstadt'),
	'101052677' => array('sortiername' => 'Ernst August I., Kurfürst von Hannover'),
	'100455840' => array('sortiername' => 'Ernst Ludwig Landgraf von Hessen-Darmstadt'),
	'118532510' => array('sortiername' => 'Ferdinand II., Kaiser des Heiligen Römischen Reichs'),
	'119504707' => array('sortiername' => 'Ferdinando II., Großherzog der Toskana'),
	'118532529' => array('sortiername' => 'Ferdinand III., Kaiser des Heiligen Römischen Reichs'),
	'118492887' => array('sortiername' => 'Franz Prinz von Frankreich'),
	'11853596X' => array('sortiername' => 'Friedrich Wilhelm, Kurfürst von Brandenburg'),
	'118535749' => array('sortiername' => 'Friedrich II., König von Preußen'),
	'118639889' => array('sortiername' => 'James I., König von England'),
	'104173327' => array('sortiername' => 'Johann Georg I., Fürst von Anhalt-Dessau'),
	'124700470' => array('sortiername' => 'Ludwig Rudolf Herzog zu Braunschweig-Lüneburg'),
	'11857938X' => array('sortiername' => 'Maximilian II., Kaiser des Heiligen Römischen Reichs'),
	'115710264' => array('sortiername' => 'Rudolf Fürst von Anhalt-Zerbst'),
	'118768522' => array('sortiername' => 'Vincenzo I., Herzog von Mantua'),
	'118643355' => array('sortiername' => 'Wilhelm III. von Oranien-Nassau'),
	'1037525493' => array('sortiername' => 'Bellère, Balthazar', 'nachname' => 'Bellère')
);


?>
