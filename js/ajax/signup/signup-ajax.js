/***************
*Registrer user
****************/
$(document).on("click", "#registration-button", function(e) {
		 e.preventDefault();

		var valid = "";
		var nickname = $('#signupNick').val();
		var email = $('#signupEmail').val();
		var password = $('#signupPassword').val();
		var valPassword = $('#signupPasswordRe').val();
		var function_to_run = "registration";

		if(nickname == ''){
			valid = '<li class="controls">Kallenavn må fylles ut</li>';
			}
		if(email == ''){
			valid += '<li class="controls">Epost må fylles ut</li>';
			}
		if(!email.match(/^([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$)/i))
			{
			valid += '<li class="controls">Dette er ikke en epost adresse.</li>';
			}
		if(password == ''){
			valid += '<li class="controls">Passord må fylles ut</li>';
			}
		if(valPassword != password){
			valid += '<li class="controls">Passord matcher ikke.</li>';
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
				data: {function_to_run: function_to_run, nickname: nickname, email: email, password: password},
				success: function(data){
					
					if(data[1] === false)
					{
						
						$('.fa-spinner').remove();
						$('#responseReg').html(data[2]).fadeIn('fast');	
					
					}if(data[1] === true)
					{	
						$('.fa-spinner').remove();
						$('#responseReg').html(data[2]).fadeIn('fast');
							
						setTimeout("$('input, select').val('')",2000);
							
					}
				},
				failure: function(){
					alert('Noe gikk galt, vennligst prøv igjen.');
				}
			});	
				

				
				}
});

/***************
*Login user
****************/

$(document).on("click", "#login-button", function(e) {
	e.preventDefault();

	var valid= '';
	var required = ' må fylles ut.';
	var email = $('#inputEmail').val();
	var password = $('#inputPassword').val();
	var function_to_run = "login";

	if(email == ''){
		valid += '<li>Epost' + required + '</li>';
	}

	if(password == ''){
		valid += '<li>Passord' + required + '</li>';
	}
	if(valid !=''){
		$('#responseLog').removeClass().addClass('error')
		.html(valid).fadeIn('fast');
		setTimeout("$('#responseLog').fadeOut('fast')",20000);
	}
	else{
		$('#responseLog').html('').append('<i class="fa fa-spinner fa-spin fa-2x"></i>');


		$.ajax({
			type: "POST",
			dataType: "json",
			url: "core/signup-login.php",
			data: {function_to_run: function_to_run, email: email, password: password},
			success: function(data){

				if(data === false)
				{

					$('.fa-spinner').remove();
					$('#responseLog').html('<li>feil epost eller passord</li>').fadeIn('fast');	
					$('#loginPassword').val("");
				}if(data === true)
				{
					$('.fa-spinner').remove();
					$('#responseLog').html('').append('<i class="fa fa-check fa-3x"');
					setTimeout("$('#responseLog').fadeOut('fast')",2000);
					localStorage.setItem('menu','1');	
					window.location.replace("main.php");
				}
			},
			failure: function(){
				alert('Somthing went wrong, please try again.');
			}
			
		});	
	}
});	
