<?PHP	
	if(isset($_POST['txtFieldPage']) && $_POST['txtFieldPage']==1)
	{
		
		if(isset($_POST['field']) && is_array($_POST['field']) && !empty($_POST['field']))
		{	$selectedFields = $objReports->fetchSelectedFields();
			for($k=0;$k<count($selectedFields);$k++)
			{
				if(!in_array($selectedFields[$k]['report_field_id'],$_POST['field']))
				{
					$objReports->report_field_id = $selectedFields[$k]['report_field_id'];
					$objReports->deleteReportViewDtl();
				}
			}
			for($j=0;$j<count($_POST['field']);$j++)
			{
				$chkField = $_POST['field'][$j];
				$objReports->report_field_id = $chkField;
				$objReports->created_by = $cmn->getSession(ADMIN_USER_ID);
				$objReports->updated_by = $cmn->getSession(ADMIN_USER_ID);
				$objReports->insertSelectedFields();
			}
		}
		else
		{
			$selectedFields = $objReports->fetchSelectedFields();
			for($k=0;$k<count($selectedFields);$k++)
			{
				$objReports->report_field_id = $selectedFields[$k]['report_field_id'];
				$objReports->deleteReportViewDtl();
			}
		}
		
		$msg->sendMsg("report_entrant_user.php", "",94);
		exit;
		
	}
?>