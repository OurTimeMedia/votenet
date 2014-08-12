<?PHP 
require_once 'include/general_includes.php';
require_once 'include/facebook-platform/src/facebook.php'; 
  
$objClientAdmin = new client();
$user_id = $cmn->getSession(ADMIN_USER_ID);
$client_id = $objClientAdmin->fieldValue("client_id",$user_id);
 
$objFBClient = new facebookclient();
 
$api_key = '234813906622727';
$api_secret_key = 'e4090273b465dfd939d8a87560b71f65';


$facebook = new Facebook(array(
  'appId'  => $api_key,
  'secret' => $api_secret_key,
));

$fbRequestSucess = 0;
$signed_request = $facebook->getSignedRequest();

if(isset($_REQUEST['tabs_added']))	
{
	if(is_array($_REQUEST['tabs_added']))
	{
		foreach($_REQUEST['tabs_added'] as $takey=>$taval)
		{			
			if($taval == 1)
			{
				$objFBClient->client_id = $client_id;
				$objFBClient->page_id = $takey;
								
				$objFBClient->created_by = $cmn->getSession(ADMIN_USER_ID);
				$objFBClient->updated_by = $cmn->getSession(ADMIN_USER_ID);
				
				$objFBClient->addFacebookInfo();
				
				$fbRequestSucess++;
			}	
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Election Impact</title>
</head>
<body>
<script type="text/javascript">
window.opener.FbResponse('<?php echo $fbRequestSucess;?>');
window.close();
</script>
</body>
</html>