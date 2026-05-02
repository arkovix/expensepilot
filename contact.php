<?php 
include 'db.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

if(isset($_POST['save'])){
    $name=$_POST['fname'];
    $email=$_POST['mail'];
    $res=$_POST['reson'];
    $description=$_POST['descrip'];
        //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'arkovix7@gmail.com';                     //SMTP username
                    $mail->Password   = 'dmrdssixbkawblbi';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom($email, $name);
                    $mail->addAddress('arkovix7@gmail.com');     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'New Contact Message';
                    $mail->Body    = "<h3>Contact Details</h3>
                                    <p><b>Name:</b> $name</p>
                                    <p><b>Email:</b> $email</p>
                                    <p><b>Reason:</b> $res</p>
                                    <p><b>Message:</b><br>$description</p>";
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    echo "Message sent successfully!";
                } catch (Exception $e) {
                    echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
                }

            header('location: index.php');
            exit();
}
?>
<html>
    <head>
        <title>Contact Us</title>
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <?php include 'header.html' ?>
        <div class="cmain">
            <h1>Contact Us</h1>
            <p>We would love to hear from you! Please fill out this form and we will get in touch with you shortly.</p>
            <form method="post"> 
                <label for="name">Full name:</label>
                <input id="name" name="fname" type="text" placeholder="Full Name"><br>
                <label for="mail">Email address:</label>
                <input id="mail" name="mail" type="email" placeholder="Email address"><br>
                <label for="reson">Reason to contact us:</label>
                <select id="reson" name="reson">
                    <option>SEO Tools</option>
                    <option>Advertisement</option>
                    <option>Others</option>
                </select><br>
                <label for="des">Description:</label>
                <textarea id="des" name="descrip" placeholder="Describe your reason..."></textarea><br>
                <button type="submit" name="save">Submit</button>
            </form>
        </div>
        <?php include 'footer.html'?>
    </body>
</html>