<?php

// Doink data crypting handler php
// copyright 2013 Jerry Mesimäki & Tommi Nikkanen

include('dbHandler.php');

class taskHandler {

    private $dbConnection;

    function __construct() {
        $this->dbConnection = new dbHandler();
    }

    public function getTasks($email) {

        $query = $this->dbConnection->db->prepare('
            SELECT id, task_title, task_priority, task_complete  From tasks 
            WHERE task_owner = ?
            ORDER BY task_complete, task_deadline ASC');
        try {
            $query->execute(array($email));
            $returnable = $query->fetchAll(PDO::FETCH_ASSOC);
            return $returnable;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getTaskInfo($taskID) {
        $query = $this->dbConnection->db->prepare('
			SELECT * FROM tasks WHERE id = ? AND task_owner = ? LIMIT 0,1');
        try {
            $query->execute(array($taskID, $_SESSION['doink_user']));
            $returnable = $query->fetch(PDO::FETCH_ASSOC);
            return $returnable;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insertTask($email, $title, $description, $priority) {

        $query = $this->dbConnection->db->prepare('
            INSERT INTO tasks
            (task_title, task_description, task_priority, task_owner, task_complete, task_add_date) 
            VALUES (?,?,?,?,0,now())');

        try {
            $query->execute(array($title, $description, $priority, $email));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insertTaskWithDeadline($email, $title, $description, $priority, $deadline) {

        $query = $this->dbConnection->db->prepare('
            INSERT INTO tasks
            (task_title, task_description, task_priority, task_owner, task_complete, task_add_date, task_deadline) 
            VALUES (?,?,?,?,0,now(),?)');

        try {
            $query->execute(array($title, $description, $priority, $email, $deadline));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function markAsCompleted($task_id) {
        $query = $this->dbConnection->db->prepare('
                    UPDATE tasks
                    set task_complete=1, task_completed = now() 
                    where id=?');
        try {
            $query->execute(array($task_id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function isComplete($task_id) {
        $query = $this->dbConnection->db->prepare('
                    Select task_complete
                    From tasks 
                    where id=?');
        try {
            $query->execute(array($task_id));
            $returnable = $query->fetch(PDO::FETCH_ASSOC);
            return $returnable;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function markAsInProgress($task_id) {
        $query = $this->dbConnection->db->prepare('
                    UPDATE tasks
                    set task_complete=0, task_completed = null 
                    where id=?');
        try {
            $query->execute(array($task_id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function setTaskDeadline($task_id, $datestring) {
        $date = date("Y-m-d", strtotime($datestring));
        echo $date;

        $query = $this->dbConnection->db->prepare('
                    UPDATE tasks
                    set task_deadline=?
                    where id=?');
        try {
            $query->execute(array($date, $task_id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function removeTask($task_id) {
        $query = $this->dbConnection->db->prepare('
            DELETE FROM tasks
            where id = ?');
        try {
            $query->execute(array($task_id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateTaskDescription($task_id, $description) {
        $query = $this->dbConnection->db->prepare('
            UPDATE tasks
            SET task_description = ?
            WHERE id = ?');
        try {
            $query->execute(array($description, $task_id));
            return true;
        } catch (PDOException $e) {
            $error = ('Could not update task description. Please try again or contact the site administrators.');
            return $error;
        }
    }

    public function updateTaskPriority($task_id, $priority) {
        $query = $this->dbConnection->db->prepare('
            UPDATE tasks
            SET task_priority = ?
            WHERE id = ?');
        try {
            $query->execute(array($priority, $task_id));
            return true;
        } catch (PDOException $e) {
            $error = ('Could not update task priority. Please try again or contact the site administrators.');
            return $error;
        }
    }

    public function updateTaskTitle($task_id, $title) {
        $query = $this->dbConnection->db->prepare('
            UPDATE tasks
            SET task_title = ?
            WHERE id = ?');
        try {
            $query->execute(array($title, $task_id));
            return true;
        } catch (PDOException $e) {
            $error = ('Could not update task title. Please try again or contact the site administrators.');
            return $error;
        }
    }

}

?>
