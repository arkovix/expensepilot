<?php 
include 'db.php';

if(isset($_POST['save'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $inc=$_POST['insource'];
    $budg=$_POST['budget'];
    $password=$_POST['passw'];
    $vpass=password_hash($password, PASSWORD_BCRYPT);
    $query=mysqli_query($conn, "INSERT INTO user (`fname`,`lname`,`email`,`income`,`budget`,`password`) VALUES ('$fname','$lname','$email','$inc','$budg','$vpass')");
    if($query){
        header('location: login.php');
        exit();
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
                    <button type="submit" name="save">Register</button>
                </form>
                <p>Already have an account?<a href="login.php">Login Now</a></p>
            </div>
        </div>
    </body>
</html>