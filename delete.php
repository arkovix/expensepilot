<?php
include 'db.php';
if(isset($_GET['id'])){
    $id=$_GET['id'];
    //echo $id;
    $query=mysqli_query($conn,"DELETE FROM expense WHERE sl_no=$id");
    if($query){
        header("location: dashboard.php");
        exit();
    }
    else{
        echo "Not deleted";
    }
}
?>