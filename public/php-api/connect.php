<?php
    $host = "localhost";
    $username = "Kenny";
    $pw = "Xcel@1234";
    $db_name = "Kenny";
    
    $connection = new mysqli($host, $username, $pw, $db_name);
    
    if(!$connection){
        die("Database Connection Failed");
    }