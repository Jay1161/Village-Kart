<!DOCTYPE html>

<?php

include 'connection.php';
include 'host_url.php';

session_start();

if (!isset($_SESSION['admin_id'])) {
  header("location:login.php");
}


$q = "SELECT product_id,product_name,product_image,product_price FROM product";
$data = mysqli_query($conn, $q);
$result = mysqli_num_rows($data);



$img_url = $host_url . $projectName . "/product_image/";

?>
<html lang="en">

<head>

  <style type="text/css">
    a {

      text-decoration: none;

    }
  </style>


  <script>
    function fun() {

      return confirm('Are you sure want to delete ? ');

    }
  </script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Manage Product</title>

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

  <?php include 'navbar.php'; ?>

  <div id="wrapper">


    <?php include 'sidebar.php'; ?>


    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="add_product.php">Add Product</a>
          </li>
         </ol>
        <!-- Icon Cards-->


        <!-- Area Chart Example-->


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header card-lg-12">
            <i class="fas fa-table"></i> Manage Product

          </div>

          <div class="card-body">
            <div class="table-responsive">

              <form method="post">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Sr No.</th>
                      <th>Product Name</th>
                      <th>Product Price</th>
                       <th>Product Image</th>
                      <th class="text-center" colspan="1">Action</th>

                    </tr>
                  </thead>
                   
                  <tbody>



                    <?php

                    if ($result != 0) {
 
                      $i = 1;
                      while ($total = mysqli_fetch_assoc($data)) {

                      $img = $img_url.$total['product_image'];

                        echo "
         
                  <tr>
                    <td>$i</td>
                    <td>$total[product_name]</td>
                    <td>$total[product_price]</td>
                     <td class='text-center'><img src='$img' width='80' height='60' alt='icon'></td>
                    <td class='text-center'><a href='edit_product.php?prod_id=$total[product_id]'>Edit</a></td>
                    </tr>";

                  $i++;

                      }
                    } else {

                     }


                    ?>
          
                </tbody>
                </table>

              </form>

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










  <!---------------------------------------------Logout Modal------------------------------------------->
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