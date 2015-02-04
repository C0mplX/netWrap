$(document).ready(function(){

	/**
	*Function to show alert message upon post delete. 
	*/
	var delete_post_flag = false;
	$('#delete_post').on("click", function(e){
		if(delete_post_flag === true){
			delete_post_flag = false;
			return;
		}

		e.preventDefault(e);	
		var r = window.confirm("Delete this post?");
		if (r == true) {
		    delete_post_flag = true;
		    $(this).trigger('click');
		} else {
		    
		}
	});

	/**
	*Function to show alert message upon page delete. 
	*/
	var delete_page_flag = false;
	$('#delete_page').on("click", function(e){
		if(delete_page_flag === true){
			delete_page_flag = false;
			return;
		}

		e.preventDefault(e);	
		var r = window.confirm("Delete this page?");
		if (r == true) {
		    delete_page_flag = true;
		    $(this).trigger('click');
		} else {
		    
		}
	});
});