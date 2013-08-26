<?php 
	// TESTING COMMENT SECTION
	function getConnection() {
		$connection = mysqli_connect("mysql6.000webhost.com", "a7551670_auca" , "rootAUCA2014", "a7551670_auca");	
		// $connection = mysqli_connect("fdb5.biz.nf","1492605_intouch","intouch","1492605_intouch");	

		return $connection;	
	}
	
	function getRegId($name) {
		$connection = getConnection();
		
		$id = "";
		$result = mysqli_query($connection,"SELECT gcm_regid FROM gcm_users WHERE name = '$name'");
		while($row = mysqli_fetch_assoc($result)) {
			$id = $row['gcm_regid'];
		}
		
		return $id;
	}
	
	function sendNotification($message,$name) {
		$data = "";
		$regId = getRegId($name);
		echo $message;
		$data = array (
			'type' => 'message',
			'content' => $message
		);
	
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
	

	if(isset($_POST['method']) == true && empty($_POST['method'])==false){
		$method = $_POST['method'];
		if($method=='get_profile_info'){

			// DB PROFILE INFO REQUEST.
			// USER ID IS IN $_POST['id']\
			
			$id = $_POST['id'];
			$connection = getConnection();

			$result = mysqli_query($connection, "SELECT * FROM user WHERE id = $id");

			while($row = mysqli_fetch_array($result))
			{
			  echo $row['FirstName'] . " " . $row['LastName'];
			  echo "<br>";

			?>
				<p>User info was requested</p>
				<p>User id is: <?= $row['id'] ?></p>
				<p>User name is: <?= $row['name'] ?></p>
				<p>User surname is: <?= $row['surname'] ?></p>
				<p>User login is: <?= $row['login'] ?></p>
				<p>User password is md5ed : <?= $row['password'] ?></p>
			<?php
			}
		}
		else if($method == 'get_course_info'){

			// DB COURSE INFO REQUEST
			// USER ID IS IN $_POST['id']
			
			$userID = $_POST['id'];
			$connection = getConnection();
			
			$query = "SELECT c_id FROM user_courses WHERE user_id = '$userID'";
			
			$result = mysqli_query($connection,$query);
			
			$coursesInfo = array();
			while($row = mysqli_fetch_assoc($result))
			{
				$courseID = $row['c_id'];
				$courseID = (string)$courseID;
				
				$query = "SELECT c_code,c_title,c_description,c_time_lec,c_time_lab
					 FROM course_info WHERE c_id = '$courseID'";
					
				$infoarr = array();
				$info = mysqli_query($connection,$query);
				// $info = mysqli_fetch_assoc($info);
				while($row = mysqli_fetch_assoc($info)){
					$tmparr = array();
					array_push($tmparr, $row['c_code']);
					array_push($tmparr, $row['c_title']);
					array_push($tmparr, $row['c_description']);
					array_push($tmparr, json_decode($row['c_time_lec']));
					array_push($tmparr, json_decode($row['c_time_lab']));
					array_push($infoarr, $tmparr);
				}
				$query = "SELECT name, surname FROM user WHERE id IN (SELECT id FROM user_courses WHERE c_id = '$courseID')";
				$stud = mysqli_query($connection, $query);
				$stud = mysqli_fetch_assoc($stud);

				$arr = array();
				$query = "SELECT name, surname FROM user WHERE id IN (SELECT user_id FROM user_courses WHERE c_id = '$courseID')";
				$stud = mysqli_query($connection, $query);
				while($row = mysqli_fetch_assoc($stud)){
					array_push($arr, $row);
				}
				$coursesInfo[$userID][$courseID] = $infoarr;
				$coursesInfo[$userID][$courseID]['group'] = $arr;
				
			}
			
			
			echo json_encode($coursesInfo);
			?>
				<p>User course info was requested</p>
				<p>User id is: <?=$_POST['id'] ?></p>
			<?php
		}
		else if($method == 'get_register_user'){

			// DB COURSE INFO REQUEST
			// USER ID IS IN $_POST['id']

			$connection = getConnection();
			$name = $_POST['user_name'];
			$surname = $_POST['user_surname'];
			$login = $_POST['user_login'];
			$pass = md5($_POST['user_pass']);

			if(!$connection) {
				return;
			}

			try {
				$query = "INSERT INTO user(name, surname, login, password) VALUES ('$name', '$surname', '$login', '$pass')";
				mysqli_query($connection, $query);

			?>
				
				<p>QUERY: <?= $query?></p>
				<p>User was registered: </p>
				<p>User name is: <?=$_POST['user_name'] ?></p>
				<p>User surname is: <?=$_POST['user_surname'] ?></p>
				<p>User login is: <?=$_POST['user_login'] ?></p>
				<p>User password is: <?=$_POST['user_pass'] ?></p>
			<?php
			}
			catch(Exception $e) {

			?>
				<p>Error: <?=$e->getMessage()?> </p>
			<?php	
			}			
		}
		else if($method == 'mail_sending'){

			// MAIL SENDING PROCESS
			
			$connection = getConnection();
			
			if(!$connection){
				return;
			}
			
			$title = strip_tags($_POST["title"]);
			$title = htmlspecialchars($title);

			
			$addresses =  $_POST["addr"];
			$content = $_POST['content'];
			
			try {
			
			$query = "INSERT INTO notification(title,content) VALUES('$title','$content')";
			mysqli_query($connection, $query);
			
			//$addresses = explode(",",$addresses);
			$userID = "";
			$notificationID = "";
			
			$result = mysqli_query($connection,"SELECT id FROM notification WHERE title = '$title'");
					
			while($row = mysqli_fetch_array($result))
			{
				$notificationID = $row['id']; 
			}
			
			$result = mysqli_query($connection,"SELECT id FROM user");
			$status = "unread";
			
			while($row = mysqli_fetch_array($result))
			{
				$userID = $row['id']; 
				$query = "INSERT INTO usernotif(userID,notificationID,notification_status) VALUES('$userID','$notificationID','$status')";
				mysqli_query($connection, $query);
				
			}
			
			sendNotification($content,$addresses);
			
				?>
					<p>Mail Sending was requested</p>
					<p>Title: <?=$_POST['title'] ?></p>
					<p>Content: <?=$_POST['content'] ?></p>
				<?php
			}
			catch(Exception $e) {
				?>
					<p>Error: <?=$e->getMessage()?> </p>
				<?php	
			}				
		}
		else if ($method == 'get_notification_info'){


			$userID = $_POST['id'];
			$connection = getConnection();
			
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
			//Notification processes here
			//$_GET['user_id']
			?>
				<p>This is how you print things</p>
			<?php
		}
		else if($method == "lec_select"){
			$num = $_POST['lcn'];
			?>
			<table>
				<thead>
					<tr>
						<th><div>Room:</div></th>
						<th><div>Day:</div></th>
						<th><div>Time:</div></th>
						<th><div>Teacher:</div></th>
					</tr>
				</thead>
			<?php
			for($i = 0; $i < $num; $i++){
				?>
				<tr>
					<td>
						<input id="lec_r_<?=$i?>"type="text">
					</td>
					<td>
					<select name="day" id="lec_day_<?=$i?>">
						<option value="M">Monday</option>
						<option value="T">Tuesday</option>
						<option value="W">Wednesday</option>
						<option value="Th">Thursday</option>
						<option value="F">Friday</option>
						<option value="S">Saturday</option>
					</select></td><td>
					<select name="time" id="lec_time_<?=$i?>">
						<option value="8:00">8:00</option>
						<option value="9:25">9:25</option>
						<option value="10:50">10:50</option>
						<option value="12:45">12:45</option>
						<option value="14:10">14:10</option>
						<option value="15:35">15:35</option>
						<option value="17:00">17:00</option>
						<option value="18:25">18:25</option>
					</select></td>
					<td>
					<input id="lec_t_<?=$i?>" type="text">
				</td>
				</tr>
				<?php
			}
			?>
			</table>
			<?php
		}
		else if($method == "lab_select"){
			$num = $_POST['lbn'];
			?>
			<table>
				<thead>
					<tr>
						<th><div>Room:</div></th>
						<th><div>Day:</div></th>
						<th><div>Time:</div></th>
						<th><div>Teacher:</div></th>
					</tr>
				</thead>
			<?php
			for($i = 0; $i < $num; $i++){
				?>
				<tr>
					<td>
						<input id="lab_r_<?=$i?>" type="text">
					</td>
					<td>
					<select name="day" id="lab_day_<?=$i?>">
						<option value="M">Monday</option>
						<option value="T">Tuesday</option>
						<option value="W">Wednesday</option>
						<option value="Th">Thursday</option>
						<option value="F">Friday</option>
						<option value="S">Saturday</option>
					</select>
					</td>
					<td>
					<select name="time" id="lab_time_<?=$i?>">
						<option value="8:00">8:00</option>
						<option value="9:25">9:25</option>
						<option value="10:50">10:50</option>
						<option value="12:45">12:45</option>
						<option value="14:10">14:10</option>
						<option value="15:35">15:35</option>
						<option value="17:00">17:00</option>
						<option value="18:25">18:25</option>
					</select></td>
					<td>
						<input id="lab_t_<?=$i?>" type="text">
					</td>
				</tr>
				<?php
			}
			?>
			</table>
			<?php
		}
		else if($method == "course_insert"){
			$connection = getConnection();
			
			$courseID = $_POST['course_id'];
			$courseCode = $_POST['course_code'];
			$courseTitle = $_POST['course_title'];
			$courseDescrip = $_POST['course_desc'];
			$lecTime = json_encode($_POST['lec']);
			$labTime = json_encode($_POST['lab']);
			// $lecTime = mysqli_real_escape_string($connection, $lecTime);
			// $labTime = mysqli_real_escape_string($connection, $labTime);
			
			$query = "INSERT INTO course_info(c_id,c_code,c_title,c_description,c_time_lec,c_time_lab
					) VALUES ('$courseID','$courseCode','$courseTitle','$courseDescrip',
					'$lecTime','$labTime')";
			
			mysqli_query($connection,$query);

			?>
			<p><?=$_POST['course_id']?></p>
			<p><?=$_POST['course_code']?></p>
			<p><?=$_POST['course_title']?></p>
			<p><?=$_POST['course_desc']?></p>
			<p><?=$lecTime?></p>
			<p><?=$labTime?></p>
			<?php
		}
		else if($method == "add_course"){
			$connection = getConnection();
			$userID = $_POST['user_id'];
			$courseID = $_POST['course_id'];
			
			$query = "INSERT INTO user_courses(user_id,c_id) VALUES ('$userID','$courseID')";
			
			mysqli_query($connection,$query);
			
			?>
			<p><?=$_POST['user_id']?></p>
			<p><?=$_POST['course_id']?></p>
			<?php
		}
	}


?>