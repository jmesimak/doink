// Doink core js
// copyright 2013 Jerry Mesimäki & Tommi Nikkanen

$(document).ready(function(e) {
    $('#loginButton').bind('click', function() {
        addTask();
    });

    $('#task_title, #task_description').bind('click', function() {
        $(this).val('');
    });
	
	$('#priority_label').bind('click', function() {
		console.log($('#task_priority').is(':checked'));
	});
});

function addTask() {
    var task_title = $('#task_title').val();
    var task_description = $('#task_description').val();
    var task_deadline = $('#task_deadline').val();
	var task_priority = $('#task_priority').is(':checked')+1;
    var data = 'task_title=' + task_title + '&task_description=' + task_description + '&task_deadline=' + task_deadline + '&task_priority='+ task_priority +'&addtask=1';
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
            if (result['task_added']) {
                $('#message_container').delay(300).append('<div class="messagebox"><p>Adding task</p></div>').slideDown(500);
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