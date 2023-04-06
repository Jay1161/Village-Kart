<!DOCTYPE html>
<?php
include "connection.php";

session_start();

if (!isset($_SESSION['admin'])) {

    header('location:login.php');
}


if (isset($_POST['submit'])) {

    date_default_timezone_set('Asia/Kolkata');

    $date = date('d/m/Y h:i:sa', time());

    $host = '../category_image/';

    $cat_name = $_POST['cat_name'];
    $fileinfo = basename($_FILES['file']['name']);

    $file_path = $host . $fileinfo;
    $upload = $fileinfo;


    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

        $conn->query("INSERT INTO `product_category`(`cat_name`, `cat_image`) VALUES('$cat_name','$upload')");
        header('location:manage_cat.php');
    }

}


?>


<html lang="en">

<head>
    <script>

        function fun() {

            return confirm('Are You Sure Want to MARK AS READ ? ');

        }


    </script>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!--<meta http-equiv="refresh" content="20"> -->

    <title>Add Category</title>

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


</head>


<body id="page-top">

<?php include 'navbar.php'; ?>

<div id="wrapper">


    <?php include 'sidebar.php'; ?>

    <!-- Sidebar -->


    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->


            <!-- Icon Cards-->


            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Add Catgory


                </div>
                <div class="container">
                    <div class="card card-register mx-auto mt-5">

                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">


                                <div class="form-group">

                                    <label>Catgory Name</label>
                                    <input type="text" name="cat_name" class="form-control" required>
                                </div>


                                <div class="form-group">

                                    <label>Catgory Image</label>
                                    Choose Image <input type="file" name="file" class="form-control" required>
                                </div>


                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                <a href="manage_cat.php" class="btn btn-secondary">Back</a>
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


<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
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
 