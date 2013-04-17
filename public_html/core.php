<?php 

	// Doink core php
	// copyright 2013 Jerry Mesimäki & Tommi Nikkanen
	
	function __autoload($class_name) {
		include $class_name . '.php';
	}

?>