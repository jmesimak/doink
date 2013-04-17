<?php 

	// Doink login handler php
	// copyright 2013 Jerry Mesimäki & Tommi Nikkanen
	
	include 'dbHandler.php';
	include 'cryptHandler.php';
	
	class loginHandler {
		private $dbConnection;
		private $crypter;
		
		function __construct() {
			$this->dbConnection = new dbHandler();
			$this->crypter = new cryptHandler();
		}
		
		public function checkLoginData($user,$pass) {
			if (isset($user) && isset($pass)) {
				$userData = $this->dbConnection->db->prepare('SELECT * FROM users WHERE email=?');
				$userData->execute(array($user));
				if ($userData->rowCount() == 1) {
					$userRow = $userData->fetch();
					if ($this->checkPass($pass,$userRow['password'],$userRow['salt'])) {
						$this->setSessionUser($user,$userRow['firstname']);
						return true;
					}
					return false;
				}
			}
			return false;
		}
		
		private function checkPass($pass,$hash,$salt) {
			if ($this->crypter->stretchHash($pass,$salt) == $hash) {
				return true;
			}
			return false;
		}
                
		public function checkIfLogged() {
			if (isset($_SESSION['doink_user'])) {
				return true;
			}
			return false;
		}
		
		private function setSessionUser($user,$first) {
			if (isset($user)) {
				$_SESSION['doink_user'] = $user;
				$_SESSION['doink_first'] = $first;
			}
		}
	
	}

?>