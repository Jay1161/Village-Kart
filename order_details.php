<!DOCTYPE html>

<?php

include 'connection.php';
include 'host_url.php';

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("location:login.php");
}


$q = "SELECT reg_form.first_name,reg_form.address,product.product_name,fo.qty,fo.product_price,fo.date,fo.order_type FROM `final_order` fo,`product`,`reg_form` where reg_form.user_id = fo.user_id and product.product_id = fo.product_id";
$data = mysqli_query($conn, $q);
$result = mysqli_num_rows($data);


$img_url = $host_url . "shopping_cart_system/product_image/";

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

    <title>Order Details</title>

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

            <!-- Icon Cards-->


            <!-- Area Chart Example-->


            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header card-lg-12">
                    <i class="fas fa-table"></i> Manage Orders

                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <form method="post">

                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Customer Name</th>
                                    <th>Customer Address</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Order Type</th>
                                    <th>Amount Paid</th>
                                    <th>Purchase Date</th>


                                </tr>
                                </thead>

                                <tbody>


                                <?php

                                if ($result != 0) {

                                    $i = 1;
                                    while ($total = mysqli_fetch_assoc($data)) {


                                        $date = date('d-m-Y', strtotime($total['date']));

                                        echo "
         
                  <tr>
                    <td>$i</td>
                    <td>$total[first_name]</td>
                    <td>$total[address]</td>
                    <td>$total[product_name]</td>
                    <td>$total[qty]</td>
                    <td>$total[order_type]</td>
                    <td>$total[product_price]</td>
                    <td>$date</td>
                  </tr>";

                                        $i++;

                                    }
                                } else {

                                    echo " <h3>Data not found </h3>";
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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
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