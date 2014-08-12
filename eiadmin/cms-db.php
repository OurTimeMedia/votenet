<?php
	defined('PAGE_EXECUTE') or die( 'Restricted access.' );

	if ( isset($_POST['btnsubmit'])){

		$objvalidation = new validation();

		$objvalidation->add_validation("txtcms_title", "title", "req");
		$objvalidation->add_validation("txtcms_title", "title", "dupli", "", DB_PREFIX."cms|cms_title|cms_id|".$cms_id."|1|1");
		
		$objvalidation->add_validation("txtseo_url", "seo url", "dupli", "", DB_PREFIX."cms|seo_url|cms_id|".$cms_id."|1|1");
		
		$objvalidation->add_validation("txtcms_desc", "meta description", "maxlen", '', 500);
		$objvalidation->add_validation("txtcms_keywords", "meta keywords", "maxlen", '', 300);

		if($objvalidation->validate()){

			//Code to assign value of control to all property of object.
			$objcms->cms_id			= (int) $cms_id;
			$objcms->cms_title		= $cmn->setval(trim($cmn->read_value($_POST['txtcms_title'],'')));
			$objcms->cms_sub_title	= $cmn->setval(trim($cmn->read_value($_POST['txtcms_sub_title'],'')));
			
			$objcms->seo_url		= $cmn->setval(trim($cmn->read_value($_POST['txtseo_url'],'')));
			$objcms->ext_url		= $cmn->setval(trim($cmn->read_value($_POST['txtext_url'],'')));
			$objcms->parent			= $cmn->setval(trim($cmn->read_value($_POST['parent'],'')));
			$objcms->link_to_cms	= $cmn->setval(trim($cmn->read_value($_POST['link_to_cms'],'')));
		
			$objcms->cms_content	= $cmn->store_db_compatiblevalue(trim($cmn->read_value($_POST['txtcms_content'],'')));
			$objcms->meta_title		= $cmn->setval(trim($cmn->read_value($_POST['txtmeta_title'],'')));
			$objcms->meta_desc		= $cmn->setval(trim($cmn->read_value($_POST['txtmeta_desc'],'')));
			$objcms->meta_keywords	= $cmn->setval(trim($cmn->read_value($_POST['txtmeta_keywords'],'')));
			$objcms->cms_active		= $cmn->setval(trim($cmn->read_value($_POST['rdocms_active'],'')));
			$objcms->front_menu		= $cmn->setval(trim($cmn->read_value($_POST['front_menu'],'')));

			//Code to add record.
			if ($strmode == 'add')
			{
				$objcms->add();
				$msg->send_msg('cms-list.php','CMS ',3);
			}

			//Code to edit record
			if ($strmode == 'edit' && intval($cms_id) > 0)
			{
				$objcms->update();
				$msg->send_msg('cms-list.php','CMS ',4);
			}
		}
	}

	//Code to delete selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'delete')
	{
		if (count($_POST['deletedids']) == 0)
		{
			$msg->send_msg('cms-list.php','CMS ',9);
		}
		else
		{
			$objcms->checkedids = implode(',',$_POST['deletedids']);
			$objcms->delete();
			$msg->send_msg('cms-list.php','CMS ',5);
		}
		exit();
	}

	//Code to active inactive selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'active')
	{
		if (isset($_POST['activeids']))
			$arrayactiveids = $_POST['activeids'];
		else
			$arrayactiveids = array('0');
		$objcms->checkedids = implode(',',$arrayactiveids);
		$objcms->uncheckedids = $_POST['inactiveids'];
		$objcms->activeinactive();
		$msg->send_msg('cms-list.php','CMS ',15);
		exit();
	}

	//Code to export table.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'export')
	{
		$cmn->export_to_csv('cms', 'cms.csv');
	}