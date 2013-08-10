<?php 
	// TESTING COMMENT SECTION
	function getConnection() {
		$connection = mysqli_connect("mysql6.000webhost.com", "a7551670_auca" , "rootAUCA2014", "a7551670_auca");	
		//$connection = mysqli_connect("localhost", "root" , "", "a7551670_auca");	
		return $connection;	
	}

	$userID = $_GET['id'];
	$connection = getConnection();
	
	if(!$connection) {
		return;
	}
	
	$query = "SELECT notificationID,notification_status FROM usernotif WHERE userID = '$userID'";
	$info = mysqli_query($connection,$query);
	
	$notificationInfo = array();
	while($row =  mysqli_fetch_array($info))
	{
		$notificationID = $row['notificationID'];
		$query = "SELECT title,content,notification_status FROM notification JOIN usernotif ON notification.id = usernotif.notificationID WHERE notification.id = '$notificationID'";
		
		$result = mysqli_query($connection,$query);
		$result = mysqli_fetch_assoc($result);
		
		$ID = (string)$notificationID;
		
		$notificationInfo[$ID] = $result;
		
	}
	
	echo json_encode($notificationInfo);
?>