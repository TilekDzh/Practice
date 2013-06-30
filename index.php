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
				</div>
			</div>
			<div class="content">
				<div id="content_info"></div>
			</div>
		</div>
	</div>
</body>
<footer></footer>
</html>