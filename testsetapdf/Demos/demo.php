<?php
error_reporting(E_ALL);
/**
 * set the includepath for SetaPDF APIs
 * You have to point the the root directory "SetaPDF"
 */
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__).'/../../'));


// define Font-Path
define('SETAPDF_FORMFILLER_FONT_PATH','FormFiller/font/');

// require API
require_once('FormFiller/SetaPDF_FormFiller.php');

/**
 * init a new instance of the FormFiller
 */
$FormFiller = SetaPDF_FormFiller::factory(
    "voter.pdf" /* Path to original document */, 
    "" /* Owner- or User-Passwort */, 
    "I", /* How to output the document: "F" = to File, "I" = Inline, "D" = Download */
    false, // Don't stream
    false, // render the appearances by the API
    'UTF-8' // get field names and values in UTF-8
);

// Check for errors
if (SetaPDF::isError($FormFiller)) {
    echo "<pre>";
    print_r($FormFiller);
    echo "</pre>";
    die();
}
echo "<pre>";
print_r($_POST);
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

$PDFarr=($_POST['ForPDF']);
/*for($i=0;$i<count($PDFarr);$i++)
{
	$fieldmappingid=$PDFarr[$i]['field_mapping_id'];
	$fieldname=$PDFarr[$i]['pdffieldname'];
	$value=$PDFarr[$i]['value'];
	$field_id=$PDFarr[$i]['field_id'];
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
	/*if($fieldmappingid==5)//TextBox
	{
		$fields[$fieldname]->setValue($value); 
	}
	/*if($fieldmappingid==6)//dropdown
	{
		$drowpdown = $fields[$fieldname]->getOptions();
		$fields[$fieldname]->setValue($value);
	}
	if($fieldmappingid==7)//Elegibility criteria
	{
		$eligibilitycriteria = $fields[$fieldname]->getOptions();
		$fields[$fieldname]->setValue($value);
	}*/
	/*if($fieldmappingid==8)//Party
	{
		$fields['FNAME']->setValue("Rachna"); 
	}
	if($fieldmappingid==9)//Race Group
	{
		$fields['FNAME']->setValue("Rachna"); 
	}
	if($fieldmappingid==10)//ID Number
	{
		$fields['FNAME']->setValue("Rachna"); 
	}
	if($fieldmappingid==11)//Date
	{
			$fields[$fieldname]->setValue($value); 
	}
	if($fieldmappingid==12)//Textarea
	{
		$fields[$fieldname]->setValue($value); 
	}*/
	/*if($fieldmappingid==13)//Home State
	{
		$fields['FNAME']->setValue("Rachna"); 
	}
	if($fieldmappingid==14)//Home Zipcode
	{
		$fields['FNAME']->setValue("Rachna"); 
	}
	if($fieldmappingid==15)//State
	{
		$fields['FNAME']->setValue("Rachna"); 
	}*/
//}
$fields['topmostSubform[0].Page4[0].DropDownList1[0]']->setValue("Ahmedabad");

// Ouput the new PDF
$FormFiller->fillForms($_POST['client_id'].'.pdf');
