<?php

$mhost = 'ssl://shanty.amarserver.com';
$muser = 'messages@powerstonegh.com';
$mpass = '4unikson.';

require 'mail/phpmailerautoload.php';
$mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = $mhost;  	      // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $muser;        // SMTP username
$mail->Password = $mpass;                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to



$email = "newhope.flex@gmail.com";

$mail->From = 'noreply@powerstonegh.com';
$mail->FromName = 'Powerstone';
$mail->addAddress($email);               // Add a recipient
$mail->addReplyTo('support@powerstonegh.com');
$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>