<?php

$server ="localhost";
$username ="Hasti";
$password ="hasti";
$db ="tutorials";

//create a connection
$conn = mysqli_connect($server,$username,$password,$db);

//check the connection
if(!$conn){
    die("Connection failed ".mysqli_connect_error());
}
//echo "Connection successfull";
?>