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
            SELECT id, task_title, task_priority  From tasks 
            WHERE task_owner = ?
            ORDER BY task_deadline ASC');
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

}

?>
