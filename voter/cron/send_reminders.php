<?php

$_SERVER['HTTP_HOST'] = '';
require_once(__DIR__ . "/../include/common_includes.php");

require_once(COMMON_CLASS_DIR . "clscommon.php");
require_once (COMMON_CLASS_DIR . "clsvoter_reminder.php");
$voterReminder = new voter_reminder();
$reminders = $voterReminder->loadReminders();

foreach ($reminders as $reminder) {
    sendReminder($reminder);
    $voterReminder->delete($reminder['id']);
}

function sendReminder($reminder)
{
    echo "\n\n********** SENDIND REMINDER ***********\n";

    $pdfPath = VOTER_PDF_DIR . 'voter' . $reminder['pdf_id'] . '.pdf';

    echo "PDF PATH: {$pdfPath} \n";

    if (!file_exists($pdfPath)) {
        echo "ERROR : FILE NOT FOUND : " . $pdfPath;
        return false;
    }

    // load voter from DB
    require_once (COMMON_CLASS_DIR ."clsvoter.php");
    $voter = new voter();
    $voterEmail = $voter->fieldValue('voter_email', $reminder['voter_id']);


    if ($voterEmail) {
        echo "RECIPIENT: {$voterEmail} \n";

        // render email body
        require_once DWOO_DIR . 'dwooAutoload.php';
        $templateFile = VOTER_BASE_DIR . 'email_template/email_voter_reminder.tpl';
        $dwoo = new Dwoo();
        $template = new Dwoo_Template_File($templateFile);

        $templateData = array(
            'client_email' => strtolower($voterEmail)
        );

        $emailHtmlBody = $dwoo->get($template, $templateData);

        // BUILD EMAIL
        require_once BASE_DIR . 'vendor/swiftmailer/swiftmailer/lib/swift_required.php';

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
            ->setSubject(OURTIME_EMAIL_REMINDER_SUBJECT)
            // Set the From address with an associative array
            ->setFrom(array(OURTIME_EMAIL_FROMEMAIL => OURTIME_EMAIL_FROMNAME))
            // Set the To addresses with an associative array
            ->setTo(array($templateData['client_email']))
            // Give it a body
            //->setBody($emailBody)
            // And optionally an alternative body
            ->addPart($emailHtmlBody, 'text/html')
            // Optionally add any attachments
            ->attach(Swift_Attachment::fromPath($pdfPath))
        ;

        // Send the message
        $result = $mailer->send($message);

        if ($result) {
            echo "EMAIL SENT \n";
        } else {
            echo "ERROR : EMAIL NOT SENT! \n";
        }
    } else {
        echo "ERROR : RECIPIENT NOT FOUND \n";
    }
}

exit;
