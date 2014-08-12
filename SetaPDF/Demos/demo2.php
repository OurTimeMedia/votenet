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
$FormFiller =& SetaPDF_FormFiller::factory(
    "Customizer-Example.pdf" /* or "Sample-Form2.pdf" -> Path to original document */, 
    "" /* Owner- or User-Passwort */, 
    "I" /* How to output the document: "F" = to File, "I" = Inline, "D" = Download */
);

// Check for errors
if (SetaPDF::isError($FormFiller)) {
    echo "<pre>";
    print_r($FormFiller);
    echo "</pre>";
    die();
}

// Get all Form Fields
$fields =& $FormFiller->getFields();
// Check for errors
if (SetaPDF::isError($fields)) {
    die($fields->message);
}


/**
 *  to get the fieldnames you can print them with this snipped on your screen
 */
#echo "<pre>";
#print_r(array_keys($fields));
#echo "</pre>";
#flush();

// Fill in Fields
foreach ($fields AS $name => $v) {
    switch (strtolower(get_class($fields[$name]))) {
        // Textfields
        case 'setapdf_textfield':
            $fields[$name]->setValue("SetaPDF");
            $fields[$name]->setLink('http://www.setasign.de');
            break;
        // Buttons like checkboxes
        case 'setapdf_buttonfield':
            $fields[$name]->push();
            break;
        // Radiobuttons
        case 'setapdf_buttonfield_group':
            // get all grouped buttons
            $btns =& $fields[$name]->getButtons();
            // push a random button
            $btn = array_rand($btns);
            $btns[$btn]->push(); 
            break;
        // selectboxes or comboboxes
        case 'setapdf_choicefield':
            // get available options
            $options = $fields[$name]->getOptions();
            // set the value by passing the index of a option to the setValue-method
            $fields[$name]->setValue(array_rand($options));
            break;
    }
}

// Ouput the new PDF
$FormFiller->fillForms('NewPDF.pdf');
