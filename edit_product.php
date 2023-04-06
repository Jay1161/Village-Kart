 <?php
   include "connection.php";
        
   session_start();

if(!isset($_SESSION['admin'])){

   header('location:login.php');
} 
      


$get_product_id = $_GET['prod_id'];

$get_product_data = "SELECT * FROM product where product_id = '$get_product_id'";
$execute = $conn->query($get_product_data);


if(isset($_POST['submit'])){
 
 

 if (empty($_FILES['file']['name']))
 {
      $prod_name = $_POST['prod_name'];
      $prod_price = $_POST['prod_price'];
      $prod_cat = $_POST['prod_cat'];
      $prod_cat = $_POST['prod_cat'];


     echo $update_query = "UPDATE `product` set `product_name` = '$prod_name',`product_price`='$prod_price',`cat_id` = '$prod_cat' where product_id = '$get_product_id'";

      $conn->query($update_query);
      header('location:manage_product.php');

 }
 else
 {

 
  $host='../product_image/';

  $prod_name = $_POST['prod_name'];
  $prod_price = $_POST['prod_price'];
  $prod_cat = $_POST['prod_cat'];

  $fileinfo = basename($_FILES['file']['name']);

  $file_path = $host.$fileinfo;
  $upload = $fileinfo;


  if(move_uploaded_file($_FILES['file']['tmp_name'],$file_path)){

      $conn->query("UPDATE `product` set `product_name` = '$prod_name',`product_price`='$prod_price',`cat_id` = '$prod_cat', `product_image` = '$upload' where product_id = '$get_product_id'");
      header('location:manage_product.php');
  }

 }

  
        
}




  
        
?>
 
 
<html lang="en">

  <head>
  <script>
                    
                    function fun(){
                    
           return confirm('Are You Sure Want to MARK AS READ ? ');

                         }
                   
			 
				 
  </script>
 

					 
   
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

	 <!--<meta http-equiv="refresh" content="20"> -->
	
    <title>Edit Product</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
	 

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

 
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 


 <style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>

  </head>



  <body id="page-top">

   <?php include 'navbar.php';?>

    <div id="wrapper">

	
	  <?php include 'sidebar.php';?>
	
      <!-- Sidebar -->
     

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          

          <!-- Icon Cards-->
           
 

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
            Edit Product
			
			  
			</div>
           <div class="container">
      <div class="card card-register mx-auto mt-5">
        
        <div class="card-body">

 <?php 

        include 'host_url.php';

        $fetch_data = $execute->fetch_object();
        $img_url = $host_url . $projectName . "/product_image/";
        $img = $img_url.$fetch_data->product_image;

  ?>



          <form method="post" enctype="multipart/form-data">

 

<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

               
 <center><img src='<?php echo $img ?>' id="myImg" width='200' height='200' /></center>

               <div class="form-group">
                        
                        <label>Product Name</label>
                        <input type="text" name="prod_name" value="<?php echo $fetch_data->product_name ?>" class="form-control" required>
              </div>
       
           <div class="form-group">
                        
                        <label>Product Price</label>
                        <input type="number" min="0" name="prod_price" value="<?php echo $fetch_data->product_price ?>" class="form-control" required>
              </div>

        <div class="form-group">
                        
        <?php 

          $cat_query = "SELECT cat_name,cat_id from product_category";
          $exe = $conn->query($cat_query);

        ?>

                        <label>Product Category</label>
                        <select class="form-control" name="prod_cat">
            
            <?php 

              while ($obj = $exe->fetch_object()) {
            ?>      

                          <option value='<?php echo $obj->cat_id?>' <?php if($fetch_data->cat_id == $obj->cat_id){ echo 'selected = "selected"';} ?> >

                            <?php echo $obj->cat_name?>
                              

                          </option>

            <?php
                            }
            ?>
                        </select>
              </div>

              
               <div class="form-group">
                        
                        <label>Product Image</label>
                       Choose Image <input type="file" name="file" class="form-control">
              </div>

               
					 
           <button class="btn btn-primary" type="submit" name="submit">Edit</button>
		      <a href="manage_product.php" class="btn btn-secondary">Back</a>
          </form>
           
        </div>
      </div>
    </div>
             
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
       <?php include "footer.php" ?>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
	
	
	
	
	<!-- ------------------------------ 	  Log Out Modal ---------------------------------->

    
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
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
	
	 
	  
	
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>



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
 