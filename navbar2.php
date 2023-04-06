 <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="uprofile2.php"><?php echo"$total2[name]" ?></a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-user"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        
      </form>

	  
	  
      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
     
       <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="modal" data-target="#msg">
            <i class="fas fa-envelope fa-fw"></i>
            <span class="" id="bdg">
			
			
			
			<?php 
			
			include 'connection.php';
			session_start();
			
			
			$uenroll=$_SESSION['uenroll'];
$q3="select * from chat where enroll='$uenroll' && count='0'";
$data9=mysqli_query($conn,$q3);


$cou=mysqli_num_rows($data9);
			
			if($cou!=0){
				
				
				
				//echo "." ;
			
			$q5="SELECT count(*) as cnt FROM `chat` WHERE count='0' && enroll='$uenroll'";
			$d5=mysqli_query($conn,$q5);
			$r5=mysqli_fetch_assoc($d5);
			$c=mysqli_num_rows($d5);
			
			if($c!=0){
				
				echo $r5['cnt'];
				
				echo "
				
				
				<script>
				
				document.getElementById('bdg').className='badge badge-danger';
				
				</script>
				
				
				";
				
			}
			else {
				
				echo "
				
				
				<script>
				
				document.getElementById('bdg').className='';
				
				</script>
				
				
				";
				
			}
			
			
			
			
			
			
			
			
			}?>
			</span>
          </a>
          <!--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>-->
        </li>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="changepassword.php" data-target="#psd" data-toggle="modal">Change Password</a> 
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">Logout</a>
			
			
          </div>
        </li>
      </ul>

    </nav>