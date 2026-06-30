<?php
require_once __DIR__ . '/../vendor/src/Exception.php';
require_once __DIR__ . '/../vendor/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

if(isset($_POST['send']))
{
    echo "Inside mail sending block<br>";

    $fname   = $_POST['fname'];
    $toemail = $_POST['toemail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    try
    {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        $mail->Username   = 'krinshikotiya@gmail.com';

        // Put your CURRENT Gmail App Password here
        $mail->Password   = 'svkr kowv fyev taia';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';

        $mail->setFrom('krinshikotiya@gmail.com', 'SecondHand-Bazaar');
        $mail->addReplyTo('krinshikotiya@gmail.com', 'Support');

        $mail->addAddress($toemail);

        $mail->isHTML(true);

        $bodyContent = 'Dear '.$fname;
        $bodyContent .= '<p>'.$message.'</p>';

        $mail->Subject = $subject;
        $mail->Body    = $bodyContent;

        if($mail->send())
        {
            echo "<br><b>Mail Sent Successfully</b>";
        }
        else
        {
            echo "<br><b>Mailer Error:</b> ".$mail->ErrorInfo;
        }
    }
    catch(Exception $e)
    {
        echo "<br><b>Exception:</b> ".$mail->ErrorInfo;
    }
}
else
{
    echo "<b>send variable not found</b>";
}
?>