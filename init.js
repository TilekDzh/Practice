window.onload = function(){

	$('#search_by_id').click(function(data){

		var user_id = $("#user_id").val();
		console.log($("#user_id").val());
		if(user_id != ""){
			$.ajax({
				url: 'functions.php',
				type: 'post',
				data: {method: 'get_profile_info', id: user_id},
				success: function(data){
					console.log("finished");
					$("#content_info").html(data);
				}
			});
		}else{
			// Throw exception
		}
	});

	$('#user_register').click(function(data){

		var user_name = $("#user_name").val();
		var user_surname = $("#user_surname").val();
		var user_login = $("#user_login").val();
		var user_pass = $("#user_pass").val();
		var user_pass_confirm = $("#user_pass_confirm").val();

		console.log("info for register: " + user_name + " " + user_surname + " " 
								+ user_login + " " + user_pass + " " + user_pass_confirm);

		var is_valid = user_name != "" && user_surname != "" && user_login != "" && 
							user_pass != "" && user_pass == user_pass_confirm;

		if(is_valid){
			$("#validate_register_user").css("display", "none");
			$.ajax({
				url: 'functions.php',
				type: 'post',
				data: {method: 'get_register_user', user_name: user_name, 
												user_surname: user_surname, 
												user_login: user_login, 
												user_pass: user_pass },
				success: function(data){
					console.log("finished");
					$("#content_info").html(data);
				}
			});
		}else{
			$("#validate_register_user").css("display", "");
		}
	});

	$('#course_button').click(function(){
		console.log('click')
		var user_id = $("#profile").val();
		if(user_id != ""){
			$.ajax({
				url: 'functions.php',
				type: 'post',
				data: {method: 'get_course_info', id: user_id},
				success: function(data){
					$("#content_info").html(data);

				}
			});
		}else{
			//Throw exception
		}
	});
	$('#mail_button').click(function(){
		console.log('click');
		var title = $("#msg_title").val();
		var addr = $("#msg_addr").val();
		var content = $("#msg_content").val();
		if(title != "" && addr != "" && content != ""){
			$.ajax({
				url: 'functions.php',
				type: 'post',
				data: {method: 'mail_sending', title: title, addr: addr, content: content},
				success: function(data){
					$("#content_info").html(data);
				}
			});
		}else{
			//Throw exception
		}
	});

	$('#get_notif_button').click(function(){
		var user_id = $("#user_id_notif").val();
		console.log($("#user_id_notif").val());
		if(user_id != ""){
			$.ajax({
				url: 'functions.php',
<<<<<<< HEAD
				type: 'post',
=======
				type: 'get',
>>>>>>> 675d6a0d7fb82406a624b7a59d7c38dcf3c68347
				data: {method: 'get_notification_info', id: user_id},
				success: function(data){
					console.log("finished");
					$("#content_info").html(data);
				}
			});
		}else{
			// Throw exception
		}
	});
}