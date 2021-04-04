<?php
$auth = isset($_GET["auth"])?$_GET["auth"]:"";
if($auth == ""){
    header("location:login.php");
}else{
    session_start();
    if(isset($_SESSION["myturktrade"])) {
        header("location:dashboard/index.php");
    }else {
        require_once "../config.php";
        $auth_check = mysqli_query($con,"select * from account_verification where token='$auth' and status='0'");
        if(mysqli_num_rows($auth_check) == 0){
            header("location:login.php");
        }else {
            $auth_array = mysqli_fetch_array($auth_check);
            $use_user_verification = mysqli_query($con,"update account_verification set status='1' where token='$auth'");
            if($use_user_verification) {
                $user_id = $auth_array[1];
                $activate_user = mysqli_query($con,"update Users set status='1' where id='$user_id'");
                if($activate_user) {
                    $deactivate_status_record = mysqli_query($con,"update account_status_record set active='0' where user_id='$user_id'");
                    if($deactivate_status_record) {
                        $success = "We have activated your account and verified your e-mail address. Now you can login to your account.";
                        ?>
                        <!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="utf-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <title>TurkTrade | Log in</title>

                            <!-- Google Font: Source Sans Pro -->
                            <link rel="stylesheet"
                                  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
                            <!-- Font Awesome -->
                            <link rel="stylesheet" href="dashboard/plugins/fontawesome-free/css/all.min.css">
                            <!-- icheck bootstrap -->
                            <link rel="stylesheet" href="dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
                            <!-- Theme style -->
                            <link rel="stylesheet" href="dashboard/dist/css/adminlte.min.css">
                        </head>
                        <body class="hold-transition login-page">
                        <div class="login-box">
                            <div class="login-logo">
                                <a href="https://turktrade.ca">TurkTrade</a>
                            </div>
                            <!-- /.login-logo -->
                            <div class="card">
                                <?php
                                if (isset($error)) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissible"
                                         style="width: 100%;margin:auto;position:relative;">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                        <? echo $error; ?>
                                    </div>
                                    <?php
                                } elseif (isset($success)) {
                                    ?>
                                    <div class="alert alert-success alert-dismissible"
                                         style="width: 100%;margin:auto;position:relative;">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                        <? echo $success; ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="card-body login-card-body">
                                    <p class="login-box-msg">Sign in to start your session</p>
                                    <form action="login.php" method="post">
                                        <div class="input-group mb-3">
                                            <input type="email" class="form-control" placeholder="Email" name="email"
                                                   required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" placeholder="Password"
                                                   name="password"
                                                   required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </form>

                                    <!-- /.social-auth-links -->

                                    <p class="mb-1">
                                        <a href="recover_password.php">I forgot my password</a>
                                    </p>
                                    <p class="mb-0">
                                        <a href="register.php" class="text-center">Register</a>
                                    </p>
                                </div>
                                <!-- /.login-card-body -->
                            </div>
                        </div>
                        <!-- /.login-box -->

                        <!-- jQuery -->
                        <script src="dashboard/plugins/jquery/jquery.min.js"></script>
                        <!-- Bootstrap 4 -->
                        <script src="dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                        <!-- AdminLTE App -->
                        <script src="dashboard/dist/js/adminlte.min.js"></script>
                        </body>
                        </html>

                        <?php
                    }
                }
            }
        }
    }
}