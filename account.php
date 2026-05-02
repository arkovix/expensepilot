<?php 
include "db.php";
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM user WHERE id='$id'"));
    $succes=false;
    if(isset($_POST['update'])){
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $incs=$_POST['insource'];
        $bu=$_POST['mbu'];
        $su=mysqli_query($conn,"UPDATE user SET fname='$fname', lname='$lname', email='$email', income='$incs', budget='$bu' WHERE id=$id");
        if($su){
            $succes=true;
            echo "Update success";
            header("location: dashboard.php");
        }
    }
?>
<html>
    <head>
        <title>Account</title>
        <link href="account.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="profile"><img src="asset/profile.png" alt="account_profile" width="100px" height="100px"></div>
        <form method="post">
            <label for="name">First name:</label>
            <input type="text" id="name" name="fname" value="<?php echo $row['fname']?>"><br>
            <label for="name">Last name:</label>
            <input type="text" id="name" name="lname" value="<?php echo $row['lname']?>"><br>
            <label for="mail">Email address:</label>
            <input type="email" id="mail" name="email" value="<?php echo $row['email']?>"><br>
            <label for="inc">Income source:</label>
            <select id="inc" name="insource" required>
                <option><?php echo $row['income']?></option>
                <option>Salary</option>
                <option>Business</option>
                <option>Student</option>
                <option>Others</option>
            </select><br>
            <label for="mbudget">Your monthly budget:</label>
            <input type="number" id="mbudget" name="mbu" value="<?php echo $row['budget']?>"><br>
            <button type="submit" name="update">Update</button>
        </form>
    </body>
    <?php
}
else{
    echo "<a href='login.php'>login first</a>";
}
    ?>
</html>