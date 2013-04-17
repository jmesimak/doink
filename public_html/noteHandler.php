<?php

include('dbHandler.php');

class noteHandler {

    private $dbConnection;

    function __construct() {
        $this->dbConnection = new dbHandler();
    }

    public function createNote($task_id, $content, $email) {
        $query = $this->dbConnection->db->prepare('
            INSERT INTO notes
            (task_id, note, note_edit_date, note_owner) 
            VALUES (?,?,now(),?)');

        try {
            $query->execute(array($task_id, $content, $email));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getNote($task_id) {
        $query = $this->dbConnection->db->prepare('
            SELECT * From notes
            WHERE task_id = ?');
        try {
            $query->execute(array($task_id));
            $returnable = $query->fetchAll();
            echo $returnable;
            return $returnable;
        } catch (PDOException $e) {
            return false;
        }
    }

}

?>
