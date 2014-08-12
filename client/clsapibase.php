<?php 
class apibase
{
	var $url = "http://www.electionimpact.com/client/get_data.php";
	var $referer='';
	function get_response($fields_string)
	{
		// Use cURL to get the RSS feed into a PHP string variable.
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_REFERER, $this->referer);//referal URL
		curl_setopt($ch,CURLOPT_URL,$this->url);
		curl_setopt($ch,CURLOPT_POST,count($fields_string));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		$xml = curl_exec($ch);// get api response in xml format
		curl_close($ch);//curl conection close
		//Load XML file
		$response = (array) simplexml_load_string($xml);
		return $response;
	}
}