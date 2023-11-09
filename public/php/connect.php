<?php
    $host = "localhost";
    $username = "Kenny";
    $pw = "Xcel@1234";
    $db_name = "Kenny";
    
    $conn = new mysqli($host, $username, $pw, $db_name);
    
    if(!$conn){
        die("Database Connection Failed");
    }