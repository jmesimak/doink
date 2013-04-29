// Doink core js
// copyright 2013 Jerry Mesimäki & Tommi Nikkanen

$(document).ready(function(e) {
    $('#loginButton').bind('click', function() {
        changePassword();
    });

    $('#pwd, #pwd2').bind('click', function() {
        $(this).val('');
    });

    $('#pwd').bind('blur', function() {
        if ($(this).val() == '') {
            $(this).val();
        }
    });

});

function changePassword() {
    var pwd = $('#pwd').val();
    var pwd2 = $('#pwd2').val();
    var data = 'pwd=' + pwd + '&passchange=1';
    $('#message_container').slideUp(500);
    $('#message_container').empty();
    $("#loginForm").delay(500).slideUp(500);
    $("#loginButton").hide();
    $("#spinner").delay(1000).show();
    if (pwd != pwd2) {
        $('#message_container').delay(300).append('<div class="messagebox"><p>Passwords do not match.</p></div>').slideDown(500);
        setTimeout("location.href = 'http://doink.plop.fi/changePassword.php';", 3500);
        return;
    }
    $.ajax({
        type: "POST",
        url: "AJAXHandler.php",
        data: data,
        cache: false,
        success: function(result) {
            var result = $.parseJSON(result);
            if (result['password_changed']) {
                $('#message_container').delay(300).append('<div class="messagebox"><p>Changing password</p></div>').slideDown(500);
                setTimeout("location.href = 'http://doink.plop.fi/main.php';", 2000);
            } else {
                $('#message_container').delay(1500).append('<div class="messagebox"><p>Dude you just failed hard lol</p></div>').slideDown(500);
                $('#spinner').fadeOut(500);
                $('#loginForm').delay(1000).slideDown(500);
                $('#loginButton').delay(2100).slideDown(500);
            }
        }
    });

}