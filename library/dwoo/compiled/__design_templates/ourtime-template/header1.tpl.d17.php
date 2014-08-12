<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->scope["header_data"];?>

<title>Election Impact</title>
<link href="../design_templates/ourtime-template/css/skin.css" rel="stylesheet" type="text/css" />
<link href="../design_templates/ourtime-template/css/ei.css" rel="stylesheet" type="text/css" />
<link href="../voter/css/message.css" rel="stylesheet" type="text/css" />

<script src="../design_templates/ourtime-template/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="../design_templates/ourtime-template/js/jquery.jcarousel.min.js" type="text/javascript"></script>
<script src="../design_templates/ourtime-template/js/jquery.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="../design_templates/ourtime-template/js/jquery-ui-1.8.4.custom.min.js"></script>
<link href="../design_templates/ourtime-template/css/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="../design_templates/ourtime-template/js/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" language="javascript" src="../design_templates/ourtime-template/js/registration-form.js"></script>
</head>
<body style="background:none;">
<?php  /* end template body */
return $this->buffer . ob_get_clean();
?>