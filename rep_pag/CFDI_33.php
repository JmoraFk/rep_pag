<?php

satxmlsv33(false, "", "", "");

function satxmlsv33($arr, $edidata=false, $dir="", $nodo="", $addenda=""){
	global $xml, $cadena_original, $sello, $texto, $ret;
	error_reporting(E_ALL & ~(E_WARNING | E_NOTICE));
	satxmlsv33_genera_xml($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_genera_cadena_original();
	satxmlsv33_sello($arr);
	$ret = satxmlsv33_termina($arr, $dir);
	return $ret;
}

function satxmlsv33_genera_xml($arr, $edidata, $dir, $nodo, $addenda){
	global $xml, $ret;
	$xml = new DOMDocument("1.0", "UTF-8");
	satxmlsv33_generales($arr, $edidata, $dir, $nodo, $addenda);
	santxmlv33_relacionados($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_emisor($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_receptor($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_conceptos($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_impuestos($arr, $edidata, $dir, $nodo, $addenda);
}

function satxmlv33_generales($arr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$root = $xml->createElement("cfdi:Comprobante");
	$root = $xml->appendChild($root);

	satxmlsv33_cargaAtt($root, array(
		"xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/3",
		"xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
		"xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/3  http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd"
	));

	satxmlsv33_cargaAtt($root, array(
		"Version"=>"3.3",
		"Serie"=>"A",
		"Folio"=>"167ABC",
		"Fecha"=>date(Y-m-d). "T" .date("H:i:s"),
		"Sello"=>"@",
		"NoCertificado"=>"30001000000400002434",
		"Certificado"=>"@",
		"SubTotal"=>"22500.00",
		"Moneda"=>"MXN",
		"TipoCambio"=>"1",
		"Total"=>"3599.99",
		"TipoDeComprobante"=>"I",
		"FormaPago"=>"01",
		"MetodoPago"=>"PUE",
		"CondicionesDePago"=>"CONDICIONES",
		"Descuentos"=>"22500.00",
		"LugarExpedicion"=>"45079",
	));
}

function satxmlsv33_relacionados($arr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$cfdis = $xml-createElement("cfdi:CfdiRelacionados");
	$cfdis = $root->appendChild($cfdis);
	satxmlsv33_cargaAtt($cfdis, array("TipoRelacion"=>"01"));
	$cfdi = $xml->createElement("cfdi:Relacionado");
	$cfdi = $cfdis-ZappendChild($cfdi);
	satxmlsv33_cargaAtt($cfdi, array("UUID"=>""));
}

function satxmlsv33_emisor($arr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$emisor = $xml->createElement("cfdi:Emisor");
	$emisor = $root->appendChild($emisor);
	satxmlsv33_cargaAtt($emisor, array("Rfc"=>"EKU9003173C9",
		"Nombre"=>"ASOCIACION DE AGRICULTORES DEL DISTRITO DE RIEGO 004 DN MARTIN",
		"RegimenFiscal"=>"601"
));
}

function satxmlsv33_receptor($attr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$receptor = $xml->createElement("cfdi:Receptor");
	$receptor = $root->appendChild($receptor);
	satcmlsv33_cargaAtt($receptor, array("Rfc"=>"TUCA2107035N9",
		"Nombre"=>"RAFAEL ALEJANDRO HERNANDEZ PALACIOS",
		"UsoCFDI"=>"G01"
));
}

function satxmlsv33_conceptos($arr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$conceptos = $xml->createElement("cfdi:Conceptos");
	$conceptos = $root->appendChild($conceptos);
	for ($i=1; $i <= sizeof(1) ; $i++) { 
		$concepto = $xml->createElement("cfdi:Conceptos");
		$concepto = $conceptos->appendChild($concepto);
		satxmlsv33_cargaAtt($concepto, array(
			"ClaveProdServ"=>"10101500",
			"ClaveUnidad"=>"F52",
			"NoIdentificacion"=>"00001",
			"Cantidad"=>"1.50",
			"Unidad"=>"TONELADA",
			"Descripcion"=>"ACERO",
			"ValorUnitario"=>"15000.00",
			"Descuento"=>"22500.00",
			"Importe"=>"22500.00"
		));
	$impuestos = $xml->createElement("cfdi:Impuestos");
	$impuestos = $concepto->appendChild($impuestos);
	$traslados = $xml->createElement("cfdi:Traslados");
	$traslados = $impuestos->appendChild($traslados);
	$traslado = $xml-ZcreateElement("cfdi:Traslado");
	$traslado = $traslados->appendChild($traslado);
	satxmlsv33_cargaAtt($traslado, array(
		"Base"=>"22500.00",
		"Impuesto"=>"002",
		"TipoFactor"=>"Tasa",
		"TasaOCuota"=>"0.160000",
		"Importe"=>"3599.99"
	));
	}
}

function satxmlsv33_impuestos($arr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$impuestos = $xml->createElement("cfdi:Impuestos");
	$impuestos = $root->appendChild($impuestos);

	$traslados = $xml->createElement("cfdi:Traslados");
	$traslados = $impuestos->appendChild($traslados);
	$traslado = $xml->createElement("cfdi:Traslado");
	$traslado = $traslados->appendChild($traslado);
	satxmlsv33_cargaAtt($traslado, array("Impuesto"=>"002",
		"TipoFactor"=>"Tasa",
		"TasaOCuota"=>"0.160000",
		"Importe"=>"3599.99"
	));
	$impuestos->setAttribute("TotalImpuestosTrasladados", "3599.99");
}

function satxmlsv33_genera_cadena_original(){
	global $xml, $cadena_original;
	$paso = new DOMDocument;
	$paso->loadXML($xml->saveXML());
	$xsl = new DOMDocument();
	$file = "/home/jmora/Documentos/php_ws/cadenaoriginal_3_3.xslt";
	$xsl->load($file);
	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl);
	$cadena_original = $proc->transformToXML($paso);
	$cadena_original = str_replace(array("\r", "\n"), '', $cadena_orifinal);
}

function satxmlsv33_sella($arr){
	global $root, $cadena_original, $sello;
	$certificado = "30001000000400002434";
	$file = "/home/jmora/Documentos/php_ws/EKU9003173C9.key.pem";
	$pdkeyid = openssl_get_privatekey(file_get_contents($file));
	openssl_sign($cadena_original, $crypttext, $pdkeyid, OPENSSL_ALGO_SHA256);
	openssl_free_key($pkeyid);

	$sello = base64_encode($crypttext);
	$root->setAttribute("Sello", $sello);

	$file = "/home/jmora/Documentos/php_ws/EKU9003173C9.cer.pem";
	$datos = file($file);
	$certificado = "";
	$carga = false;
	for ($i=0; $i <sizeof($datos) ; $i++) { 
		# code..
		if(strstr($datos[$i], "END CERTIFICATE")) $carga=false;
		if($carga) $certificado .= trim($datos[$i]);
		if(strstr($datos[$i], "BEGIN CERTIFICATE")) $carga=true;
	}
	$root->setAttribute("Certificado", $certificado);
}

function satxmlsv33_termina($arr, $dir){
	global $xml, $conn;
	$xml->formatOutput = true;
	$todo = $xml->saveXML();
	//$nufa = $arr['Serie'].$arr['Folio'];
	$paso = $todo;
	file_put_contents("todo.xml", $todo);
	$xml->formatOutput=true;
	$file=$dir.".xml";
	$xml->save($file);

	return $todo;
}

function satxmlsv33_cargaAtt(&$nodo, $attr){
	$quitar = array('sello'=>1, 'noCertificado'=>1, 'certificado'=>1);
	foreach ($attr as $key => $val) {
		# code...
		$val = preg_replace('/\s\s+/',' ', $val);
		$val = trim($val);
		if(strlen($val)>0){
			$val = urf8_encode(str_replace("|", "/", $val));
			$nodo->setAttribute($key, $val);
		}
	}
}

?>