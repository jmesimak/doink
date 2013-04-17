<?php
require_once('core.php');
session_start();

if (!isset($_SESSION['doink_user'])) {
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width">
    <title>Doink</title>
    <link href="doink_mq.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Maven+Pro' rel='stylesheet' type='text/css'>
    <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="main.js"></script>
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
        <section id="taskarea">
        </section>
        <nav id="floatfootermenu">
        	<ul>
            	<li><a id="menugear" href="#"><div class="floaticon"><img src="img/ico_add.png"></div></a></li>
            </ul>
        </nav>
</body>
</html>
