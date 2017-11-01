<?php
session_start();
require_once 'db/connection.php';
require_once 'functions.php';
if (!isset($_SESSION['id'])) {
   header("location:..");
   exit();
 } else{
    $id = $_SESSION['id'];
    if(getFromUsers($id,'type')!=='ADMIN'){
      header("location:..");
      exit();
    }
 }
 if (!isset($_GET['id'])) {
  $_SESSION['success'] = 'No user selected !!';
  header("location:..");
  exit();
}
else{ // admin and user in get
  $user_id = $_GET['id'];
  $reps = userReports($user_id);
  if(!$reps){ //user has no reps
    $sql = "DELETE FROM `users` WHERE id = $user_id";
    $stmt=$db->prepare($sql);
    $stmt->execute();
    $_SESSION['success']="user deleted successfully";
    header("location:..");
    exit();
  }
  else{ // user has reps
    foreach ($reps as $rep) {
      $rooms = reportRooms($rep['id']);
      $rep_id = $rep['id'];
      if (!$rooms) { // rep has no rooms
        $sql = "DELETE FROM `reports` WHERE id=$rep_id";
        $stmt=$db->prepare($sql);
        $stmt->execute();
      }
      else{ //delete rooms then rep
        foreach ($rooms as $room) {
          $room_id = $room['id'];
          $sql = "DELETE FROM `rooms` WHERE id=$room_id";
          $stmt=$db->prepare($sql);
          $stmt->execute();
        }
        // delete rep after rooms deleted
        $sql = "DELETE FROM `reports` WHERE id=$rep_id";
        $stmt=$db->prepare($sql);
        $stmt->execute();
      }
    } //of reps forloop -- all reps deleted
    // deleting user :
    $sql = "DELETE FROM `users` WHERE id=$user_id";
    $stmt=$db->prepare($sql);
    $stmt->execute();
    $_SESSION['success']="user deleted successfully";
    header("location:..");
    exit();
  }
}
?>