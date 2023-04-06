<?php
error_reporting(0);
session_start();
include('connection.php');


$sessionid=$_GET['ses'];
$enroll=$_GET['cs'];

if(isset($_POST['submit'])){
     
 
    
    
    $updateque="update time set timeout=NOW() where session_id='$sessionid'";
    $d=mysqli_query($conn,$updateque);
	
	 //session_unset($_SESSION['session_id']);
	
    header('location:currentlogin.php');
   
	
	
    }

?>



<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="col-lg-6">
        <form action="" method="post">
    <div id="login">
<h1>Signout Form</h1>

   <p> email<input type="text" name='enroll' id='class' class="form-control"  value="<?php ECHO $enroll;?>"></p>
    <p> loginid<input type="text" name='session' id='class' class="form-control" value="<?php ECHO $sessionid;?>"></p>
   
    <!--password<input type="password" name="pass" class="form-control" />-->
    
    <input type="submit" id="submit" name="submit"/>
    
    <a href="currentlogin.php">Back</a>
</form></div>
            </div>
</body>
</html>




