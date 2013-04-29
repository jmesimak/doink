// Doink core js
// copyright 2013 Jerry Mesimäki & Tommi Nikkanen

$(document).ready(function(e) {
    $('#taskarea').css('top', $('#floatmenu').outerHeight());
    $('#menushadow').css('top', $('#floatmenu').outerHeight());
    $('#menugear').bind('click', function() {
        $('body').append(function() {
            return $("<div class='curtain'><div class='curtainmenu'></div></div>");
        });
        populateMenu();
    });
    getTasks();

    $(window).bind('scroll', function() {
        if ($(this).scrollTop() > 10) {
            $("#menushadow").fadeIn(300);
        } else if ($(this).scrollTop() <= 10) {
            $("#menushadow").fadeOut(300);
        }
    });

});

function doLogout() {
    var data = 'logout=1';
    $.ajax({
        type: "POST",
        url: "AJAXHandler.php",
        cache: false,
        data: data,
        success: function() {
            window.location = "login.php";
        }
    });
}

function getTasks() {
    var data = 'tasks=1';
    $.ajax({
        type: "POST",
        url: "AJAXHandler.php",
        data: data,
        cache: false,
        success: function(result) {
            if (result != null) {
                var result = $.parseJSON(result);
                $.each(result, function(key, value) {
                    var selector = "";
                    if (value['task_priority'] > 1 && value['task_complete'] != 1) {
                        selector = "class='highpriority'";
                    }
                    var fader = "";
                    if (value['task_complete'] == 1) {
                        fader = " fade";
                    }
                    $('#taskarea').append(function() {
                        return $('<article taskid="' + value['id'] + '" class="task' + fader + '"><p ' + selector + '>' + value['task_title'] + '</p></article>').click(showInfoPanel);
                    });
                });
            } else {
                console.log('Failboat!');
            }
        }
    });
}

function getInfo(elementToAppend, id) {
    elementToAppend.append('<div class="infopanel"></div>');
    var data = 'taskinfo=1&taskid=' + id;
    $.ajax({
        type: "POST",
        url: "AJAXHandler.php",
        data: data,
        cache: false,
        success: function(result) {
            if (result != null) {
                var result = $.parseJSON(result);
                if (result['task_description'] != null) {
                    var desc = '<p class="desc">' + result['task_description'] + '</p>';
                } else {
                    var desc = "";
                }
                $(".infopanel", elementToAppend).append('<p class="cal">' + result['task_deadline'] + desc);
                $(".infopanel", elementToAppend).append(function() {
                    return $('<div class="infobutton comp">Mark as completed</div>').bind('click', function() {
                        completeTask(id);
                    });
                });
                $(".infopanel", elementToAppend).append(function() {
                    return $('<div class="infobutton del">Delete</div>').bind('click', function() {
                        removeTask(id);
                    });
                });
                $(".infopanel", elementToAppend).slideDown(200);
            }
        }
    });

}

function addTask() {
    var data = 'addtask=1';
    $.ajax({
        type: "POST",
        url: "AJAXHandler.php",
        data: data,
        cache: false,
        success: function(result) {
            if (result != null) {
                var result = $.parseJSON(result);
                $.each(result, function(key, value) {
                    var selector = "";
                    if (value['task_priority'] > 1) {
                        selector = " class='highpriority'";
                    }
                    $('#taskarea').append(function() {
                        return $('<article taskid="' + value['id'] + '" class="task"><p' + selector + '>' + value['task_title'] + '</p></article>').click(showInfoPanel);
                    });
                });
            } else {
                console.log('Failboat!');
            }
        }
    });
}

function completeTask(id) {
    var data = 'completetask=1&taskid=' + id + '';
    $.ajax({
        type: "POST",
        url: "AJAXHandler.php",
        data: data,
        cache: false,
        success: function(result) {
            if (result != null) {
                $('article[taskid=' + id + ']').slideUp('fast', function() {
                    $('article[taskid=' + id + ']').appendTo('#taskarea').css('opacity', 0.3).slideDown('fast');
                });
                $('article[taskid=' + id + '] infobutton comp').remove();
            } else {
                console.log('Failboat!');
            }
        }
    });
}

function removeTask(id) {
    var data = 'removetask=1&taskid=' + id + '';
    $.ajax({
        type: "POST",
        url: "AJAXHandler.php",
        data: data,
        cache: false,
        success: function(result) {
            if (result != null) {
                $('article[taskid=' + id + ']').slideUp('fast', function() {
                    $('article[taskid=' + id + ']').remove();
                });
            } else {
                console.log('Failboat!');
            }
        }
    });
}

function showInfoPanel() {
    if ($(".infopanel", this).length == 0) {
        getInfo($(this), $(this).attr('taskid'));
    } else {
        $(".infopanel", this).slideToggle(200);
    }
    $(this).toggleClass("hl");
}

function populateMenu() {
    $('.curtainmenu').append(function() {
        return $('<div id="button_logout" class="button red">Logout</div>').on('click', function() {
            doLogout();
        });
    });
    $('.curtainmenu').append(function() {
        return $('<div id="button_logout" class="button red">Change Password</div>').on('click', function() {
            location.href = 'http://doink.plop.fi/changePassword.php';
        });
    });
    $('.curtainmenu').append(function() {
        return $('<div id="button_logout" class="button secondary">Close</div>').on('click', function() {
            location.href = 'http://doink.plop.fi/main.php';
        });
    });
}