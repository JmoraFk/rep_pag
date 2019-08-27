<?php

satxmlsv33(false, "", "", "");
print_r("XML creado de manera satisfactoria!!!!\n");

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
	$xml = new DOMdocument("1.0","UTF-8");
	//AQUI SE DA EL ORDEN DE LOS NODOS
	satxmlsv33_generales($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_emisor($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_receptor($arr, $edidata, $dir, $nodo, $addenda);
	//satxmlsv33_relacionados($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_conceptos($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_recep_pag($arr, $edidata, $dir, $nodo, $addenda);
	//satxmlsv33_impuestos($arr, $edidata, $dir, $nodo, $addenda);
}

function satxmlsv33_generales($arr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$root = $xml->createElement("cfdi:Comprobante");
	$root = $xml->appendChild($root);

	satxmlsv33_cargaAtt($root, array(
		"xmlns:cfdi"=>"http://www.sat.gob.mx/cfd/3",
		"xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance",
		"xsi:schemaLocation"=>"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd http://www.sat.gob.mx/Pagos http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos10.xsd",
		"xmlns:pago10"=>"http://www.sat.gob.mx/Pagos"
	));

	satxmlsv33_cargaAtt($root, array(
		"Version"=>"3.3",
		"Serie"=>"A",
		"Folio"=>"167ABC",
		"Fecha"=>date("Y-m-d")."T".date("H:i:s"),
		"Sello"=>"@",
		"NoCertificado"=>"30001000000400002434",
		"Certificado"=>"@",
		"SubTotal"=>"0",
		"Moneda"=>"XXX",
		//"TipoCambio"=>"1",
		"Total"=>"0",
		"TipoDeComprobante"=>"P",
		//"CondicionesDePago"=>"CONDICIONES",
		"LugarExpedicion"=>"45079",
	));
}

function satxmlsv33_relacionados($arr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$cfdis = $xml->createElement("cfdi:CfdiRelacionados");
	$cfdis = $root->appendChild($cfdis);
	satxmlsv33_cargaAtt($cfdis, array(
		"TipoRelacion"=>"01",
	));
	$cfdi = $xml->createElement("cfdi:Relacionado");
	$cfdi = $cfdis->appendChild($cfdi);
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
	satxmlsv33_cargaAtt($receptor, array("Rfc"=>"TUCA2107035N9",
		"Nombre"=>"RAFAEL ALEJANDRO HERNANDEZ PALACIOS",
		"UsoCFDI"=>"P01"
));
}

function satxmlsv33_conceptos($arr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$conceptos = $xml->createElement("cfdi:Conceptos");
	$conceptos = $root->appendChild($conceptos);
	$concepto = $xml->createElement("cfdi:Concepto");
	$concepto = $conceptos->appendChild($concepto);
	satxmlsv33_cargaAtt($concepto, array(
		"ClaveProdServ"=>"84111506",
		"ClaveUnidad"=>"ACT",
		"Cantidad"=>"1",
		"Descripcion"=>"Pago",
		"ValorUnitario"=>"0",
		"Importe"=>"0"
	));
}

function satxmlsv33_recep_pag($arr, $edidata, $dir, $nodo, $addenda){
	global $root, $xml;
	$complemento_pag = $xml->createElement("cfdi:Complemento");
	$complemento_pag = $root->appendChild($complemento_pag);
	$pag10_pagos = $xml->createElement("pago10:Pagos"); //PAsRA CREAR UN NODO EN EL DOCUMENTO ES NECESARIA ESTA LINEA DE CODIGO
	$pag10_pagos = $complemento_pag->appendChild($pag10_pagos); //AÑADE LOS SUBNODOS DEL NODO
	satxmlsv33_cargaAtt($pag10_pagos, array(
		"Version"=>"1.0"
	));

	$pag10_pago = $xml->createElement("pago10:Pago");
	$pag10_pago = $pag10_pagos->appendChild($pag10_pago);
	satxmlsv33_cargaAtt($pag10_pago, array(
		"FechaPago"=>date("Y-m-d")."T".date("H:i:s"),
		"FormaDePagoP"=>"02",
		"MonedaP"=>"USD",
		"TipoCambioP"=>"18.68",
		"Monto"=>"500.00",
		"NumOperacion"=>"01",
		"RfcEmisorCtaOrd"=>"XEXX010101000",
		"NomBancoOrdExt"=>"BANCO",
		"CtaOrdenante"=>"123456789101112131",
		"RfcEmisorCtaBen"=>"MES420823153",
		"CtaBeneficiario"=>"123456789101114558"
	));

	$pag10_docto_rel = $xml->createElement("pago10:DoctoRelacionado");
	$pag10_docto_rel = $pag10_pago->appendChild($pag10_docto_rel);
	satxmlsv33_cargaAtt($pag10_docto_rel, array(
		"IdDocumento"=>"af1362AF-d3f4-ED30-b333-CEF2083FA390",
		"Serie"=>"A4055",
		"Folio"=>"2154",
		"MonedaDR"=>"MXN",
		"TipoCambioDR"=>"18.68",
		"MetodoDePagoDR"=>"PPD",
		"NumParcialidad"=>"2",
		"ImpPagado"=>"500.00",
		"ImpSaldoAnt"=>"1500.00",
		"ImpSaldoInsoluto"=>"1000.00"
	));
	
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
	$file = "/../3.3/cadenaoriginal_3_3.xslt";
	$xsl->load($file);
	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl);
	$cadena_original = $proc->transformToXML($paso);
	print_r($cadena_original);
	$cadena_original = str_replace(array("\r", "\n"), '', $cadena_original);
	//print_r($cadena_original);
}

function satxmlsv33_sello($arr){
	global $root, $cadena_original, $sello;
	$certificado = "30001000000400002434";
	$file = "../EKU/EKU9003173C9.key.pem";
	print_r($cadena_original);
	$pdkeyid = openssl_get_privatekey(file_get_contents($file));
	openssl_sign($cadena_original, $crypttext, $pdkeyid, OPENSSL_ALGO_SHA256);
	openssl_free_key($pdkeyid);

	$sello = base64_encode($crypttext);
	$root->setAttribute("Sello", $sello);
	$file = "../EKU/EKU9003173C9.cer.pem";
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
	//print_r($sello);
}

function satxmlsv33_termina($arr, $dir){
	global $xml, $conn;
	$xml->formatOutput = true;
	$todo = $xml->saveXML();
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
			$val = utf8_encode(str_replace("|", "/", $val));
			$nodo->setAttribute($key, $val);
		}
	}
}

?>