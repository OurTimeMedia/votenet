<?php	
require_once 'include/general_includes.php';
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$objEncDec = new encdec();
$objpaging = new paging();
$objState = new state();

$rid = 0;

if (isset($_REQUEST['rid']) && trim($_REQUEST['rid'])!="")
{
	$rid = $objEncDec->decrypt($_REQUEST['rid']);	 
}

if (!($cmn->isRecordExistsReport("rpt_registration", "rpt_reg_id", $rid, "")))
	$msg->sendMsg("registrants_list.php","",46);
	
$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
?>
<div class="content_mn">
	<div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft" id="pdfgenerationtitle">Generating your Registration Form.  This may take a few seconds.</div>
                  <div class="fright">&nbsp;</div>
                </div>
              </div>
            </div>
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
								   <div style="width:100%; text-align:center; height:100px;" id="pdfgeneration">
								   <img src="../../design_templates/template1/images/please_wait.gif" border="0" style="padding-top:40px;">		   
							    </div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
 	</div>
</div>
<script type="text/javascript">
<?php if(isset($_REQUEST['from']) && $_REQUEST['from'] == "list"){ ?>
function redirectPage()
{
	location.href = "registrants_list.php";
}
<?php } else { ?>
function redirectPage()
{
	location.href = "registrants_detail.php?rid=<?php echo $_REQUEST['rid'];?>";
}
<?php } ?>
function downloadPDF(rand)
{
	document.getElementById('pdfgenerationtitle').innerHTML = "Download National Voter Registration Form";
	
	document.getElementById('pdfgeneration').innerHTML = "<a href='pdfdownload.php?rand="+rand+"' target='_blank' onclick='redirectPage();'><img src='<?php echo SERVER_CLIENT_HOST?>images/download-btn-only.jpg' border='0'></a>";
}
</script>
<iframe id="pdfdownload" src="pdfcreation.php?rid=<?php echo $objEncDec->encrypt($rid);?>" border="0" style="border:none;"></iframe>
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>