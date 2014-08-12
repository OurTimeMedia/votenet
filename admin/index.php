<?php
	require_once("include/general_includes.php");
	error_reporting(1);
	if ($cmn->getSession(SYSTEM_ADMIN_USER_ID)!="")
		header("Location:".$cmn->getFirstAdminMenu($cmn->getSession(SYSTEM_ADMIN_USER_ID)));

	$main_menu = 0;
			
	include SERVER_ADMIN_ROOT."login_db.php";
	
	/**
	 * If you want to add any specific js Or css for this particular page please 
	 * add this in array & put that files in particular admin js Or admin css folder
	 * 
	 * i.e. $extraCss = array('extra1.css', 'extra2.css', 'extra3.css');
	 * 		$extraJs = array('extra1.js', 'extra2.js', 'extra3.js');
	 */
	$extraCss = array();
	$extraJs  = array();
	
	$_SESSION["LOGIN"]["txtuser_username"] = htmlspecialchars($cmn->readValue($_SESSION["LOGIN"]["txtuser_username"],''));
	$_SESSION["LOGIN"]["txtpassword"] =  htmlspecialchars($cmn->readValue($_SESSION["LOGIN"]["txtpassword"],''));
	
?>

<?php
	include SERVER_ADMIN_ROOT."include/header.php";
?>

  <div class="login_mn">
    <div class="login_header_mn">
      <div class="login_logo_index">
		<table cellpadding="0" cellspacing="0" align="center" width="100%">
			<tr>
				<td align="center"><a href="<?php echo SERVER_ADMIN_HOST ?>index.php" title="Election Impact System Administrator Panel"><img src="<?php echo SERVER_ADMIN_HOST ?>images/logo.png" alt="Election Impact System Administrator Panel" title="Election Impact System Administrator Panel" /></a>
				</td>	
			</tr>	
		</table>			
	</div>
	</div>
    <div class="login_cont_mn">
    
               <?php $msg->displayMsg(); ?>
    
    <form id="frm" name="frm" method="post">
      <table cellpadding="0" cellspacing="0" align="center" width="486">
      	<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
        <tr valign="top">
          <td width="426" class="login_bg">
            <table cellpadding="0" cellspacing="0" align="center" width="370">
              <tr><td height="30"  colspan="3"></td></tr>
              <tr>
                <td class="txt18blue2" colspan="3" height="94"><strong>Election Impact </strong> System Administrator Log In</td>                
              </tr>
              <tr>
                <td height="12" colspan="3">&nbsp;</td>
              </tr>
              <tr>
              <?PHP if(isset($_SESSION["LOGIN"]) && $_SESSION["LOGIN"]["txtuser_username"]!="")
			  		{
			  ?>
               <td width="86"><label>Username:</label></td> <td class="txtbg"><input type="text" id="txtuser_username" name="txtuser_username"  maxlength="50" value="<?php (isset($_SESSION["LOGIN"]["txtuser_username"])) ? print $_SESSION["LOGIN"]["txtuser_username"] : print "Username"; ?>"/>
                  <script type="text/javascript"> focname=0; focname2=0;</script></td>
               <?PHP }  else { ?>
              <td width="86"><label>Username:</label></td> <td class="txtbg"><input type="text" id="txtuser_username" name="txtuser_username"  maxlength="50" value="Username" onfocus= "if(focname == 0) {this.value=''; focname=1; }" onblur="if(!this.value) {this.value='Username'; focname=0;}" />
                  <script type="text/javascript"> focname=0; focname2=0;</script></td>
               <?PHP } ?>
              </tr>
              <tr>
                <td height="6"></td>
              </tr>
              <tr>
               <?PHP if(isset($_SESSION["LOGIN"]) && $_SESSION["LOGIN"]["txtpassword"]!="")
			  		{
			  ?>
               <td width="86"><label>Password:</label></td><td class="txtbg"><input type="password" id="txtpassword" name="txtpassword" maxlength="50" value="<?php (isset($_SESSION["LOGIN"]["txtpassword"])) ? print "" : print "Password"; ?>" />
                  <script type="text/javascript"> focname2=0; focname3=0;</script></td>
               <?PHP }  else { ?>
             <td width="86"><label>Password:</label></td>  <td class="txtbg"><input type="password" id="txtpassword" name="txtpassword" maxlength="50" value="Password" onfocus= "if(focname2 == 0) {this.value=''; focname=1; }" onblur="if(!this.value) {this.value='Password'; focname=0;}" />
                  <script type="text/javascript"> focname2=0; focname3=0;</script></td>
               <?PHP } ?>
              </tr>
              <tr><td height="12" colspan="3"></td></tr>
              <tr>
			  <td width="86" ><label></label></td>
                <td>
                  <input type="submit" value=""  id="btnsubmit" name="btnsubmit" class="login_now_btn" />
                </td>
              </tr>
              
              <tr><td height="12"  colspan="3"></td></tr>
              <tr><td class="txt14"  colspan="3">&nbsp;</td></tr>
              <tr><td height="46"  colspan="3"></td></tr>              
            </table>          </td>
        </tr>
      </table>
      </form>
    </div>
  </div>

<?php
	include  SERVER_ADMIN_ROOT."include/footer.php";
?>
