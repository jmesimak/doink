<?php 

	// Doink data crypting handler php
	// copyright 2013 Jerry Mesimäki & Tommi Nikkanen
	
	class cryptHandler {
		private $globalSafetyIterator;
		
		function __construct() {
			$this->globalSafetyIterator = 32;
		}

		public function generateRandomSalt() {
			return substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(), mt_rand()))), 0, 22);
		}
		
		public function stretchHash($pass,$salt) {
			$hashed = $this->cryptMe($pass,$salt);
			for ($i = 0; $i < $this->globalSafetyIterator; $i++) {
				$hashed = $this->cryptMe($hashed.$pass.$salt,$salt);
			}
			return $hashed;
		}
		
		private function cryptMe($string,$salt) {
			$buildsalt = '$2a$07$'.$salt.'$';
			return crypt($string, $buildsalt);
		}
	
	}

?>
