<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src//PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$Fullname;$Email;$phone;$company;$projectType;$projectScope;$attachment;$description = "";
if(isset($_POST["Fname"])){
 $Fullname = $_POST["Fname"];
 $Email = $_POST["email"];
 $phone = $_POST["phone"];
 $company = $_POST["companyname"];
 $projectType = $_POST["projectType"] ;
 $projectScope = $_POST["serviceScope"];
 $attachment = $_FILES["entailfile"]["name"];
 $path = "./photos/".basename($attachment);
$description = $_POST["description"];   
$mail = new PHPMailer(true);
 move_uploaded_file($_FILES["entailfile"]["tmp_name"],$path);
try {
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'igwezehycient86@gmail.com';                     // SMTP username
    $mail->Password   = '';                               // SMTP password
    $mail->SMTPSecure = "ssl";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($Email, $Fullname);
    $mail->addAddress('igwezehycient86@gmail.com', 'raldweb');     // Add a recipient
    $mail->addReplyTo($Email, $company);

    // Attachments
    $mail->addAttachment($path);         // Add attachments

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Message from raldweb official website';
    $mail->Body    = '
    <div>
    <h1>projecttype</h1>
     <h6>'.$projectType.'</h6>
     <h1>projectScope</h1>
     <h6>'.$projectScope.'</h6><br>
     <p>Description :: '.$description.'</p>
    </div>
    ';
    $mail->send();
    echo json_encode(array('status'=> "sent", "message" => 'Message has been sent'));
} catch (Exception $e) {
    echo json_encode(array('status'=> "fail", "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"));
} 
}
