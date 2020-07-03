<?php

	date_default_timezone_set('Asia/Manila');
	

	$servername = 'localhost';
	$username = 'root';
	$password = '';

	try{
		$conn = new PDO("mysql:host=$servername;dbname=web_directory_database;charset=utf8",$username,$password);
	}catch(PDOException $e){
		echo $sql . "No connection".$e->getMessage();
		
	}
?>