<?php 
if (!isset($_POST['action']) || $_POST['action'] != 'sendMail'){
    header('Location: ../index.php');
    exit;
}

$email = $_POST['email'];
$nume = $_POST['name'];
$subject = $_POST['subject'];
$message = $_POST['message'];

if (strlen($email) == 0 || strlen($message) == 0) {
    echo "<script>window.location.href = 'index.php';</script>";
}

require_once("PHPMailer-master/src/PHPMailer.php");
require_once("PHPMailer-master/src/SMTP.php");
use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->CharSet = "utf-8";
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';

$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->isHTML(true);

$mail->Username = 'noreply.turismulbia@gmail.com';
$mail->Password = 'kjdajopdwlj7Jsd1Ssfa';

$mail->setFrom($email, $nume);
$mail->Subject = $subject;
$mail->MsgHTML($message);
$mail->addAddress('iulianab03@gmail.com');

$mail->send();
?>