<?php 
include 'db.php';
session_start();
$temp=false;
$tempe=false;
if(isset($_POST['save'])){
    $temp=false;
    $tempe=false;
    $email=$_POST['mail'];
    $pass=$_POST['pass'];
    
    $query=mysqli_query($conn,"SELECT * FROM user WHERE email='$email'");
    if (mysqli_num_rows($query)==1){
        $row=mysqli_fetch_assoc($query);
        if(password_verify($pass,$row['password'])){
            $_SESSION['id']=$row['id'];
            header('location: dashboard.php');
            exit;
        }
        else{
            $temp=true;
        }
    }
    else{
        $tempe=true;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Iceberg&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@100..900&display=swap" rel="stylesheet">
        <style>
            .main{
                background-color: rgba(255, 255, 255, 0.082);
                width: 100%;
            }
            input{
                padding: 10px;
                margin: 10px;
                border: none;
                border-radius: 3px;
                background: linear-gradient(to bottom right, rgba(0, 140, 255, 0.158), white);
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
                width: auto;
                height: auto;
                margin: auto;
                padding-block: 25px;
                border-radius: 3px;
                background-color: rgba(0, 0, 0, 0.253);
                display: flex;
                flex-direction: column;
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
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                margin-bottom: 0px;
            }
            .logo img{
                display: flex;
                justify-content: center;
                border-radius: 50%;
            }
            @media(max-width: 768px){
                .log{
                    font-size: 20px;
                }
                button{
                    font-size: 20px;
                    margin-left: 15px;
                    margin-top: 15px;
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
                <form method="POST">
                    <input type="email" name="mail" id="email" placeholder="Your email"><br>
                    <input type="password" name="pass" id="pass" placeholder="Your Password"><br>
                    <?php echo "<p style='font-size: 12px'>*You can find your password in your registered email id</p>"?>
                    <button type="submit" name="save">Login</button> 
                    <?php if($temp){
                    echo "<p style='color: red'>❌Password not match";}
                    if($tempe){
                    echo "<p style='color: red'>❌Email not found";}?>
                </form>   
                <p>Don't have any account?<a href="signup.php">Create Now</a></p>
            </div>
        </div>
    </body>
</html>