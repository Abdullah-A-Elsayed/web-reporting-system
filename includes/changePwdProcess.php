<?php
if(!isset($_SESSION)){session_start();}
require_once 'db/connection.php';
require_once 'functions.php';
$id=$_SESSION['id'];
if(isset($_POST['new1'])&&isset($_POST['password'])&&isset($_POST['new2'])){
	$new1=addslashes($_POST['new1']);
	$new2=addslashes($_POST['new2']);
	$pass=addslashes($_POST['password']);
	$error=changePwd($id,$pass,$new1,$new2);
	if (empty($error)) {
		header("location: ..");
		exit();
	}
	else{
		header("location: ../views/changePwd.php?error=".$error);
		exit();
	}
}
?>