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
		var user_id = $("#c_user_id").val();
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
				type: 'post',
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
	$('#lec_n').change(function(){
		var lec_n = $('#lec_n').val();
		$.ajax({
			url: 'functions.php',
			type: 'post',
			data: {method: 'lec_select', lcn: lec_n},
			success: function(data){
				$("#lec_s").html(data);
			}
		});
	});
	$('#lab_n').change(function(){
		var lab_n = $('#lab_n').val();
		$.ajax({
			url: 'functions.php',
			type: 'post',
			data: {method: 'lab_select', lbn: lab_n},
			success: function(data){
				$("#lab_s").html(data);
			}
		});
	});
	$('#course_insert').click(function(){
		var c_id = $('#c_id').val();
		var c_code = $('#c_code').val();
		var c_title = $('#c_title').val();
		var c_desc = $('#c_desc').val();
		var c_teacher = $('#c_teacher').val();
		var c_rooms_lec = $('#c_room_lec').val();
		var c_rooms_lab = $('#c_room_lab').val();
		var lections = [];
		var labs = [];

		// Formatting string for leactures 
		// example ( M.9:25,W.15:25 ) etc
		for(var i = 0; i < $('#lec_n').val(); i++){
			var lection = {
				lec_room : $('#lec_r_'+i).val(),
				lec_day : $('#lec_day_'+i).val(),
				lec_time : $('#lec_time_'+i).val(),
				lec_teacher : $('#lec_t_'+i).val()
			}
		}
		lections.push(lection);
		// Formatting string for labs
		for(var i = 0; i < $('#lab_n').val(); i++){
			var lab = {
				lab_room : $('#lab_r_'+i).val(),
				lab_day : $('#lab_day_'+i).val(),
				lab_time : $('#lab_time_'+i).val(),
				lab_teacher : $('#lab_t_'+i).val()	
			}
			labs.push(lab);
		}

		// Strings ready for DB insertion
		// lections = JSON.stringify(lections);
		// labs = JSON.stringify(labs);
		console.log(lections);
		console.log(labs);
		$.ajax({
			url: 'functions.php',
			type: 'post',
			data: {method: 'course_insert', course_id: c_id, course_code: c_code, course_title: c_title, course_desc: c_desc, lec: lections, lab: labs },
			success: function(data){
				$("#content_info").html(data);
			}
		});
	});
	$('#add_course').click(function(){
		var u_id = $('#user_id_reg').val();
		var c_id = $('#course_id_reg').val();
		$.ajax({
			url: 'functions.php',
			type: 'post',
			data: {method: 'add_course', user_id: u_id, course_id: c_id},
			success: function(data){
				$("#content_info").html(data);
			}
		});
	});
}
