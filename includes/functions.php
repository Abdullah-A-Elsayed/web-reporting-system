<?php
require_once 'db/connection.php';

function nullToZero($val){
    if(is_null($val)){
        return 0 ;
    }
    else{
        return $val;
    }
}

// SINGLE GETTERS ..
function getFromUsers($id,$column){
	// username , pwd , phonenumber , rooms , visits , type
    global $db;
	$sql="SELECT $column FROM users WHERE `id`='$id'";
    $stmt=$db->query($sql);
    foreach ($stmt as $selected) {
        return $selected[$column];
    }
}
function getFromReports_using_date_($user_id,$date,$column){
	// id (of report) ,problems , comment , workshop , rooms (num) , visits (num)
	global $db;
    $sql="SELECT `$column` FROM reports WHERE `date`='$date' AND `user_id`='$user_id'";
    $stmt=$db->query($sql);
    foreach ($stmt as $selected) {
        return $selected[$column];
    }
}
function getFromReports_using_id_($id,$column){
	// date (of report) ,problems , comment , workshop , rooms (num) , visits (num)
	global $db;
    $sql="SELECT `$column` FROM reports WHERE `id`='$id'";
    $stmt=$db->query($sql);
    foreach ($stmt as $selected) {
        return $selected[$column];
    }
}
function getFromRooms($user_id,$report_id,$column){
	// room_num , comment , id (room)
	global $db;
    $sql="SELECT `$column` FROM rooms WHERE `report_id`='$report_id' AND `user_id`='$user_id'";
    $stmt=$db->query($sql);
    foreach ($stmt as $selected) {
        return $selected[$column];
    }
}
// RELATIONS GETTERS ..
function reportRooms($report_id){ // return fetshed or zero
    global $db;
    $sql="SELECT * FROM rooms WHERE `report_id`='$report_id'";
    $stmt=$db->query($sql);
     if($stmt->rowCount()){
        $stmt = $stmt->fetchAll();
        return $stmt;
    }
    else{
        return 0 ;
    }
}

function userReports($id){ // return fetshed or zero
	global $db;
    $sql="SELECT * FROM reports WHERE `user_id`='$id'";
    $stmt=$db->query($sql);
    if($stmt->rowCount()){
        $stmt = $stmt->fetchAll();
        return $stmt;
    }
    else{
        return 0 ;
    }
}



function linesNum($stmt_FETCHED){
    $n = 0 ;
    if($stmt_FETCHED!==0){
        foreach ($stmt_FETCHED as $value) {
            $n++ ;
        }
    }
    return $n ;
}

function getAllUsers(){ // return (fetched users) or (zero) using (row count)
    global $db;
    $sql="SELECT * FROM users WHERE `type`='USER'";
    $stmt=$db->query($sql); 
    if($stmt->rowCount()){
        $arr = $stmt->fetchAll() ;
        return $arr ;
    }
    else{
        return 0 ;
    }
}



function score($id)
{
    return nullToZero(getFromUsers($id,'rooms'))+nullToZero(getFromUsers($id,'visits'))+nullToZero(getFromUsers($id,'workshops'));
}

function arrange($s){ // recieves fetched
    if (linesNum($s)!==0) {
        for ($i=0; $i < linesNum($s) ; $i++) { 
            for($v=$i+1; $v < linesNum($s) ; $v++){
                if(score($s[$i]['id'])<score($s[$v]['id'])) {
                    $temp = $s[$i];
                    $s[$i] = $s[$v] ;
                    $s[$v] = $temp ;
                }
            }
        }
        return $s;
    }
    else{
            return 0;
    }
}
////////////////////
// password changing
function changePwd($id , $old , $new1 , $new2){
    global $db;
    $realOld=getFromUsers($id , 'pwd');
    if ($realOld!==$old) {
        return 'Wrong current password!';
    }
    else if ($new1!==$new2) {
         return 'No Match!';
    }
    else{
        $sql = "UPDATE `users` SET `pwd`='$new1' WHERE id = $id";
        $stmt=$db->prepare($sql);
        $stmt->execute();
        //echo $stmt->rowCount();
        return '';
    }
}
//  detecting new reports 

function isRead($report_id){
    $status = getFromReports_using_id_($report_id,'status');
    if ($status === 'read') {
        return 1 ;
    }
    else if($status === 'unread'){
        return 0 ;
    }
}

function modifyReportStatus($report_id){
    global $db;
    if(!isRead($report_id)){
        $sql = "UPDATE `reports` SET `status`='read' WHERE id = $report_id";
        $stmt=$db->prepare($sql);
        $stmt->execute();
    }
}

function hasNew($id){
    $s = getFromUsers($id , 'status');
    if ($s === 'hasNew') {
        return 1 ;
    }
    else if($s === 'noNew'){
        return 0 ;
    }
}

function unreadReports($id){ // return fetshed or zero
    global $db;
    $sql="SELECT * FROM reports WHERE `user_id`='$id' AND `status`='unread'";
    $stmt=$db->query($sql);
    if($stmt->rowCount()){
        $stmt = $stmt->fetchAll();
        return $stmt;
    }
    else{
        return 0 ;
    }
}

function modifyUserStatus($id){ // initially hasNew
    global $db;
    $unreps = unreadReports($id) ;
    if (linesNum($unreps)) { // unread reps exist
        // user already hasNew ...
    }
    else{
        // changing it to noNew
        $sql = "UPDATE `users` SET `status`='noNew' WHERE id = $id";
        $stmt=$db->prepare($sql);
        $stmt->execute();
    }
}
// BIG NOTE >> 1- WHEN USE FETCH ALL STMT DECREASES UNTILL REACHES ZERO LENGTH
            // 2- when using for each stmt decreases untill zero .. IMPORTANT
?>