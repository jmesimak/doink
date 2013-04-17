<?php
require_once('core.php');

session_start();

if (isset($_SESSION['doink_user'])) {
    header('Location: main.php');
}
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Doink</title>
    <link href="doink_mq.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Maven+Pro' rel='stylesheet' type='text/css'>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="login.js"></script>
</head>
<body class="login">
    <div id="container">
    	<header>
        	<div id="logo_container">
				<img src="img/doink_logo_text.png" id="logo">
            </div>
        </header>
      <section>
      	<div id="message_container"></div>
       	  <form id="loginForm">
            	<input name="user" type="text" id="user" value="email">
            	<input name="pwd" type="password" id="pwd" value="password">
            	<div id="loginButton" class="button">Login</div>
          </form>
          <div id="spinner" class="light"></div>
        </section>
    </div>
</body>
</html>
