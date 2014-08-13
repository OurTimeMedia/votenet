<?php
require_once("include/common_includes.php");

// parse PDF data came from the registration form
$postdata = rawurldecode($_SERVER['QUERY_STRING']);
$postdata = strstr($postdata, "data=");
$postdata = substr($postdata, 5, strlen($postdata));

// process postdata and convert it to array (similar to $_POST)
$pdfData = array();
parse_str($postdata, $pdfData);

// create instance of the document
require_once('../vendor/setasign/setapdf-formfiller_full/library/SetaPDF/Autoload.php');

$outputDocumentName = 'voter' . rand() . '.pdf';
$writer = new SetaPDF_Core_Writer_Http($outputDocumentName, false);
$document = SetaPDF_Core_Document::loadByFilename('../SetaPDF/Demos/voter.pdf', $writer);

$FormFiller = new SetaPDF_FormFiller($document);
$FormFiller->setNeedAppearances(true);

// get all fields from the document
$fields = $FormFiller->getFields();

// fill 4 address fields
for ($addrLineNumber = 1; $addrLineNumber <= 5; $addrLineNumber++) {
    $fieldKey = 'pdfAddressField' . $addrLineNumber;
    if (isset($pdfData[$fieldKey]) && isset($fields[$fieldKey])) {
        $fields[$fieldKey]->setValue(stripslashes($pdfData[$fieldKey]));
    }
}

// fill other fields
$fields["topmostSubform[0].Page4[0].DropDownList2[0]"]->setValue(0);
$fields["topmostSubform[0].Page4[0].DropDownList2[1]"]->setValue(0);

$pdfValues = explode("######", $pdfData['ForPDF']);

foreach ($pdfValues as $pdfValue)  {
    if (empty($pdfValue)) continue;

    $pdfValue = explode("|^|", $pdfValue);

    $fieldMappingID = $pdfValue[1];
    $fieldName = $pdfValue[2];
    $fieldID = $pdfValue[0];

    $value = stripslashes($pdfValue[3]);

    /**
     * Field mappings:
     * 5 - Textbox
     * 7 - Elegibility criteria
     * 8 - Party
     * 9 - Race Group
     * 10 - ID Number
     * 11 - Date
     * 12 - Textarea
     * 13 - Home State
     * 14 - Home Zipcode
     * 15 - State
     * 16 - Zipcode
     * 17 - Phone No
     */
    if (in_array($fieldMappingID, array(5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17))) {
        //$value = SetaPDF_Core_Encoding::convert($value, 'UTF-8', 'UTF-16BE');
        $fields[$fieldName]->setValue($value);
    }
    /**
     * Field mappings:
     * 6 - drop down
     */
    if ($fieldMappingID == 6) {
        $sValue = explode("_", $value);
        if (count($sValue) > 1) {
            setDropdownValue($fields[$fieldName], $sValue[3]);
        } else {
            setDropdownValue($fields[$fieldName], $value);
        }
    }

}

$document->save()->finish();

/**
 * Set value of drop down field
 *
 * @param $field
 * @param $value
 * @see http://manuals.setasign.com/setapdf-formfiller-manual/field-types/combo-box-fields/#index-4
 */
function setDropdownValue($field, $value) {
    $options = $field->getOptions();

    foreach ($options AS $id => $option) {
        if ($option['visibleValue'] == $value) {
            $field->setValue($id);
            break;
        }
    }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<script type="text/javascript">
    //parent.downloadPDF('<?php echo $rand;?>');
    parent.showSuccessBlock();
</script>
</body>
</html>
