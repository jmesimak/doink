// Doink core js
// copyright 2013 Jerry Mesimäki & Tommi Nikkanen

$(document).ready(function(e) {
    $('#loginButton').bind('click', function() {
  		doLogin();
	});
	
	$('#user, #pwd').bind('click',function() {
		$(this).val('');
	});
	
	$('#user, #pwd').bind('blur',function() {
		if ($(this).val()=='') {
			$(this).val('email');
		}
	});
	
});


// login scripts

function doLogin(){
       var uname=$('#user').val();
       var password=$('#pwd').val();
       var data = 'user='+ uname + '&pwd='+ password + '&login=1';
	   $('#message_container').slideUp(500);
	   $('#message_container').empty();
	   $("#loginForm").delay(500).slideUp(500);
	   $("#loginButton").hide();
	   $("#spinner").delay(1000).show();
       $.ajax({
             type: "POST",
             url: "AJAXHandler.php",
             data: data,
             cache: false,
             success: function(result){
				 var result = $.parseJSON(result);
				 if(result['login_complete']){
					  window.location='main.php';
				 } else {
					  $('#message_container').delay(1500).append('<div class="messagebox"><p>Login failed, please check your email and password and try again!</p></div>').slideDown(500);
				 	  $('#spinner').fadeOut(500);
					  $('#loginForm').delay(1000).slideDown(500);
					  $('#loginButton').delay(2100).slideDown(500);
					  
				 }
       		 }
  	   });
}