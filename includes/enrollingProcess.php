<?php
if(!isset($_SESSION)){session_start();}
require_once 'db/connection.php';
require_once 'functions.php';
$id=$_SESSION['id']; //admin
if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['phonenumber'])&&isset($_POST['type'])){
	$us=addslashes($_POST['username']);
	$ph=addslashes($_POST['phonenumber']);
	$pass=addslashes($_POST['password']);
	$type=addslashes($_POST['type']);
	try{
			//2-inserting user status
			$sql = "INSERT INTO `users`(`type`, `username`, `pwd`, `phonenumber`, `status`) VALUES ('$type','$us','$pass','$ph','hasNew')";
			$stmt=$db->prepare($sql);
			$stmt->execute();
			$user_id = $db->lastInsertId();
			modifyUserStatus($user_id);
			$_SESSION['success']='User Added successfully';
			header("location: ..");
			exit();
		}
	catch(PDOException $e){
		echo $sql . "<br>" . $e->getMessage();
	}
	
}
?>