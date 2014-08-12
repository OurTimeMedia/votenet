<?php
class socialnetworking extends common
{
	var $client_socialnetword_detail_id;
	var $client_id;
	var $facebook_appId;
	var $facebook_appsecret;
	var $twitter_consumer_key;
	var $twitter_consumer_secret;
	
	function fetchvalues($client_id)
	{
		// $sQuery = "SELECT * FROM ".DB_PREFIX."client_socialnetworking_detail  WHERE client_id=".$client_id;
		
		$sQuery = "SELECT * FROM ".DB_PREFIX."client_socialnetworking_detail";
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["client_socialnetword_detail_id"] = $areligibility["client_socialnetword_detail_id"];
			$arrlist[$i]["client_id"] = $areligibility["client_id"];
			$arrlist[$i]["facebook_appId"] = $areligibility["facebook_appId"];
			$arrlist[$i]["facebook_appsecret"] = $areligibility["facebook_appsecret"];
			$arrlist[$i]["twitter_consumer_key"] = $areligibility["twitter_consumer_key"];
			$arrlist[$i]["twitter_consumer_secret"] = $areligibility["twitter_consumer_secret"];
			$i++;
		}
		return $arrlist;
	}
}
?>