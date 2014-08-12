<?php
error_reporting(E_ALL);
/**
 * set the includepath for SetaPDF APIs
 * You have to point the the root directory "SetaPDF"
 */
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__).'/../'));


// define Font-Path
define('SETAPDF_FORMFILLER_FONT_PATH','FormFiller/font/');

// require API
require_once('FormFiller/SetaPDF_FormFiller.php');

function doSelect(SetaPDF_ChoiceField $field, $value) {
    $options = $field->getOptions();
	
    foreach ($options AS $id => $option) {
     if ($option['value'] == $value) {
      $field->setValue($id);
      break;
     }
    }
}
 
function doButtonGroup(SetaPDF_ButtonField_Group $fieldGroup, $value) {
 $buttons = $fieldGroup->getButtons();
 
 foreach ($buttons AS $name => $button) {
  if ($name == ('/' . $value)) {
   $button->push();
   break;
  }
 }
}

/**
 * init a new instance of the FormFiller
 */
/* $FormFiller = SetaPDF_FormFiller::factory(
    "voter.pdf", 
    "", 
    "D",
    false, // Don't stream
    false, // render the appearances by the API
    'UTF-8' // get field names and values in UTF-8
);*/

if(isset($_POST['lang']) && $_POST['lang'] != "")
{
	$pdf_file_name = "voter_".$_POST['lang'].".pdf";
	$FormFiller = SetaPDF_FormFiller::factory($pdf_file_name, '', 'I', false, true, 'UTF-8');
}	
else
	$FormFiller = SetaPDF_FormFiller::factory("voter.pdf", '', 'I', false, true, 'UTF-8');

// Check for errors
if (SetaPDF::isError($FormFiller)) {
    echo "<pre>";
    print_r($FormFiller);
    echo "</pre>";
    die();
}
//echo "<pre>";
//print_r($_POST);
//exit;
/**
 * Use Update or create a whole new document 
 */
$FormFiller->setUseUpdate(false);

// Get all Form Fields
$fields =& $FormFiller->getFields();
// Check for errors
if (SetaPDF::isError($fields)) {
    die($fields->message);
}

$PDFarr=explode("######", $_POST['ForPDF']);

// doSelect($fields["topmostSubform[0].Page4[0].DropDownList2[0]"], "Yes");
// doSelect($fields["topmostSubform[0].Page4[0].DropDownList2[1]"], "Yes");
$fields["topmostSubform[0].Page4[0].DropDownList2[0]"]->setValue(0);
$fields["topmostSubform[0].Page4[0].DropDownList2[1]"]->setValue(0);

if(isset($_POST['pdfAddressField1']))
{
	if(isset($fields['pdfAddressField1']))
		$fields['pdfAddressField1']->setValue(stripslashes($_POST['pdfAddressField1'])); 
}	
	
if(isset($_POST['pdfAddressField2']))	
{
	if(isset($fields['pdfAddressField2']))
		$fields['pdfAddressField2']->setValue(stripslashes($_POST['pdfAddressField2'])); 
}	

if(isset($_POST['pdfAddressField3']))	
{
	if(isset($fields['pdfAddressField3']))
		$fields['pdfAddressField3']->setValue(stripslashes($_POST['pdfAddressField3'])); 
}	

if(isset($_POST['pdfAddressField4']))
{
	if(isset($fields['pdfAddressField4']))
		$fields['pdfAddressField4']->setValue(stripslashes($_POST['pdfAddressField4'])); 
}	

for($i=0;$i<count($PDFarr)-1;$i++)
{
	$PDFarrArr=explode("|^|", $PDFarr[$i]);
	$fieldmappingid=$PDFarrArr[1];
	$fieldname=$PDFarrArr[2];
	$field_id=$PDFarrArr[0];
	
	$value = stripslashes($PDFarrArr[3]);
		if($fieldmappingid !=6 )//dropdown
			$value = "\xFE\xFF".SetaPDF_Tools_Encoding::convert($value, 'UTF-8', 'UTF-16BE');
		else
			$value = $PDFarrArr[3];
			
			
				
		/*if($fieldmappingid==2) //radio btn
		{
			$buttons =& $fields[$fieldname]->getButtons();
			$buttons[$value]->push();
		}
		if($fieldmappingid==3)//checkbox
		{
			$fields[$name]->push();
		}
		if($fieldmappingid==4)//multiple checkbox
		{
			$fields['FNAME']->setValue("Rachna"); 
		}*/
			
		if($fieldmappingid==5)//TextBox
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==6)//dropdown
		{
			// $fields[$fieldname]->setValue(1);
			$sValue = explode("_",$value);
			
			if(count($sValue) > 1)
				doSelect($fields[$fieldname], $sValue[3]);
			else
				doSelect($fields[$fieldname], $value);
		}
		if($fieldmappingid==7)//Elegibility criteria
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==8)//Party
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==9)//Race Group
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==10)//ID Number
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==11)//Date
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==12)//Textarea
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==13)//Home State
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==14)//Home Zipcode
		{
			$fields[$fieldname]->setValue($value);  
		}
		if($fieldmappingid==15)//State
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==16)//Zipcode
		{
			$fields[$fieldname]->setValue($value); 
		}
		if($fieldmappingid==17)//Phone no
		{
			$fields[$fieldname]->setValue($value); 
		}
	
}

// Ouput the new PDF
$FormFiller->fillForms('PDF_'.rand().'.pdf');
?>