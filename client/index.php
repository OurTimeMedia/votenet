<?php
	require_once("include/general_includes.php");
	$cmn->chkSiteOfflineClient();
	
	if(!isset($_REQUEST['uId']) || $cmn->checkUserAvailableUserName($_REQUEST['uId'])==0)
	{	
		$msg->sendMsg("unauthorize.php","Login",75);
	}
	
	if ($cmn->getSession(ADMIN_USER_ID)!="")
		header("Location:".$cmn->getFirstMenu($cmn->getSession(ADMIN_USER_ID)));

	$main_menu = 0;
	
	$register_button = "javascript: window.location.href='".SERVER_CLIENT_HOST."registeration.php';";
	include "login_db.php";
	
	include "include/header_login.php";
	include "include/top_index.php";
?>
<div class="login_cont_mn">
<?php $msg->displayMsg(); ?>
      <form id="frm" name="frm" method="post">
      <table cellpadding="0" cellspacing="0" align="center" width="486">
        <tr valign="top">
          <td width="426" class="login_bg">
            <table cellpadding="0" cellspacing="0" align="center" width="349">
              <tr><td height="94"></td>
                <td></td>
              </tr>
			  <?PHP if(isset($_SESSION["LOGIN"]) && $_SESSION["LOGIN"]["txtuser_username"]!="")
			  		{
			  ?>
			  <tr>
                <td width="86"><label>Username:</label></td>
                <td class="txtbg"><input type="text" id="txtuser_username" name="txtuser_username"  maxlength="50" value="<?php (isset($_SESSION["LOGIN"]["txtuser_username"])) ? print $_SESSION["LOGIN"]["txtuser_username"] : print "Username"; ?>"/>
                  <script type="text/javascript"> focname=0; focname2=0;</script></td>
              </tr>
              <?PHP }  else { ?>
			  <tr>
                <td width="86"><label>Username:</label></td>
                <td class="txtbg"><input type="text" id="txtuser_username" name="txtuser_username"  maxlength="50" value="<?php (isset($_POST["txtuser_username"])) ? print $_POST["txtuser_username"] : print "Username"; ?>" onfocus= "if(focname == 0 && this.value=='Username') {this.value=''; focname=1; }" onblur="if(!this.value) {this.value='Username'; focname=0;}" />
                  <script type="text/javascript"> focname=0; focname2=0;</script></td>
              </tr>
              <?PHP } ?>
              <tr><td height="15"></td>
                <td></td>
                </tr>
              <?PHP if(isset($_SESSION["LOGIN"]) && $_SESSION["LOGIN"]["txtpassword"]!="")
			  		{
			  ?>
			  <tr>
                <td><label>Password:</label></td>
                <td class="txtbg"><input type="password" id="txtpassword" name="txtpassword" maxlength="50" value="<?php (isset($_SESSION["LOGIN"]["txtpassword"])) ? print "" : print "Password"; ?>" />
                  <script type="text/javascript"> focname2=0; focname3=0;</script></td>
              </tr>                
              <?PHP }  else { ?>
              <tr>
                <td><label>Password:</label></td>
                <td class="txtbg"><input type="password" id="txtpassword" name="txtpassword" maxlength="50" value="<?php (isset($_POST["txtpassword"])) ? print "" : print "Password"; ?>" onfocus= "if(focname2 == 0 && this.value=='Password') {this.value=''; focname=1; }" onblur="if(!this.value) {this.value='Password'; focname=0;}" />
                  <script type="text/javascript"> focname2=0; focname3=0;</script></td>
                </tr>
               <?PHP } ?>
              <tr><td height="23"></td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;
                </td>
                <td>
				<input type="submit" id="btnsubmit" name="btnsubmit" value="" class="login_now_btn" title="Login Now" alt="Login Now"/>
                </td>
              </tr>
              <tr><td height="16"></td>
                <td></td>
              </tr>
              <tr><td class="txt14">&nbsp;</td>
                <td class="txt14">+ <a href="<?PHP echo SERVER_CLIENT_HOST.$_REQUEST['uId']; ?>/forgotpassword.php" title="Forgot your password ?" alt="Forgot your password ?">Forgot password ?</td>
              </tr>
              <tr><td height="30"></td>
                <td></td>
              </tr>              
              </table>
          </td>
        </tr>
      </table>
	  </form>
    </div>
  </div>
  <div class="clear"></div>
</div>
  <?php include "include/footer.php"; ?>
</body>
</html>
