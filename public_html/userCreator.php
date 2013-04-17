<?php 

	// Doink user creation php
	// copyright 2013 Jerry Mesimäki & Tommi Nikkanen
	
	include 'dbHandler.php';
	include 'cryptHandler.php';
	include 'toolKit.php';
	
	class userCreator {
		private $dbConnection;
		private $crypter;
		private $toolkit;
		
		function __construct() {
			$this->dbConnection = new dbHandler();
			$this->crypter = new cryptHandler();
			$this->toolkit = new toolKit();
		}
		
		public function newUser($email, $first, $last, $pwd) {
			if (isset($email) && isset($first) && isset($last) && isset($pwd)) {
				$createdSalt = $this->crypter->generateRandomSalt();
				$createdPass = $this->crypter->stretchHash($pwd,$createdSalt);
				
				
				$cleanFirst = $this->toolkit->fixName($first);
				$cleanLast = $this->toolkit->fixName($last);
				
				$userQuery = $this->dbConnection->db->prepare('INSERT INTO users VALUES (?,?,?,1,?,?)');
				
				try {
					$userQuery->execute(array($email, $cleanFirst, $cleanLast, $createdSalt, $createdPass));
					return true;
				} catch (PDOException $e) {
					return false;
				}
				
			}
		}
	
	}

?>