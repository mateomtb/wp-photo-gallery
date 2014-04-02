
<?php

// Load the XML source
$xml = new DOMDocument;
//$xml->load('collection.xml');
$xml->load('article.xml');

$xsl = new DOMDocument;
//$xsl->load('collection.xslt');
$xsl->load('article.xslt');

// Configure the transformer
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // attach the xsl rules

echo $proc->transformToXML($xml);

?>
