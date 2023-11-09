<?php 
    require_once('db-connect.php');

    $swhere = "";
    
    $sql = "SELECT * FROM `ple_reports_data`";
    $query = $conn->query($sql);
    $reports = [] ;
    if($query->num_rows > 0){
        $reports = array_values($query->fetch_all(MYSQLI_ASSOC));
    }
    
    echo json_encode($reports);
    $conn->close();