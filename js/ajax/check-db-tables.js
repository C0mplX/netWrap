$(document).ready(function(){

	$.ajax({
		type: "POST",
		dataType: "json",
		url: "core/check-db-table.php",
		data: {},
		success: function(data){

			if(data[1] === false)
			{
						
			}if(data[1] === true)
			{	
				
			}
		},
		failure: function(){
			alert('Noe gikk galt, vennligst prøv igjen.');
		}
	});	
});