<!DOCTYPE html>

<?php 

include 'connection.php';

session_start();

if(!isset($_SESSION['admin'])){
	
	
	header("location:login.php");
	
}


$sess=$_GET['ses'];
$uenroll=$_GET['cs'];



if(isset($_POST['submit'])){
	
	
	$enroll=$_POST['enroll'];
	$msg=$_POST['msg'];

	$q1="select * from reg_form where enroll='$enroll'";
	$d1=mysqli_query($conn,$q1);
	$rs1=mysqli_fetch_assoc($d1);
	
	
	$name=$rs1['username'];
	
	
	
	$q2="insert into chat (enroll,name,msg,count,datetime) values('$enroll','$name','$msg',0,NOW())";
	$d2=mysqli_query($conn,$q2);
	
	if($d2){
		
		echo "<script>alert('Message Has been sent !! ');</script>";
		
		
	}
	
}


?>
<html lang="en">

  <head>
  <style>
 
  </style>
  

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Dashboard</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
	
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	  
	  
	  
	   
	  
	  
	  
	  
	  

  </head>

  <body id="page-top">

   <?php include 'navbar.php';?>

    <div id="wrapper">
	
	
	

     <?php include 'sidebar.php';?>
	 
	 
	 
	 
	 

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
           

          <!-- Area Chart Example-->
           

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
              Send Message </div>
            <div class="card-body">
              <div class="table-responsive">
                 
				 
				 
				 <div class="container">
      <div class="card card-register mx-auto mt-5">
        
        <div class="card-body">
          <form method="post" onsubmit="return fun()">
            <div class="form-group">
                        
                        <label>Enrollment No. </label>
					<input type="text" class="form-control" id="enroll" name="enroll" value="<?php echo $uenroll;?>">  
                     </div>
                    
                 
                        
                        
                         <div class="form-group">
                        
                        <label>Message</label>
						       <textarea name="msg" id="msg" class="form-control">  </textarea>
                     </div>
                    
                     
 
 
					 
           <button class="btn btn-primary" type="submit" name="submit" id="submit"> Send</button><br>
		   
		   <div id="sent" style="color:green;"></div>
		   
          </form>
        
        </div>
      </div>
    </div>
				 
				 
				 
				 
				 
				 
				 
			 
				 
				 
              </div>
            </div>
           
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Your Website 2018</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Are You Sure ?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="js/demo/datatables-demo.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>

  </body>

</html>
 