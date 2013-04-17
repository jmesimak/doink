<?php 

	// Doink database handler php
	// copyright 2013 Jerry Mesimäki & Tommi Nikkanen
	
	class dbHandler {
	
	public $db;
	
		function __construct() {
			$this->db = new PDO('mysql:host=localhost;dbname=doink;charset=utf8','doink','25baUhGu');
		}
		
		public function doQuery($query) {
			return $this->db->query($query);
		}
		
		
	}

?>