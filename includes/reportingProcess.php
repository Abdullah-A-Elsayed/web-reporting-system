<?php
if(!isset($_SESSION)){session_start();}
require_once 'db/connection.php';
require_once 'functions.php';
$id=$_SESSION['id'];
if(isset($_POST['rooms'])&&isset($_POST['visits'])&&isset($_POST['workshops'])&&isset($_POST['problems'])&&isset($_POST['comment'])){

	//straight data
	$r=addslashes($_POST['rooms']);
	$v=addslashes($_POST['visits']); // yes or no
	$w=addslashes($_POST['workshops']); // yes or no
	$p=addslashes($_POST['problems']);
	$c=addslashes($_POST['comment']);


	//WORKSHOP Data
	if($w==='yes'){
		$w_c = addslashes($_POST['workshops-comment']);
		$w_n = 1 ;
	}
	else if($w==='no'){
		$w_c = 'NULL';
		$w_n = 0 ;
	}

	//VISITS Data
	if($v==='yes'){
		$v_c = addslashes($_POST['visits-comment']);
		$v_n = $_POST['visits-n'];
	}
	else if($v==='no'){
		$v_c = 'NULL';
		$v_n = 0;
	}
	// inserting into repsorts table
	try{
			//-inserting in reports table & getting insert id
			$sql = "INSERT INTO `reports`(`user_id`, `rooms`, `visits`, `workshop`, `workshop_comment`, `visits_comment`, `problems`, `comment`, `status`) VALUES ($id , $r , $v_n ,'$w' , '$w_c' , '$v_c' , '$p' , '$c' ,'unread')";
			$stmt=$db->prepare($sql);
			$stmt->execute();
			$report_id = $db->lastInsertId();
		}
	catch(PDOException $e){
		echo $sql . "<br>" . $e->getMessage();
	}

	//rooms data
	for ($i=1; $i <= $r ; $i++) { 
		$rid=$_POST['room'.$i.'ID'];  $rid=addslashes($rid);
		$ric=$_POST['room'.$i.'comment'];  $ric=addslashes($ric);
		try{
			// inserting into rooms table
			$sql = "INSERT INTO `rooms`(`report_id`, `room_num`, `comment`) VALUES ($report_id,'$rid','$ric')";
			$stmt=$db->prepare($sql);
			$stmt->execute();
		}
		catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	// updating users table
	// rooms :
	$old_rooms = getFromUsers($id,'rooms');
	$old_visits = getFromUsers($id,'visits');
	$old_works = getFromUsers($id,'workshops');
	if(is_null($old_rooms)){
		$new_rooms = $r ;
	}
	else{
		$new_rooms = $r + $old_rooms ;
	}

	if(is_null($old_visits)){
		$new_visits = $v_n ;
	}
	else{
		$new_visits = $v_n + $old_visits ;
	}

	if(is_null($old_works)){
		$new_works = $w_n ;
	}
	else{
		$new_works = $w_n + $old_works ;
	}

	$sql = "UPDATE `users` SET `rooms`=$new_rooms,`visits`=$new_visits,`workshops`=$new_works, `status`='hasNew' WHERE id = $id";
    $stmt=$db->prepare($sql);
    $stmt->execute();

//echo "Succeed";
    $_SESSION['success']="Your Report saved successfully";
    header("location: ..");
    exit();
}
?>