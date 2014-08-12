<?php

require('nusoap.php');


//  Editable parameters

$SOAPHOST = "10.11.5.116";

// Donot edit below this line.


$serverpath = 'http://'.$SOAPHOST.':9000/SOAP/sm-client';

$msg = '<strongmail-client username="admin" password="admin" context="mailing" action="start"><mailing file="mailingcfg.sample"></mailing></strongmail-client>';

$s = new nu_soapclient($serverpath);

$s->call('execute', array($msg) );

print 'response : <xmp>'.$s->response.'</xmp>';

?>