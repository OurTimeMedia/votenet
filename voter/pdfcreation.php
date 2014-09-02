<?php
require_once("include/common_includes.php");

$voterId = $_REQUEST['voter_id'];
$sendEmail = (!empty($_REQUEST['send_email']) && $_REQUEST['send_email']);

// parse PDF data came from the registration form
$postdata = rawurldecode($_SERVER['QUERY_STRING']);
$postdata = strstr($postdata, "data=");
$postdata = substr($postdata, 5, strlen($postdata));

// process postdata and convert it to array (similar to $_POST)
$pdfData = array();
parse_str($postdata, $pdfData);

// create instance of the document
require_once('../vendor/setasign/setapdf-formfiller_full/library/SetaPDF/Autoload.php');


if ($sendEmail) {
    require_once(COMMON_CLASS_DIR . "clscommon.php");
    require_once (COMMON_CLASS_DIR . "clsvoter_reminder.php");
    $voterReminder = new voter_reminder();
    $voterReminder->loadByVoterId($voterId);

    if (!$voterReminder->getId()) {
        $voterReminder->setVoterId($voterId)->add();
    }

    $outputDocumentName = 'voter' . $voterReminder->getPdfId() . '.pdf';

    $writer = new SetaPDF_Core_Writer_File(VOTER_PDF_DIR . $outputDocumentName);
} else {
    $outputDocumentName = 'voter' . mt_rand(1000000, 9999999) . '.pdf';

    $writer = new SetaPDF_Core_Writer_Http($outputDocumentName, false);
}

$document = SetaPDF_Core_Document::loadByFilename('../SetaPDF/Demos/voter.pdf', $writer);

$FormFiller = new SetaPDF_FormFiller($document);
$FormFiller->setNeedAppearances(true);

// get all fields from the document
$fields = $FormFiller->getFields();

// set default Empty value for all dropdown fields
foreach ($fields as $field) {
    if ($field instanceof SetaPDF_FormFiller_Field_Combo) {
        setDropdownValue($field, " ");
    }
}

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

if ($sendEmail) {
    // empty SSN field
    $fields['topmostSubform[0].Page4[0].TextField11[0]']->setValue('');
}

$document->save()->finish();

if ($sendEmail) {
    // load voter from DB
    require_once (COMMON_CLASS_DIR ."clsvoter.php");
    $voter = new voter();
    $voterEmail = $voter->fieldValue('voter_email', $voterReminder->getVoterId());

    if ($voterEmail) {
        // render email body
        include DWOO_DIR . 'dwooAutoload.php';
        $templateFile = VOTER_BASE_DIR . 'email_template/email_voter_registration.tpl';
        $dwoo = new Dwoo();
        $template = new Dwoo_Template_File($templateFile);

        $templateData = array(
            'client_firstname' => ucfirst(strtolower($fields->get('topmostSubform[0].Page4[0].TextField1[1]')->getValue())),
            'client_lastname'  => ucfirst(strtolower($fields->get('topmostSubform[0].Page4[0].TextField1[2]')->getValue())),
            'client_email' => strtolower($voterEmail)
        );

        $emailHtmlBody = $dwoo->get($template, $templateData);

        // BUILD EMAIL
        require_once '../vendor/swiftmailer/swiftmailer/lib/swift_required.php';

        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance(OURTIME_SMTP_HOST, OURTIME_SMTP_PORT, OURTIME_SMTP_SECURITY)
            ->setUsername(OURTIME_SMTP_USERNAME)
            ->setPassword(OURTIME_SMTP_PASSWORD)
        ;

        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);

        // Create the message
        $message = Swift_Message::newInstance()
            // Give the message a subject
            ->setSubject(OURTIME_EMAIL_SUBJECT)
            // Set the From address with an associative array
            ->setFrom(array(OURTIME_EMAIL_FROMEMAIL => OURTIME_EMAIL_FROMNAME))
            // Set the To addresses with an associative array
            ->setTo(array($templateData['client_email'] => $templateData['client_firstname'] . ' ' . $templateData['client_lastname']))
            // Give it a body
            //->setBody($emailBody)
            // And optionally an alternative body
            ->addPart($emailHtmlBody, 'text/html')
            // Optionally add any attachments
            ->attach(Swift_Attachment::fromPath(VOTER_PDF_DIR . $outputDocumentName))
        ;

        // Send the message
        echo $result = $mailer->send($message);
    }

}

exit;

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
