$(document).ready(function(){

	/***************
	*Login user
	****************/

	$(document).on("click", "#login-button", function(e) {
		e.preventDefault();

		var valid= '';
		var required = ' is required.';
		var input_user_login = $('#input_user_login').val();
		var input_user_password = $('#input_user_password').val();
		var function_to_run = "login";

		if(input_user_login == ''){
			valid += 'Email' + required;
		}

		if(input_user_password == ''){
			valid += 'Password' + required;
		}
		if(valid !=''){
			$('#responseLog')
			.html(valid).fadeIn('fast');
			setTimeout("$('#responseLog').fadeOut('fast')",20000);
		}
		else{
			$('#responseLog').html('').append('<i class="fa fa-spinner fa-spin fa-2x"></i>');


			$.ajax({
				type: "POST",
				dataType: "json",
				url: "core/signup-login.php",
				data: {function_to_run: function_to_run, input_user_login: input_user_login, input_user_password: input_user_password},
				success: function(data){

					if(data === false)
					{

						$('.fa-spinner').remove();
						$('#responseLog').html('Wrong username or password').fadeIn('fast');	
						$('#loginPassword').val("");
					}if(data === true)
					{
						$('.fa-spinner').remove();
						$('#responseLog').html('').append('<i class="fa fa-check fa-3x"');
						setTimeout("$('#responseLog').fadeOut('fast')",2000);
						localStorage.setItem('menu','1');	
						window.location.replace("nw-main-admin.php");
					}
				},
				failure: function(){
					alert('Somthing went wrong, please try again.');
				}
				
			});	
		}
	});

	/***************
	*Registrer user
	****************/
	$(document).on("click", "#setup_reg_admin_user", function(e) {
		e.preventDefault();

		var valid = "";
		var required = " is required";
		var display_name 	= $('#setup_full_name_reg').val();
		var user_login 		= $('#setup_user_name_reg').val();
		var user_email		= $('#setup_user_email_reg').val();
		var user_pass 		= $('#setup_user_password').val();
		var user_pass2 		= $('#setup_user_password2').val();
		var function_to_run = "setup_admin_user_first";

		if(display_name == ''){
			valid = 'Full name' + required + '<br>';
		}
		if(user_login == ''){
			valid += 'Username' + required + '<br>';
		}
		if(!user_email.match(/^([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$)/i))
		{
			valid += 'Email' + required + '<br>';
		}
		if(user_pass == ''){
			valid += 'Password' + required + '<br>';
		}
		if(user_pass2 	 != user_pass){
			valid += 'Passwords do not match' + '<br>';
		}
		if(valid !=''){
			$('#responseReg')
			.html(valid).fadeIn('fast');
			setTimeout("$('#responseReg').fadeOut('fast')",20000);
		}
		else{
			$('#responseReg').html('').append('<i class="fa fa-spinner fa-spin fa-2x"></i>');


			$.ajax({
				type: "POST",
				dataType: "json",
				url: "core/signup-login.php",
				data: {function_to_run: function_to_run, display_name: display_name, user_login: user_login, user_email: user_email, user_pass: user_pass },
				success: function(data){

					if(data[1] === false)
					{

						$('.fa-spinner').remove();
						$('#responseReg').html(data[2]).fadeIn('fast');	
						
					}if(data[1] === true)
					{	
						$('.fa-spinner').remove();
						$('#responseReg').html(data[2]).fadeIn('fast');

						window.location.replace('index.php');
						setTimeout("$('input, select').val('')",2000);


					}
				},
				failure: function(){
					alert('Noe gikk galt, vennligst prøv igjen.');
				}
			});	



		}
	});	


});