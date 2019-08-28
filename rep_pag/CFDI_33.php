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
	$xml = new DOMdocument("1.0","UTF-8");
	satxmlsv33_generales($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_emisor($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_receptor($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_conceptos($arr, $edidata, $dir, $nodo, $addenda);
	satxmlsv33_recep_pag($arr, $edidata, $dir, $nodo);
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
		"NoCertificado"=>no_Certificado(),
		"Certificado"=>"@",
		"SubTotal"=>"0",
		"Moneda"=>"XXX",
		"Total"=>"0",
		"TipoDeComprobante"=>"P",
		"LugarExpedicion"=>"45079",
	));
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

function satxmlsv33_recep_pag($arr, $edidata, $dir, $nodo){
	global $root, $xml;
	$complemento_pag = $xml->createElement("cfdi:Complemento");
	$complemento_pag = $root->appendChild($complemento_pag);
	$pag10_pagos = $xml->createElement("pago10:Pagos");
	$pag10_pagos = $complemento_pag->appendChild($pag10_pagos); 
	satxmlsv33_cargaAtt($pag10_pagos, array(
		"Version"=>"1.0"
	));

	$pag10_pago = $xml->createElement("pago10:Pago");
	$pag10_pago = $pag10_pagos->appendChild($pag10_pago);
	satxmlsv33_cargaAtt($pag10_pago, array(
		//"FechaPago"=>date("Y-m-d")."T".date("H:i:s"),
		"FechaPago"=>"2019-08-26T10:00:00",
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
		"IdDocumento"=>"4DB50C7A-F2BC-465E-B8C6-A86322166D87",
		"TipoCambioDR"=>"18.68",
		"Serie"=>"A4055",
		"Folio"=>"2154",
		"MonedaDR"=>"MXN",
		"MetodoDePagoDR"=>"PPD",
		"NumParcialidad"=>"2",
		"ImpPagado"=>"500.00",
		"ImpSaldoAnt"=>"1500.00",
		"ImpSaldoInsoluto"=>"1000.00"
	));
	
}

function no_Certificado(){
	$cer = "../EKU/EKU9003173C9.cer"; //Ruta del archivo .cer
	$noCertificado = shell_exec("openssl x509 -inform DER -in ". $cer ." -noout -serial");
	$noCertificado = str_replace(' ', ' ', $noCertificado);
	$arr1 = str_split($noCertificado);
	$certificado = '';
	for ($i=7; $i < count($arr1) ; $i++) { 
		# code...
		if($i%2==0){
			$certificado = ($certificado.($arr1[$i]));
		}
	}
	return $certificado;
}

function satxmlsv33_genera_cadena_original(){
	global $xml, $cadena_original;
	$paso = new DOMDocument;
	$paso->loadXML($xml->saveXML());
	$xsl = new DOMDocument();
	$file = "../3.3/cadenaoriginal_3_3.xslt";//Ruta del archivo .xslt
	$xsl->load($file);
	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl);
	$cadena_original = $proc->transformToXML($paso);
	$cadena_original = str_replace(array("\r", "\n"), '', $cadena_original);
}

function satxmlsv33_sello($arr){
	global $root, $cadena_original, $sello;
	$certificado = no_Certificado();
	$file = "../EKU/EKU9003173C9.key.pem";//Ruta del archivo .key en formato .pem
	$pdkeyid = openssl_get_privatekey(file_get_contents($file));
	openssl_sign($cadena_original, $crypttext, $pdkeyid, OPENSSL_ALGO_SHA256);
	openssl_free_key($pdkeyid);

	$sello = base64_encode($crypttext);
	$root->setAttribute("Sello", $sello);
	$file = "../EKU/EKU9003173C9.cer.pem";//CRuta del archivo .cer en formato .pem
	$datos = file($file);
	$certificado = "";
	$carga = false;
	for ($i=0; $i <sizeof($datos) ; $i++) { 
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
	$paso = $todo;
	file_put_contents("Recepcion_Pagos.xml", $todo);//Nombre del archivo xml generado
	$xml->formatOutput=true;
	$file=$dir.".xml";
	$xml->save($file);
	return $todo;
}

function satxmlsv33_cargaAtt(&$nodo, $attr){
	$quitar = array('sello'=>1, 'noCertificado'=>1, 'certificado'=>1);
	foreach ($attr as $key => $val) {
		$val = preg_replace('/\s\s+/',' ', $val);
		$val = trim($val);
		if(strlen($val)>0){
			$val = utf8_encode(str_replace("|", "/", $val));
			$nodo->setAttribute($key, $val);
		}
	}
}

?>