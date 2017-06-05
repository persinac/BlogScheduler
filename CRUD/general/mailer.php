<?php
/**
 * Created by PhpStorm.
 * User: apfba
 * Date: 4/27/2017
 * Time: 3:33 PM
 */

require '../../External Libraries/PHPMailer-master/PHPMailerAutoload.php';
require '../../connections/bs_connection.php';

/***
 * @param $sendToObj
 *  - Data structure for $sendToObject is Employee + Month Data:
 *      [
 *        empEmail => "<VAL>"
 *        empId => "<VAL>"
 *        date => "<VAL>"
 *        name => "<VAL>"
 *      ]
 */
function sendMail($sendToObj)
{
    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    //Need to set up service account
    $mail->Username = SERVICE_ACCT_EMAIL;                 // SMTP username
    $mail->Password = SERVICE_ACCT_PW;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

    $mail->From = 'alexp@originfitnessinc.com';
    $mail->FromName = 'Alex Persinger';
    //Add Recipients
    $mail->addAddress($sendToObj->empEmail);     // Add a recipient
    $mail->addReplyTo('alexp@originfitnessinc.com', 'Alex Persinger');
    $mail->addCC('jamie@crossfitburke.com'); //CC Owner

    /*
    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(false);                                  // Set email format to HTML
    */
    $mail->Subject = 'Blog Notification - Blog Due';
    $mail->Body = 'Hello ' . $sendToObj->name;
    $mail->Body .= "\n\nYour blog is due on " . $sendToObj->date .'.';
    $mail->Body .= "\n\nPlease send to Alex Persinger for submission by 5pm this Sunday!";
    $mail->Body .= " If you have already submitted your blog, please ignore this message.";
//    var_dump($sendToObj);
//    if($sendToObj->empEmail == 'alexp@originfitnessinc.com') {
        if (!$mail->send()) {
            echo 'Message could not be sent to ' . $sendToObj->empEmail . '</br>';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent to: ' . $sendToObj->empEmail . '</br>';
        }
//    } else {
//        echo "Would send mail to:" . $sendToObj->empEmail;
//    }

}

