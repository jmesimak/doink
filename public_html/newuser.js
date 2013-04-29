// Doink core js
// copyright 2013 Jerry Mesimäki & Tommi Nikkanen

$(document).ready(function(e) {
    $('#loginButton').bind('click', function() {
        createUser();
    });

    $('#user, #first, #last, #pwd').bind('click', function() {
        $(this).val('');
    });

    $('#user, #first, #last, #pwd').bind('blur', function() {
        if ($(this).val() == '') {
            $(this).val(document.title);
        }
    });

});

function createUser() {
    var email = $('#user').val();
    var first = $('#first').val();
    var last = $('#last').val();
    var pwd = $('#pwd').val();
    var data = 'user='+email+'&first='+first+'&last='+last+'&pwd='+pwd+'&createuser=1';
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
        success: function(result) {
            var result = $.parseJSON(result);
            if (result['user_created']) {
                $('#message_container').delay(300).append('<div class="messagebox"><p>Creating new user</p></div>').slideDown(500);
                setTimeout("location.href = 'http://doink.plop.fi/login.php';", 2000);
            } else {
                $('#message_container').delay(1500).append('<div class="messagebox"><p>Dude you just failed hard lol</p></div>').slideDown(500);
                $('#spinner').fadeOut(500);
                $('#loginForm').delay(1000).slideDown(500);
                $('#loginButton').delay(2100).slideDown(500);
            }
        }
    });

}