<?php
require_once 'include/general_includes.php';
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$objWebsitePages = new website_pages();
$objEncDec = new encdec();

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

if(isset($_GET['flg']) && $_GET['flg']=="delete")
{
	$objWebsitePages->page_id = intval($objEncDec->decrypt($_REQUEST["page_id"]));
	$objWebsitePages->delete();
	
	echo "Delete####";
	$cond_webpage = " AND client_id='".$client_id."' ";
	$arrWebsitePages = $objWebsitePages->fetchAllAsArray("", "", $cond_webpage);
?>
<br />
<table width="95%" align="center" cellpadding="0" cellspacing="0" class="listtab">
<tr>
  <td width="85%" bgcolor="#a6caf4" class="listtab-td"><strong>Page Name</strong></td>
  <td width="15%" bgcolor="#a6caf4" class="sponsors-table-right1"><strong>Action</strong></td>
  </tr>
  <?php if(count($arrWebsitePages) > 0) { 
  foreach($arrWebsitePages as $awpkey=>$awpval ) {
  ?>
  <tr class="row01">
  <td class="listtab-td"><?php echo $awpval['page_name'];?></td>
  <td class="sponsors-table-right1"><table width="50%" border="0" cellspacing="0" cellpadding="0" class="listtab-rt-bro1">
	<tr>
	  <td align="left" valign="middle"><a href="website_pages_addedit.php?id=<?php echo $objEncDec->encrypt($cmn->readValueDetail($awpval['page_id']));?>&height=480&width=850&TB_iframe=true" class="thickbox" title="Edit Page"><img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/edit.png" alt="" width="16" height="17" alt="Edit"  /></a></td>
	<td align="left" valign="middle"><a href="javascript:deletePageDetails('<?php echo $objEncDec->encrypt($cmn->readValueDetail($awpval['page_id']));?>');"><img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/delete.gif" alt="Delete" width="16" height="16" /></a></td>
	  </tr>
	</table></td>
  </tr>
  <?php }} else { ?>
  <tr class="row01">
  <td class="sponsors-table-right1" align="center" colspan="2">No Pages Found.</td>
  </tr>
  <?php } ?>
</table>
<?php	
}	
?>