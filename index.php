<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AUCA inTouch</title>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script type="text/javascript" src="init.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#tabs").tabs();
		});
	</script>
</head>
<body>
	<div class="main">
		<div class="container">
			<div class="content">
				<div id="tabs">
					<ul>
						<li><a href="#tabs-1">User info</a></li>
						<li><a href="#tabs-2">User Course info</a></li>
						<li><a href="#tabs-3">Mail Sending</a></li>
						<li><a href="#tabs-4">User Notification Info</a></li>
						<li><a href="#tabs-5">Course information</a></li>
					</ul>
					<div id="tabs-1">
						<div id="registration">
							<div class="input-field"><div>Enter User ID</div><input id="user_id" type="text" name="ID"></div>

							<a id="search_by_id" href="#" class="classname">Search</a> 
							<br>
							<br>

							<div class="input-field"><div>Name</div><input id="user_name" type="text" name="user_name"></div>
							<div class="input-field"><div>Surname</div><input id="user_surname" type="text" name="user_surname"></div>
							<div class="input-field"><div>Login</div><input id="user_login" type="text" name="user_login"></div>
							<div class="input-field"><div>Password</div><input id="user_pass" type="password" name="user_pass"></div>
							<div class="input-field"><div>Confirm Password</div><input id="user_pass_confirm" type="password" name="user_pass_confirm"></div>

							<p style="display: none; color: red" id="validate_register_user">Passwords do not match or you have missed fields!</p>

							<a id="user_register" class="classname">Submit</a> 
						</div>
					</div>
					<div id="tabs-2">
						<div>
							<div>Enter User ID</div><input id="course" type="text" name="login">
							<a id="course_button" href="#" class="classname">Submit</a>
						</div>
					</div>
					<div id="tabs-3">
						<div>
							<div>Message Title:</div><input id="msg_title" type="text" name="msg_title">
							<div>Send to:</div><input id="msg_addr" type="text" name="msg_addr">
							<div>Content:</div><textarea name="msg_content" id="msg_content" cols="80" rows="10"></textarea>
						</div>
						<a id="mail_button" href="#" class="classname">Send</a> 
					</div>
					<div id="tabs-4">
						<div>
							<div class="input-field"><div>Enter ID</div><input id="user_id_notif" type="text" name="ID"></div>
						</div>
						<a id="get_notif_button" href="#" class="classname">Get info</a> 
					</div>
					<div id="tabs-5">
						<div>
							<div class="input-field"><div>Course ID</div><input id="c_id" type="text" name="C_ID"></div>
							<div class="input-field"><div>Course Code</div><input id="c_code" type="text" name="C_Code"></div>
							<div class="input-field"><div>Course Title</div><input id="c_title" type="text" name="C_Title"></div>
							<div class="input-field"><div>Course Description</div><input id="c_desc" type="text" name="C_Desc"></div>
							<div class="input-field"><div>Select number of Lections</div>
								<select name="lecs" id="lec_n">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
								<div id="lec_s">
									<table>
										<thead>
											<tr>
												<th><div>Day:</div></th>
												<th><div>Time</div></th>
											</tr>
										</thead>
										<tr><td>
										<select name="day" id="lec_day_0">
											<option value="M">Monday</option>
											<option value="T">Tuesday</option>
											<option value="W">Wednesday</option>
											<option value="Th">Thursday</option>
											<option value="F">Friday</option>
											<option value="S">Saturday</option>
										</select></td><td>
										<select name="time" id="lec_time_0">
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
									</table>
								</div>
							</div>
							<div class="input-field"><div>Select number of Labs</div>
								<select name="labs" id="lab_n">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
								<div id="lab_s">
									<table>
										<thead>
											<tr>
												<th><div>Day:</div></th>
												<th><div>Time</div></th>
											</tr>
										</thead>
										<tr><td>
										<select name="day" id="lab_day_0">
											<option value="M">Monday</option>
											<option value="T">Tuesday</option>
											<option value="W">Wednesday</option>
											<option value="Th">Thursday</option>
											<option value="F">Friday</option>
											<option value="S">Saturday</option>
										</select></td><td>
										<select name="time" id="lab_time_0">
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
									</table>
								</div>
							</div>
							<div class="input-field"><div>Teacher(s):</div><input id="c_teacher" type="text" name="Teachers"></div>
						</div>
						<a id="course_insert" href="#" class="classname">Add</a> 
					</div>
				</div>
			</div>
			<div class="content">
				<div id="content_info"></div>
			</div>
		</div>
	</div>
	 <!-- TESTING COMMENT SECTION -->
</body>
<footer></footer>
</html>