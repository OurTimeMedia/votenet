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

if(isset($_GET['file']) && $_GET['file'] != "")
{
	$pdf_file_name = $_GET['file'];
	$FormFiller = SetaPDF_FormFiller::factory($pdf_file_name, '', 'I', false, true, 'UTF-8');
}	
else
	$FormFiller = SetaPDF_FormFiller::factory("tempvoter689265083.pdf", '', 'I', false, true, 'UTF-8');

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

foreach($fields as $field)
{
	$fieldvalue = $field->getValue(); 	
	echo $fieldvalue;
	echo "<br>";
}	
?>