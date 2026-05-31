<?php
$host="host_name";
$user="user_name";
$password="db_password";
$dbname="database_name";
$conn=mysqli_connect("$host","$user","$password","$dbname");
if(!$conn){
    echo "Can not connect to the database";
}
?>
