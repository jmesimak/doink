// Doink core js
// copyright 2013 Jerry Mesimäki & Tommi Nikkanen

$(document).ready(function(e) {
    $('#login').bind('click', function() {
  		doLogin();
	});
});


// login scripts

function doLogin(){
       var uname=$('#user').val();
       var password=$('#pwd').val();
       var dataString = 'user='+ uname + '&pwd='+ password;
/*       $("#flash").show();
       $("#flash").fadeIn(400).html('<img src="image/loading.gif" />');*/
       $.ajax({
             type: "POST",
             url: "AJAXHandler.php",
             data: dataString,
             cache: false,
             success: function(result){
             var result = $.trim(result);
             $("#flash").hide();
             if(result=='correct'){
                  window.location='main.php';
             }else{
                  $("#errorMessage").html(result);
             }
        }
  });
}