<?php
if(!isset($_SESSION)){session_start();}
require_once 'db/connection.php';
require_once 'functions.php';
if(isset($_POST['username'])&&isset($_POST['password'])){
	$name=addslashes($_POST['username']);
	$pass=addslashes($_POST['password']);
	$sql="SELECT * FROM `users` WHERE `username` = '$name' ";
	$stmt=$dbc->query($sql);
	if($stmt->num_rows == 1){
		foreach($stmt as $user){
			if($user['pwd']==$pass){
				$id=$_SESSION['id']=$user['id'];
				if(getFromUsers($id,'type')==='ADMIN'){
					header("location:../views/admin");
					exit;
				}
				else{ // NORMAL USER
					header("location:../views/report.php");
					exit;
				}
			}
			else{
				header("location:../?error=Wrong Password !!");
				exit;
			}
		}
	}
	else{
		header("location:../?error=Wrong user name !!");
		exit;
	}
}




?>