<!--Experimental noteHandler.php, not in production yet.-->

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

    public function getNote($note_id) {
        $query = $this->dbConnection->db->prepare('
            SELECT * From notes
            WHERE id = ?');
        try {
            $query->execute(array($note_id));
            $returnable = $query->fetch(PDO::FETCH_ASSOC);
            return $returnable;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateNote($note_id, $content) {
        $query = $this->dbConnection->db->prepare('
            UPDATE notes
            SET note = ?
            WHERE id = ?');
        try {
            $query->execute(array($content, $note_id));
            return true;
        } catch (PDOException $e) {
            $error = ('Could not update note content. Please try again or contact the site administrators.');
            return $error;
        }
    }

}

?>
