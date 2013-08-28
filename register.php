<?php
	function getConnection() {
		$connection = mysqli_connect("mysql6.000webhost.com", "a7551670_auca" , "rootAUCA2014", "a7551670_auca");	

		return $connection;	
	}
	
	function getGcmRegIds($receivers) {
		$connection = getConnection();
		$result = mysqli_query($connection,"SELECT gcm_regid FROM gcm_users WHERE name IN ('$receivers')");
		
		$gcm_regids = array();
		while($row = mysqli_fetch_assoc($result)) {
			array_push($gcm_regids,$row['gcm_regid'];
		}
		
		return $gcm_regids;
	}
	
	function getRegId() {
		$connection = getConnection();
		
		$result = mysqli_query($connection,"SELECT gcm_regid FROM gcm_users WHERE id = 1");
		while($row = mysqli_fetch_assoc($result)) {
			$id = $row['gcm_regid'];
		}
		
		return $id;
	}
	
	function sendNotification($regId,$type) {
		$data = "";
		switch($type)
		{
			case "chat":
				$data = array (
					'type' => 'chat',
					'content' => "Вот тебе письмо из чата"
				);
				break;
			case "message":
				$data = array (
					'type' => 'message',
					'content' => "Вот тебе письмо из почты"
				);
				break;
			case "schedule":
				$data = array (
					'type' => 'schedule',
					'content' => "Вот тебе письмо из расписания"
				);
				break;
			default:
				break;
		}
	
		$url = 'https://android.googleapis.com/gcm/send';
				
		$fields = array(
				'registration_ids' => array($regId),
				'data' => $data
				);
		
		$headers = array(
            'Authorization: key=AIzaSyAKLyrf4umPwx9moKO-_GMxRnS6_fJfvoc',
            'Content-Type: application/json'
        );
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
		
		curl_close($ch);
        echo $result;
	}
	
	function storeUser($register_id,$name,$password) {
		$connection = getConnection();
		$query = "INSERT INTO gcm_users(gcm_regid,name,password) VALUES('$register_id','$name','$password')";
		
		mysqli_query($connection,$query);
	}
	
	if (!isset($_POST["type"]) && isset($_POST["regId"]) && 
			isset($_POST["name"]) && isset($_POST["password"])) {
				$name = $_POST["name"];
				$password = $_POST["password"];
				$registration_id = $_POST["regId"];
				
				storeUser($registration_id,$name,$password);
	} else if (!isset($_POST["type"]) && !isset($_POST["regId"]) && isset($_POST["names"])) {
			$receivers = $_POST["names"];
			$gcm_regIds = getGcmRegIds($receivers);
			
			return $gcm_regIds;
	} else {
		$registration_id = $_POST["regId"];
		$type = $_POST["type"];
		
		switch($type) 
		{
			case "chat":
				sendNotification($registration_id,"chat");
				break;
			case "message":
				sendNotification($registration_id,"message");
				break;
			case "schedule":
				sendNotification($registration_id,"schedule");
				break;
			default:
				break;
		}
	}

?>