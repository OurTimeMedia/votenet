<?php
	if(isset($noChilds))
	{
		if($noChilds == '' and (int)$noChilds < 0)
		{
			$noChilds	= 99;
		}
	}
	else
	{
		$noChilds	= 99;
	}
print $objcms->getCmsList($_REQUEST['cms_seo_url'],$noChilds,$_REQUEST['parent_cms_seo_url']); ?>