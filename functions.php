<?php 
	// TESTING COMMENT SECTION
	function getConnection() {
		$connection = mysqli_connect("mysql6.000webhost.com", "a7551670_auca" , "rootAUCA2014", "a7551670_auca");	

		return $connection;	
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
			$title = mysql_escape_string($title);
			
			//$addresses =  $_POST["addr"];
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
			
			
			
			
			
			/*if(!strripos(",",$addresses))
			{
			
			for($i = 0; $i < sizeof($addresses); ++$i) {
					$userID = "";
					$notificationID = "";
					$result = mysqli_query($connection,"SELECT id FROM user WHERE name = '$addresses[$i]'");
					while($row = mysqli_fetch_array($result))
					{
						$userID = $row['id']; 
					}
					
					$result = mysqli_query($connection,"SELECT id FROM notification WHERE title = '$title'");
					
					while($row = mysqli_fetch_array($result))
					{
						$notificationID = $row['id']; 
					}
					
					$status = "unread";
					
					$query = "INSERT INTO usernotif(userID,notificationID,notification_status) VALUES('$userID','$notificationID','$status')";
					mysqli_query($connection, $query);
				
				}
				}	
				else
				{
						$userID = "";
						$notificationID = "";
						$result = mysqli_query($connection,"SELECT id FROM user WHERE name = '$addresses'");
						while($row = mysqli_fetch_array($result))
						{
							$userID = $row['id']; 
						}
						
						$result = mysqli_query($connection,"SELECT id FROM notification WHERE title = '$title'");
						
						while($row = mysqli_fetch_array($result))
						{
							$notificationID = $row['id']; 
						}
						
						$status = "unread";
						
						$query = "INSERT INTO usernotif(userID,notificationID,notification_status) VALUES('$userID','$notificationID','$status')";
						mysqli_query($connection, $query);
				}*/
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
						<th><div>Day:</div></th>
						<th><div>Time</div></th>
					</tr>
				</thead>
			<?php
			for($i = 0; $i < $num; $i++){
				?>
				<tr><td>
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
						<th><div>Day:</div></th>
						<th><div>Time</div></th>
					</tr>
				</thead>
			<?php
			for($i = 0; $i < $num; $i++){
				?>
				<tr><td>
				<select name="day" id="lab_day_<?=$i?>">
					<option value="M">Monday</option>
					<option value="T">Tuesday</option>
					<option value="W">Wednesday</option>
					<option value="Th">Thursday</option>
					<option value="F">Friday</option>
					<option value="S">Saturday</option>
				</select></td><td>
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
			$roomLec = $_POST['course_lr'];
			$roomLab = $_POST['course_lbr'];
			$lecTime = $_POST['lec'];
			$labTime = $_POST['lab'];
			$courseTeacher = $_POST['course_teacher'];
			
			$query = "INSERT INTO course_info(c_id,c_code,c_title,c_description,c_room_lec,c_room_lab,c_time_lec,c_time_lab,
					c_teacher) VALUES ('$courseID','$courseCode','$courseTitle','$courseDescrip','$roomLec','$roomLab',
					'$lecTime','$labTime','$courseTeacher')";
			
			mysqli_query($connection,$query);
			?>
			<p><?=$_POST['course_id']?></p>
			<p><?=$_POST['course_code']?></p>
			<p><?=$_POST['course_title']?></p>
			<p><?=$_POST['course_desc']?></p>
			<p><?=$_POST['course_lr']?></p>
			<p><?=$_POST['lec']?></p>
			<p><?=$_POST['course_lbr']?></p>
			<p><?=$_POST['lab']?></p>
			<p><?=$_POST['course_teacher']?></p>
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