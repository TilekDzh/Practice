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
			
			$addresses =  $_POST["addr"];
			$content = $_POST['content'];
			
			try {

			$query = "INSERT INTO notification(title,content) VALUES('$title','$content')";
			mysqli_query($connection, $query);
			$addresses = explode(",",$addresses);
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
					<p>Addresses are: <?=$addresses ?></p>
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

			//Notification processes here
			//$_GET['user_id']
			?>
				<p>This is how you print things</p>
			<?php
			
		}
	}


?>