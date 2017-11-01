<?php
session_start();
require_once '../../includes/db/connection.php';
require_once '../../includes/functions.php';
if (!isset($_SESSION['id'])) {
   header("location:../..");
   exit();
 } else{
    $id = $_SESSION['id'];
    if(getFromUsers($id,'type')!=='ADMIN'){
      header("location:../..");
      exit();
    }
 }
 if (!isset($_GET['report_id'])) {
  $_SESSION['success'] = 'No report selected !!';
  header("location:../..");
  exit();
}
else{
  $report_id = $_GET['report_id'];
  $user_id = getFromReports_using_id_($report_id,'user_id');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link href="../../img/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<title><?php echo getFromUsers($user_id,'username'); ?> </title>
</head>
<body>
   <!-- Content here -->
  <div class="container">
  <br>
  <div id="success" style="display:none;">
    <?php 
    if (isset($_SESSION['success'])){
      echo $_SESSION['success'];
      $_SESSION['success']='';
    }
    ?>

  </div>
  
  <div id="accordion" role="tablist" aria-multiselectable="true">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <h5 class="mb-0">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <?php echo getFromReports_using_id_($report_id,'date'); ?>
        </a>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-block">
          <?php
            $rooms = getFromReports_using_id_($report_id , 'rooms');
            $visits = getFromReports_using_id_($report_id, 'visits');
            $work = getFromReports_using_id_($report_id,'workshop');//yes or no
            $problems = getFromReports_using_id_($report_id,'problems');
            $g_comment = getFromReports_using_id_($report_id,'comment');
          ?>
          <div class="row col-md-12" id = "rooms">
            <div class="col-md-4">
              Rooms Number: <?php echo $rooms; 
              if(!$rooms){
                echo "<br><br>";
              }
              ?>
            </div>
            <div class="col-md-4">
              <?php
              if($rooms){
                $r_arr = reportRooms($report_id);
                foreach ($r_arr as $room) {
                  echo "room ".$room['room_num'].".<br>";
                  echo "comment is: ".$room['comment'].".<br><br>";
                }
              }else{echo "<br>";}
              ?>
            </div>
          </div> <!-- row -->

          <div class="row col-md-12" id = "visits">
            <div class="col-md-4">
              Visits Number: <?php echo $visits; 
              if(!$visits){
                echo "<br><br>";
              }
              ?>
            </div>
            <div class="col-md-4">
              <?php
              if($visits){
                echo "comment is: ".getFromReports_using_id_($report_id,'visits_comment').".<br><br>";
              }
              ?>
            </div>
          </div> <!-- row -->
          <div class="row col-md-12" id = "warsha">
            <div class="col-md-4">
              Warsha? : <?php echo $work; 
              if($work == 'no'){
                echo "<br><br>";
              }
              ?>
            </div>
            <div class="col-md-4">
              <?php
              if($work == 'yes'){
                echo "comment is: ".getFromReports_using_id_($report_id,'workshop_comment').".<br><br>";
              }
              ?>
            </div>
          </div> <!-- row -->

          <div class="row col-md-12" id = "problems">
            <div class="col-md-4">
              problems : <?php echo $problems.'<br><br>'; ?>
            </div>
          </div> <!-- row -->

          <div class="row col-md-12" id = "g_comment">
            <div class="col-md-4">
              General Comment : <?php echo $g_comment; ?>
            </div>
          </div> <!-- row -->

          <?php
          // updating status..
          modifyReportStatus($report_id);
          modifyUserStatus($user_id);
          ?>
      </div>
    </div>
  </div>
  <!-- <div class="card">
    <div class="card-header" role="tab" id="headingTwo">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Information
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="card-block">
        
      </div>
    </div>
  </div> -->
<!--   <div class="card">
    <div class="card-header" role="tab" id="headingThree">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Write a new Report
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="card-block">
        
      </div>
    </div>
  </div> -->
</div>
      
  </div><!-- /.container -->

  <?php  require_once '../footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script type="text/javascript" src="../../js/success.js"></script>
</body>
</html>
