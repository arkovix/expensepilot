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
$temp=false;
if(isset($_POST['save'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $inc=$_POST['insource'];
    $budg=$_POST['budget'];
    $password=$_POST['passw'];
    $check = mysqli_query($conn, "SELECT * FROM `user` WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $temp = true;
    }
    else{
        $vpass=password_hash($password, PASSWORD_BCRYPT);
        $query=mysqli_query($conn, "INSERT INTO user (`fname`,`lname`,`email`,`income`,`budget`,`password`) VALUES ('$fname','$lname','$email','$inc','$budg','$vpass')");
        if($query){
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
                    $mail->setFrom('arkovix7@gmail.com', 'ExpensePilot');
                    $mail->addAddress($email);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Registration Success in ExpensePilot';
                    $mail->Body    = "Welcome to ExpensePilot <br>
                    				<h3>Account Details</h3>
                                    <p><b>Name:</b> $fname $lname</p>
                                    <p><b>Password:</b> $password</p>
                                    <p><h4>Now you can easily control your expenses</h4></p>";
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                } catch (Exception $e) {
                    echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
                }

            header('location: login.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registration Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Iceberg&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
        <style>
            *{
                margin: 0px;
                padding: 0px;
            }
            .main{
                width: 100%;
                height: auto;
                background: linear-gradient(to bottom right, rgba(0, 162, 255, 0.678), white);
            }
            input,select{
                margin: auto;
                padding: 10px;
                margin: 7px;
                border: none;
                border-radius: 3px;
                background: linear-gradient(to bottom right, rgba(0, 140, 255, 0.158), white);
            }
            label{
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                text-align: start;
            }
            button{
                border: none;
                padding: 8px 15px;
                text-decoration: none;
                background-color: rgb(0, 119, 255);
                font-weight: bold;
                font-size: medium;
                font-family: "Commissioner", sans-serif;
                border-radius: 3px;
                color: wheat;
            }
            .log{
                width: 60%;
                height: auto;
                margin: auto;
                padding-block: 25px;
                border-radius: 3px;
                background-color: rgba(255, 255, 255, 0.048);
                padding: 30px;
                align-items: center;
                box-shadow: 2px 3px 5px rgba(0, 0, 0, 0.418);
            }
            .logo{
                width: 300px;
                padding: 15px;
                display: flex;
                flex-direction: row;
                margin: auto;
                margin-bottom: 30px;
                font-family: "Iceberg", sans-serif;
                color: rgb(0, 119, 255);
            }
            .log p{
                display: flex;
                align-items: center;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
            }
            .logo img{
                display: flex;
                justify-content: center;
                border-radius: 50%;
            }
            h2{
                margin-top: 0px;
                font-family: "Carter One", system-ui;
                font-weight: 400;
                font-size: 30px;
                color: rgb(0, 0, 0);
            }
            @media(max-width: 768px){
                .log{
                    width: auto;
                    margin: 10px;
                }
                .logo h1{
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 40px;
                }
                button{
                    font-size: larger;
                    margin-bottom: 15px;
                }
                .log #pa{
                    font-size: 22px;
                }
                .log form{
                    font-size: 20px;
                }
                input,select{
                    background: rgb(255, 255, 255);  
                }
            }
        </style>
    </head>
    <body>
        <div class="main">
            <div class="logo">
                <img src="asset/logo.png" width="75px" height="75px">
                <h1>ExpensePilot</h1>
            </div>
            <div class="log">
                <h2>Create Your Account</h2>
                <p id="pa">Start your journey to financial freedom
                <img src="asset/rocket.png" alt="startjourney" width="30px" height="30px"></p><br><br>
                <form method="POST">
                    <label for="fname">First name:</label>
                    <input type="name" id="fname" name="fname" placeholder="First name" required><br>
                    <label for="lname">Last name:</label>
                    <input type="name" id="lname" name="lname" placeholder="Last name" required><br>
                    <label for="email">Email address:</label>
                    <input type="email" id="email" name="email" placeholder="Enter email id..." required><br>
                    <label for="inc">Income source:</label>
                    <select id="inc" name="insource" required>
                        <option>Salary</option>
                        <option>Business</option>
                        <option>Student</option>
                        <option>Others</option>
                    </select><br>
                    <label>Enter your monthly budget:</label>
                    <input type="num" id="mb" name="budget" placeholder="Approx monthly budget" required><br>
                    <label for="pass">Password:</label>
                    <input type="password" id="pass" name="passw" placeholder="Your Password" required><br>
                    <?php echo "<p style='color: red'>Please mind the password carefully!<br>Next time without login you cannot change the password and not use the same email id</p>" ?><br>
                    <button type="submit" name="save">Register</button>
                    <?php
                    if($temp){
                    echo "<p style='color: red'>Email id already registered!<br>Please login or enter another email!</p>"; }?>
                </form>
                <p>Already have an account?<a href="login.php">Login Now</a></p>
            </div>
        </div>
    </body>
</html>