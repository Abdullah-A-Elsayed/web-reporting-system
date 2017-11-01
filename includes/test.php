<?php
if(!isset($_SESSION)){session_start();}
require_once 'db/connection.php';
require_once 'functions.php';
$id=$_SESSION['id'];



	try{
			//-inserting in reports table & getting insert id
			$sql = "INSERT INTO `reports`(`user_id`, `rooms`, `visits`, `workshop`, `workshop_comment`, `visits_comment`, `problems`, `comment`) VALUES ($id , 8 , 10 ,'no' , 'nice workshop' , 'bad visit' , 'no problem' , 'nice day')";
			// $stmt=$db->prepare($sql);
			// $stmt->execute();
			// $report_id = $db->lastInsertId();
			// echo $report_id;
		}
	catch(PDOException $e){
		echo $sql . "<br>" . $e->getMessage();
	}


	
?>