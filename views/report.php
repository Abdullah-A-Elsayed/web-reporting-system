<?php
if(!isset($_SESSION)){session_start();}
require_once '../includes/db/connection.php';
require_once '../includes/functions.php';
if (isset($_SESSION['id'])){
    $id = $_SESSION['id'];
   if(getFromUsers($id,'type')==='ADMIN'){
          header("location:admin");
          exit;
    }
        else{ // NORMAL USER
        	// in the right place
        }
 }
 else{
 	header("location: ..");
 	exit();
 }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../img/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<title><?php echo getFromUsers($id,'username');?></title>
	<style type="text/css">#success_message{ display: none;}</style>
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
       	<a href="changePwd.php">Change Password</a><br>
      <a href="../includes/logOut.php">LOG OUT</a>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingTwo">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          History
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="card-block">
        Total number of Rooms :<br> <?php echo nullToZero(getFromUsers($id,'rooms')).'<br><br>'; ?>
        Total number of Visits :<br> <?php echo nullToZero(getFromUsers($id,'visits')).'<br><br>'; ?>
        Total number of "Warsha" :<br> <?php echo nullToZero(getFromUsers($id,'workshops')).'<br><br>'; ?>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingThree">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Write a new Report
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="card-block">
        <form class="well form-horizontal" action="../includes/reportingProcess.php" method="post"  id="contact_form">
		<fieldset>

	<!-- Form Name -->
	<legend>Day Report</legend>
	<div class="row col-md-12">


	<div class="col-md-4">
	<!-- Select Basic -->
		<div class="form-group"> 
		  <label class="col-md-12 control-label">Total number of rooms</label>
		    <div class="col-md-12 selectContainer">
		    <div class="input-group">
		        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
		    <select name="rooms" class="form-control selectpicker" required onchange="roomSelect(event)">
		      <option disabled selected value>--How many rooms ?--</option>
		      <option value="0">0</option>
		      <option value="1">1</option>
		      <option value="2">2</option>
		      <option value="3" >3</option>
		      <option value="4" >4</option>
		      <option value="5" >5</option>
		      <option value="6" >6</option>
		      <option value="7" >7</option>
		      <option value="8" >8</option>
		      <option value="9" >9</option>
		      <option value="10">10</option>
		    </select>
		  </div>
		</div>
		</div>
		</div>
		<!-- Text input-->
		<div class="col-md-4">
		<div id="rooms"class="form-group">
		 
		</div>
		</div>

	</div>
	<br>
	<!-- radio checks -->
	<div class="row col-md-12">

	<div class="col-md-4">
	 					<div class="form-group">
	                        <label class="col-md-12 control-label">Did you make visits?</label>
	                        <div class="col-md-12">
	                            <div class="radio">
	                                <label>
	                                    <input type="radio" name="visits" value="yes" onclick="visitSelect(event)" required /> Yes
	                                </label>
	                            </div>
	                            <div class="radio">
	                                <label>
	                                    <input type="radio" name="visits" value="no" onclick="visitSelect(event)" /> No
	                                </label>
	                            </div>
	                        </div>
	                    </div>
	 </div>
	<!-- Text input-->
	<div class="col-md-4">
	<div id="visits" class="form-group" style="display:none;">
	<label class="col-md-12 control-label">Total number of visits</label>  
	    <div class="col-md-12 inputGroupContainer">
	    <div class="input-group">
	        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
	  <select required name="visits-n" class="form-control selectpicker" id="visits-sel">
	      <option disabled selected value>--How many visits ?--</option>
	      <option value="0">0</option>
	      <option value="1">1</option>
	      <option value="2">2</option>
	      <option value="3" >3</option>
	      <option value="4" >4</option>
	      <option value="5" >5</option>
	      <option value="6" >6</option>
	      <option value="7" >7</option>
	      <option value="8" >8</option>
	      <option value="9" >9</option>
	      <option value="10">10</option>
	    </select>
	    </div>
	  </div>
	  <br>
	 <div class="form-group">
	  <label class="col-md-12 control-label">Comment on visits</label>  
	    <div class="col-md-12 inputGroupContainer">
	    <div class="input-group">
	        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
	        	<textarea id="visits-comment" class="form-control" name="visits-comment" placeholder="visits comment" required ></textarea>
	    </div>
	  </div>
	</div>
	</div>
	</div>

	</div> <!-- visits row -->
	<br>


	<div class="row col-md-12">
	
	<div class="col-md-4">
	 <div class="form-group">
	                        <label class="col-md-12 control-label">Did you have Warsha?</label>
	                        <div class="col-md-12">
	                            <div class="radio">
	                                <label>
	                                    <input type="radio" name="workshops" required value="yes" onclick="workshopSelect(event)" /> Yes
	                                </label>
	                            </div>
	                            <div class="radio">
	                                <label>
	                                    <input type="radio" name="workshops" value="no" onclick="workshopSelect(event)" /> No
	                                </label>
	                            </div>
	                        </div>
	                    </div>
	 </div>
	<!-- Text input-->
	<div class="col-md-4">
		<div id="workshops" class="form-group" style="display:none;">
		
			 <div class="form-group">
			  <label class="col-md-12 control-label">Comment on Warsha</label>  
			    <div class="col-md-12 inputGroupContainer">
			    <div class="input-group">
			        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
			        	<textarea id="workshops-comment" class="form-control" name="workshops-comment" placeholder="Warsha comment" required></textarea>
			    </div>
			  </div>
			</div>
		</div>
	</div>

	</div> <!-- workshops row -->
	<!-- Text area -->
	<div class="row col-md-12">
	<div class="col-md-4">
		<div class="form-group">
		  <label class="col-md-12 control-label">Problems</label>
		    <div class="col-md-12 inputGroupContainer">
		    <div class="input-group">
		        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
		        	<textarea class="form-control" name="problems" placeholder="Problems" required ></textarea>
		  </div>
		  </div>
		</div>
	</div>
	</div> <!-- problems row -->
	<br>
	<!-- Text area -->
	<div class="row col-md-12">
	<div class="col-md-4">
		<div class="form-group">
		  <label class="col-md-12 control-label">General Comment</label>
		    <div class="col-md-12 inputGroupContainer">
		    <div class="input-group">
		        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
		        	<textarea class="form-control" name="comment" placeholder="General Comment" required></textarea>
		  </div>
		  </div>
		</div>
	</div>
	</div>
	<!-- Success message -->
	<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div>

	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-4 control-label"></label>
	  <div class="col-md-4">
	    <button type="submit" class="btn btn-warning" >Send <span class="glyphicon glyphicon-send"></span></button>
	  </div>
	</div>

	</fieldset>
	</form>
      </div>
    </div>
  </div>
</div>
	    
	</div><!-- /.container -->

	<?php  require_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script type="text/javascript" src="../js/success.js"></script>
<script type="text/javascript" src="../js/reportForm.js"></script>
<script type="text/javascript" src="../js/rooms.js"></script>
</body>
</html>
