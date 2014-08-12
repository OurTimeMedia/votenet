<?PHP
	require 'fbsdk3/src/facebook.php';
	// Create our Application instance (replace this with your appId and secret).
	define("FACEBOOK_APP_ID", '232801210130203');
	define("FACEBOOK_API_KEY", '232801210130203');
	define("FACEBOOK_SECRET_KEY", 'bf70d0040f6e160124c2b9999ab84905');
	define("FACEBOOK_CANVAS_URL", 'https://apps.facebook.com/aceinfo/');
	define("FACEBOOKAPPLICATION","ACEINFO");
	define("DOMAINFORFB","localhost/");
	$facebook = new Facebook(array(
		'appId' => FACEBOOK_APP_ID,
		'secret' => FACEBOOK_SECRET_KEY,
		'cookie' => true,
		'domain' => DOMAINFORFB
		));
	$uid = $facebook->getUser();
	if($uid)
	{
		try 
		{
			$me = $facebook->api('/me');
			$updated = date("l, F j, Y", strtotime($me['updated_time']));
			//echo "Hello " . $me['name'] . "<br />";
			//echo "You last updated your profile on " . $updated;
		}
		catch (FacebookApiException $e) 
		{
			echo "Error:" . print_r($e, true);
		}
	}
	else
	{
		$loginUrl = $facebook->getLoginUrl(	array('scope' =>'publish_stream'));
		header("Location: ".$loginUrl);
		exit;
	}
	
?>
<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <body>
        <div id="fb-root"></div>
        <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
        <script type="text/javascript">
            FB.init({
                appId  : '<?php echo FACEBOOK_APP_ID?>',
                status : true, // check login status
                cookie : true, // enable cookies to allow the server to access the session
                xfbml  : true  // parse XFBML
            });
        </script>
 
    <fb:serverFbml style="width: 500px;">
        <script type="text/fbml">
            <fb:fbml>
 
                    <fb:is-logged-out>
                        <fb:else>
                            <fb:request-form content="Join me on <?php echo FACEBOOKAPPLICATION?>! It's the best way to meetup with friends and discover new places. &lt;fb:req-choice url='http://localhost/wall/' label='Join <?php echo FACEBOOKAPPLICATION?>!' /&gt;" type="<?php echo FACEBOOKAPPLICATION?>" invite="true" method="POST" action="http://localhost/wall/">
                            <fb:multi-friend-selector import_external_friends="false" showborder="false" cols="5" rows="3" exclude_ids="721781462" actiontext="Invite your friends to <?php echo FACEBOOKAPPLICATION?>."></fb:multi-friend-selector>
                            </fb:request-form>
                        </fb:else>
                    </fb:is-logged-out>
 
            </fb:fbml>
        </script>
    </fb:serverFbml>
</body>
</html>