<div class="thesaurus">
<?php
//error_reporting(0);

include('thesaurusTerm.php');

	function makeInternalLink($begriff) {
		$id = thesaurusTerm::makeID($begriff);
		$result = '<a href="thesaurus#'.$id.'">'.$begriff.'</a>';
		return($result);
	}

	$path = 'thesaurus.xml';
	$dom = new DOMDocument;
	$xml = file_get_contents($path);
	$dom->loadXML($xml);
	unset($xml);
	
	$terms = array();
	$xp = new DOMXPath($dom);
	$nodeList = $xp->evaluate('//row');
	foreach($nodeList as $node) {
		$term = new thesaurusTerm($node);
		if($term->begriff) {
			$terms[] = $term;
		}
	}
	unset($dom, $xp, $nodeList);
	
	$numberColumns = 4;
	$sizeColumns = (count($terms) / $numberColumns) + 1;
	$columns = array_chunk($terms, $sizeColumns);
	include('thesaurusToC.phtml');
	echo '<p style="clear:left;">&nbsp;</p>';
	include('thesaurusContent.phtml');
?>
</div>