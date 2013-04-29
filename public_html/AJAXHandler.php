<?php

// Doink AJAX handler php
// copyright 2013 Jerry Mesimäki & Tommi Nikkanen

session_start();

include('JSONHandler.php');

if (isset($_POST['login'])) {
    if (isset($_POST['user']) && isset($_POST['pwd'])) {
        include('loginHandler.php');
        $loginHandler = new loginHandler();
        $loginData = array('login_complete' => $loginHandler->checkLoginData($_POST['user'], $_POST['pwd']));
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

if (isset($_POST['addtask'])) {
    if (isset($_SESSION['doink_user'])) {
        include('taskHandler.php');
        $taskHandler = new taskHandler();
        $taskData = array('task_added' => $taskHandler->insertTaskWithDeadline($_SESSION['doink_user'], $_POST['task_title'], $_POST['task_description'], $_POST['task_priority'], $_POST['task_deadline']));
        echo json_encode($taskData);
    } else {
        return false;
    }
}

if (isset($_POST['createuser'])) {
    include('userCreator.php');
    $puppetmaster = new userCreator();
    $userData = array('user_created' => $puppetmaster->newUser($_POST['user'], $_POST['first'], $_POST['last'], $_POST['pwd']));
    echo json_encode($userData);
}

if (isset($_POST['passchange'])) {
    include('userHandler.php');
    $userManipulator = new userHandler();
    $passwordData = array('password_changed' => $userManipulator->updatePassword($_SESSION['doink_user'], $_POST['pwd']));
    echo json_encode($passwordData);
}

if (isset($_POST['removetask'])) {
    include('taskHandler.php');
    $hanska = new taskHandler();
    $hanskanJutut = array('task_removed' => $hanska->removeTask($_POST['taskid']));
    echo json_encode($hanskanJutut);
}

if (isset($_POST['completetask'])) {
    include('taskHandler.php');
    $hanska = new taskHandler();
    $hanskanJutut = array('task_completed' => $hanska->markAsCompleted($_POST['taskid']));
    echo json_encode($hanskanJutut);
}
?>