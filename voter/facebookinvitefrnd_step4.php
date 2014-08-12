<?PHP
	require COMMON_CLASS_DIR.'fbsdk3/src/facebook.php';
	require COMMON_CLASS_DIR.'clssocialnetworking.php';
	
	$objsocialnetworking=new socialnetworking();
	$socaildata=$objsocialnetworking->fetchvalues($_SESSION['client_id']);

	// Create our Application instance (replace this with your appId and secret).
	define("FACEBOOK_APP_ID", $socaildata[0]['facebook_appId']);
	define("FACEBOOK_API_KEY", $socaildata[0]['facebook_appId']);
	define("FACEBOOK_SECRET_KEY", $socaildata[0]['facebook_appsecret']);
	define("FACEBOOKAPPLICATION","Election Impact");
	define("DOMAINFORFB","electionimpact.com");

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
		$loginUrl = $facebook->getLoginUrl(	array('scope' =>'publish_stream','display' => 'popup'));
		header("Location: ".$loginUrl);
		exit;
	}
	
?>
<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
	FB.init({
		appId  : '<?php echo FACEBOOK_APP_ID?>',
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml  : true  // parse XFBML
	});
</script>

<fb:serverFbml width="635">
<script type="text/fbml">
	<fb:fbml>

			<fb:is-logged-out>
				<fb:else>
					<fb:request-form content="Join me on <?php echo FACEBOOKAPPLICATION?>! It's the best way to meetup with friends and discover new places. &lt;fb:req-choice url='<?php echo SERVER_HOST;?>' label='Join <?php echo FACEBOOKAPPLICATION?>!' /&gt;" type="<?php echo FACEBOOKAPPLICATION?>" invite="true" method="POST" action="<?php echo SERVER_HOST;?>invitefriend.php">
					<fb:multi-friend-selector import_external_friends="false" showborder="false" cols="5" rows="3" exclude_ids="721781462" actiontext="Invite your friends to <?php echo FACEBOOKAPPLICATION?>."></fb:multi-friend-selector>
					</fb:request-form>
				</fb:else>
			</fb:is-logged-out>

	</fb:fbml>
</script>
</fb:serverFbml>