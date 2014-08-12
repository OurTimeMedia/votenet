<?php
	require_once("include/general_includes.php");
	$cmn->chkSiteOfflineClient();
	
	include "include/header.php";
	include "include/top_index.php";
?>

    <div class="login_cont_mn" align="center">
      <?php if (isset($_SESSION['err']))
		{
			$err=$_SESSION['err'];
			unset($_SESSION['err']);
			unset($_SESSION["is_error"]);
			unset($_SESSION["error_no"]);
		} ?>
      
	  <table cellpadding="0" cellspacing="0" align="center" style="margin-top:100px;">
        <tr valign="top" height="230px;">
          <td class="msg-error-title" align="center">Unauthorized Access! Please use correct URL or contact administrator.</td>
        </tr>
      </table>
	 
    </div>
  </div>
  <?php include "include/footer.php"; ?>
  
</div>
</body>
</html>
