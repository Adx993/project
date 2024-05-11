<?php
session_start();

$username   = 'root';
$password   = '';
$database   = 'pro1';
$db         = mysqli_connect('',$username,$password,$database);

if($db == false){

    echo "db connection failed";
    
}


?>