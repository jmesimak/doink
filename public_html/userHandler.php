<?php

include 'dbHandler.php';
include 'cryptHandler.php';
include 'toolKit.php';

class userHandler {

    private $dbConnection;
    private $crypter;
    private $toolkit;

    function __construct() {
        $this->dbConnection = new dbHandler();
        $this->crypter = new cryptHandler();
        $this->toolkit = new toolKit();
    }

    public function updatePassword($email, $password) {

        $createdSalt = $this->crypter->generateRandomSalt();
        $createdPass = $this->crypter->stretchHash($password, $createdSalt);

        $query = $this->dbConnection->db->prepare('
            UPDATE users
            SET password = ?, salt = ?
            WHERE email = ?');
        try {
            $query->execute(array($createdPass, $createdSalt, $email));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

}

?>
