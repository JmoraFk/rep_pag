<?php

	$xml_file = "todo.xml";
	$xsl_file = "../3.3/cadenaoriginal_3_3.xslt";

	$xml = new DOMDocument("1.0", "UTF-8");
	$xml->load($xml_file);

	$xsl = new DOMDocument();
	$xsl->load($xsl_file);

	$proc = new XSLTProcessor;

	$proc->importStyleSheet($xsl);

	$cadenaOriginal = $proc->transformToXML($xml);

	print_r($cadenaOriginal);
?>