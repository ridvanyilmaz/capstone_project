<?php
session_start();
if(isset($_SESSION["myturktrade"])){
    header("location:dashboard/index.php");
}else {
    if ($_POST) {
        require_once "../config.php";
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        $query_user = mysqli_num_rows(mysqli_query($con, "select * from Users where email='$email' and password='$password'"));
        $user_pull_sql = mysqli_query($con,"select * from Users where email='$email'");
        $query_array = mysqli_fetch_array($user_pull_sql);
        if ($query_user == 0) {
            $error = "Your login credentials were invalid.";
        }elseif($query_array[11] == 0){
            require_once "../func/functions.php";
            $user_id = find_user_id_by_e_mail($email);
            $user_deactivaton_reason_pull = mysqli_fetch_array(mysqli_query($con,"select description from account_status_record where user_id='$user_id' and active='1'"));
            $error = "Your account is not active. ";
            $error .= $user_deactivaton_reason_pull[0];
        }elseif ($query_user == 1) {
            $_SESSION["myturktrade"] = $query_array[0];
            header("location:index.php");
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8"/>
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <title>
            My TurkTrade Login
        </title>
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport'/>
        <link rel="stylesheet" type="text/css"
              href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <link href="assets/css/material-kit.css?v=2.0.7" rel="stylesheet"/>
    </head>
    <body class="login-page sidebar-collapse">
    <nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100"
         id="sectionsNav">
        <div class="container">
            <div class="navbar-translate">
                <a class="navbar-brand" href="index.php">
                    My TurkTrade </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <i class="fa fa-bars"></i> Menu
                        </a>
                        <div class="dropdown-menu dropdown-with-icons">
                            <a href="https://my.turktrade.ca" class="dropdown-item">
                                <i class="fa fa-user"></i>&nbsp;&nbsp;My TurkTrade
                            </a>
                            <a href="contact.php" class="dropdown-item">
                                <i class="fa fa-comment"></i>&nbsp;&nbsp;Contact Us
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="page-header header-filter"
         style="background-image: url('assets/img/bg7.jpg'); background-size: cover; background-position: top center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                    <?php
                    if ($error != "") {

                        ?>
                        <div class="alert alert-danger" style="top:-50px;position:relative;">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>Error Alert:</b><? echo $error; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="card card-login" style="height:250px;">
                        <form class="form" method="post" action="login.php">
                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title">Login</h4>
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">mail</i>
                    </span>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                           autocomplete="disabled" required>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">lock_outline</i>
                    </span>
                                    </div>
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                           autocomplete="disabled" required>
                                </div>
                            </div>
                            <div class="footer text-center">
                                <a href="https://my.turktrade.ca/login.php">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-sign-in"></i>&nbsp;Login</button>
                                    <a href="recover_password.php"><button class="btn btn-primary" type="button"><i class="fa fa-key"></i>&nbsp;Forgot My Password</button></a>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer footer-default">
            <div class="container">
                <nav class="float-left">
                    <ul>
                        <li>
                            <a href="https://www.turktrade.ca/">
                                Turk Trade
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright float-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    turktrade.ca
                </div>
            </div>
        </footer>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="../assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/moment.min.js"></script>
    <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
    <script src="../assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
    <!--  Google Maps Plugin    -->
    <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-kit.js?v=2.0.7" type="text/javascript"></script>
    </body>
    </html>
    <?php
}
?>