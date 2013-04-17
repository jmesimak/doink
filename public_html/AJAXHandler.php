<?php 

	// Doink AJAX handler php
	// copyright 2013 Jerry Mesimäki & Tommi Nikkanen
	
	session_start();
	
	include('JSONHandler.php');
	
	if (isset($_POST['login'])) {
		if (isset($_POST['user']) && isset($_POST['pwd'])) {
			include('loginHandler.php');
			$loginHandler = new loginHandler();
			$loginData = array('login_complete'=>$loginHandler->checkLoginData($_POST['user'],$_POST['pwd']));
			echo JSON_encode($loginData);
		}
	}
	
	if (isset($_POST['logout'])) {
		if (isset($_SESSION['doink_user'])) {
			session_destroy();
		}
	}
	
	if (isset($_POST['tasks'])) {
		if (isset($_SESSION['doink_user'])) {
			include('taskHandler.php');
			$user = $_SESSION['doink_user'];
			$taskHandler = new taskHandler();
			echo JSON_encode($taskHandler->getTasks($user));
		} else {
			return false;
		}
	}
	
	if (isset($_POST['taskinfo']) && isset($_POST['taskid'])) {
		include('taskHandler.php');
		$taskHandler = new taskHandler();
		echo JSON_encode($taskHandler->getTaskInfo($_POST['taskid']));
	}
        
        if(isset($_POST['addtask']) && isset($_SESSION['doink_user']) && 
                isset($_POST['title'])) {
                include('taskHandler.php');
                $taskHandler = new taskHandler();
                $taskHandler->insertTask($_SESSION['doink_user'], $_POST['title'], null, 1);
        }

?>