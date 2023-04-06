<!DOCTYPE html>

<?php
include "connection.php";
session_start();

//error_reporting('0');


if (isset($_SESSION['id'])) {


    header("location:index.php");
}


if (isset($_POST['submit'])) {


    $username = $_POST['username'];
    $pwd = $_POST['pwd'];


    $q = "SELECT * FROM admin WHERE username='$username' and password='$pwd'";
    $data = mysqli_query($conn, $q);
    $result = mysqli_num_rows($data);


    if ($result == 1) {

        $total = mysqli_fetch_assoc($data);
        $_SESSION['admin_id'] = $total['id'];
        $_SESSION['admin'] = "admin";
        header("location:index.php");
    } else {

        echo "<script>alert('Invalid Username or Password');</script>";
    }
}


?>


<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Village Cart - Login</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">


    <style type="text/css">

        body {
            /*background-color: #986B41;*/
            background-image: url("/category_image/bnere.jpg");
            background-size: cover;

        }
    </style>


</head>

<body>

<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header text-center">Village Kart Login</div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="text" name="username" id="inputEmail" class="form-control"
                               placeholder="Email address" required="required" autofocus="autofocus">
                        <label for="inputEmail">Username</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="password" name="pwd" id="inputPassword" class="form-control" placeholder="Password"
                               required="required">
                        <label for="inputPassword">Password</label>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn btn-warning btn-block">Login</button>
            </form>
            <div class="text-center">
                </br>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>