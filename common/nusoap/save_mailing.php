<?php

require('nusoap.php');

/*
ON ADD:
-------
save
schedule

ON EDIT:
--------
unschedule
delete
save

ON DELETE:
----------
unschedule
delete
*/

$msg = '<strongmail-client username="votenet" password="V039tnet" context="mailing" action="save">
   <mailing file="Trofee001.cfg">
      <config>
         <id>1234</id>
         <message_id>333</message_id>
         <subject>Trofee - StrongMail Test 2</subject>
         <from_name>Nirav Oza</from_name>
         <from_email>nirav@zerozone.com</from_email>
         <reply_email>nirav@outsourcing2india.com</reply_email>
         <bounce_email>nirav@outsourcing2india.com</bounce_email>
         <recipient_parameter>RecipientAddress</recipient_parameter>
         <parameter_separator>::</parameter_separator>
         <rowid_column>RID</rowid_column>
         <header>X-Priority: 3;</header>
         <header>Y-Priority: 88;</header>
         <log_success>0</log_success>
         <log_fail>1</log_fail>
		 <InputHeaderCharset>utf8</InputHeaderCharset>
         <OutputHeaderCharset>gb2312</OutputHeaderCharset>
         <message_format>format_column</message_format>
      </config>

      <database id="1001" format="data">
         <file>Trofee001.db</file>
         <header>RID::RecipientAddress::Name</header>
         <records>
            1::nirav@zerozone.com::Nirav Oza
            2::ozanirav@hotmail.com::Neerav Oza
			3::nirav@outsourcing2india.com::Neerav Oza
         </records>
      </database>
	  
	  <message type="html" format="data">
		<content_type>text/html</content_type>
		<InputCharset>utf8</InputCharset>
		<OutputCharset>gb2312</OutputCharset>
		<encoding> quoted-printable | base64 | 7bit | 8bit </encoding>
		<file>sample001-message.html</file>
		<body><![CDATA[<strong>Hello</strong> ##Name##, you have made it finally!]]></body>
</message>

   </mailing>
</strongmail-client>';


$msg = '<strongmail-client username="votenet" password="V039tnet" context="mailing" action="delete">
<mailing file="/data1/strongmail/strongmail-eas/data/mailings/Trofee001.cfg"></mailing>
</strongmail-client>';

$msg = '<strongmail-client username="votenet" password="V039tnet" context="mailing" action="unschedule">
<mailing file="/data1/strongmail/strongmail-eas/data/mailings/Trofee001.cfg">
<datetime>01/24/11 11:45</datetime>
</mailing>
</strongmail-client>';


$response = strongMail($msg);

print($response);

	/**
	 * handles the response of our SOAP call
	 *
	 */
	function strongMail($msg)
	{
		//  Editable parameters

		$SOAPHOST = "64.58.70.420";

		$serverpath = 'http://'.$SOAPHOST.':9000/SOAP/sm-client';

		$client = new nu_soapclient($serverpath);

		$client->call('execute', array($msg) );
		
		$nu_error = 'OK';

		// Check for a fault
		if ($client->fault) 
		{
			//print 'ONE:';
			$nu_error = 'Error occured while processing your request.';
		} 
		else 
		{
			// Check for errors
			$err = $client->getError();
			if ($err) 
			{
				//print 'TWO:';
				// Display the error
				$nu_error = $err;
			} 
			else 
			{
				// check <error> tag in XML string
				$pos = strpos($client->response, '&lt;error&gt;');
				$pos_end = strpos($client->response, '&lt;/error&gt;');
		
				if ($pos === false) 
				{
					// No Error return
					//print 'THREE:';
					$nu_error = '';
				}
				else
				{
					//print 'FOUR:';
					// StrongMail Server Error
					$nu_error = substr($client->response,$pos+13,$pos_end-$pos-13);
				}
			}
		}
		
		//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		echo '<h2>Response</h2><pre>' . $client->response . '</pre>';
		//echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
		
		return $nu_error;	
		
	}
?>