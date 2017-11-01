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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link href="../../img/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<title><?php echo getFromUsers($id,'username');?></title>
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
          Settings
        </a>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-block">
        <a href="addUsers.php" >Add Members</a><br>
        <a href="deleteUser.php">Delete Members</a><br>
        <a href="../changePwd.php">Change Password</a><br>
      <a href="../../includes/logOut.php">LOG OUT</a>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingTwo">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Information
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="card-block">
        <?php 
          $users = getAllUsers();
          $users = arrange($users);
          if(linesNum($users)){
            echo "<ol>";
            foreach ($users as $user) {
              echo "<li>";
                $username = "<a style = '";
                if (hasNew($user['id'])) {
                  $username = $username ."font-style:italic;font-weight: bold;";
                }
                $username = $username."' target='_blank' href=\"singleUser.php?user_id=".$user['id']."\">".$user['username']." (".score($user['id']).")</a><br>";
                echo $username;
                echo "Phone Number : ".$user['phonenumber'];
                echo "<br>Password : ".$user['pwd'];
                echo "<ul>";
                  echo "<li>".nullToZero($user['rooms']) ." room(s)</li>";
                  echo "<li>".nullToZero($user['visits']) ." visit(s)</li>";
                  echo "<li>".nullToZero($user['workshops']) ." Warsha(s)</li>";
                echo "</ul>";
              echo "</li>";
            }
            echo "</ol>";
          }
          else{// no users
            echo "No Users yet. Add your users from the upper section.";
          }
        ?>
      </div>
    </div>
  </div>
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
