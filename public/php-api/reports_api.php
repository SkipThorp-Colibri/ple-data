<?php
    require_once('db-connect.php');
    
    $action = "read";
    
    $response = [];
    
    if (isset($_GET['action'])) {
       $action = $_GET['action'];
    }
    
    if ($action == 'read') {
       $reports = [];
       $result = $connection->query("SELECT * FROM  `ple_reports_data`");
    
       while ($row = $result->fetch_assoc()) {
    
          array_push($reports, $row);
          $response['reports'] = $reports;
       }
    } elseif ($action == 'readSingle') {
      $reports = [];
      if (isset($_GET['id'])) {
         $id = $_GET['id'];
      }
      $result = $connection->query("SELECT * FROM  `ple_reports_data` WHERE `id` = `$id`");

      while ($row = $result->fetch_assoc()) {
    
         array_push($reports, $row);
         $response['reports'] = $reports;
      }
    } elseif ($action == 'create') {
       $departments = $_POST['departments'];
       $emails = $_POST['emails'];
       $subject = $_POST['subject'];
       $rowsort = $_POST['rowsort'];
       $cc_email = $_POST['cc_email'];
       $columnsort = $_POST['columnsort'];
       $login_filter = $_POST['login_filter'];
       $completion_filter = $_POST['completion_filter'];
       $remove_button = $_POST['remove_button'];
       $course_type_only = $_POST['course_type_only'];
       $ple_only = $_POST['ple_only'];
       $summary_only = $_POST['summary_only'];
       $result = $connection->query("INSERT INTO `ple_reports_data`(`departments`, `emails`, `subject`, `rowsort`, `cc_email`, `columnsort`, `login_filter`, `completion_filter`, `remove_button`, `course_type_only`, `ple_only`, `summary_only`) VALUES ('$departments', '$emails','$subject',$rowsort,$cc_email,$columnsort,$login_filter,$completion_filter,$remove_button,$course_type_only,$ple_only,$summary_only)");
       if ($result) {
          $response["massage"] = 'Data Added Success';
       } else {
          $response["massage"] = 'Data Save Faild';
       }
    } elseif ($action == 'update') {
    
       $id = $_POST['id'];
       $departments = $_POST['departments'];
       $emails = $_POST['emails'];
       $subject = $_POST['subject'];
       $cc_email = $_POST['cc_email'];
       $columnsort = $_POST['columnsort'];
       $login_filter = $_POST['login_filter'];
       $completion_filter = $_POST['completion_filter'];
       $remove_button = $_POST['remove_button'];
       $course_type_only = $_POST['course_type_only'];
       $ple_only = $_POST['ple_only'];
       $summary_only = $_POST['summary_only'];
       $result = $connection->query("UPDATE `ple_reports_data` SET `departments`='$departments', `emails`='$emails', `subject`='$subject', `rowsort`='$rowsort', `cc_email`='$cc_email', `columnsort`='$columnsort', `login_filter`='$login_filter', `completion_filter`='$completion_filter', `remove_button`='$remove_button', `course_type_only`='$course_type_only', `summary_only`='$summary_only' WHERE `id` = '$id' ");
       if ($result) {
          $response["massage"] = 'Data Update Success';
       } else {
          $response["massage"] = 'Data Update Faild';
       }
    } elseif ($action == 'delete') {
    
       $id = $_POST['id'];
    
       $result = $connection->query("DELETE FROM `ple_reports_data` WHERE  `id` = '$id'");
       if ($result) {
          $response["massage"] = 'Data Delete Success';
       } else {
          $response["massage"] = 'Data Delete Faild';
       }
    }
    
    header('content-type: application/json');
    echo json_encode($response);