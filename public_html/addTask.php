<?php
require_once('core.php');
session_start();
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Doink</title>
    <link href="doink_mq.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Maven+Pro' rel='stylesheet' type='text/css'>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="addtask.js"></script>
</head>
<body>
	    <nav id="floatmenu">
            <ul>
            	<li><a href="main.php"><div class="floatlogo"><img src="img/doink_logo_text.png"></div></a></li>
                <li><a id="menugear" href="#" class="right"><div class="floaticon"><img src="img/ico_gear.png"></div></a></li>
                <li><a href="#" class="right"><?php echo $_SESSION['doink_first']; ?></a></li>
            </ul>
        </nav>
        <div id="menushadow"><div class="endshadow"></div></div>
      <section>
       	  <form id="regularForm">
          			<div id="message_container"></div>
            	    <input name="task_title" type="text" id="task_title" value="Title">
            	    <input name="task_description" type="text" id="task_description" value="Description">
            	    <input type="datetime-local" name="deadline" id ="task_deadline">
            	    <input name="task_priority" type="checkbox" id="task_priority">
            	    <label for="task_priority" id="priority_label">Important task</label>
           	    <div id="loginButton" class="button purple">Create Task</div>
          </form>
          <div id="spinner" class="light"></div>
        </section>
</body>
</html>
