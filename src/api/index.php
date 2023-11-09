<?php
	
	$Host = "Localhost";
	$User = "Kenny";
	$Pass = "Xcel@1234";
	$DB = "Kenny";
	
	// Create connection
	$conn = new mysqli($Host, $User, $Pass, $DB);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM ple_reports_data LIMIT 10";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  
	  $reports = [];
	  
	  
	  while($row = $result->fetch_assoc()) {
		array_push($reports, $row);
	  }
	} else {
	  echo "0 results";
	}
	
	echo "{\"reports\": " . json_encode($reports) . "}";
	
	$conn->close();
	
?>