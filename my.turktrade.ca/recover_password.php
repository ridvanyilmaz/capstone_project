
        <?php
        $auth = isset($_GET["auth"])?$_GET["auth"]:"";
        require_once "../config.php";
        if($auth == "") {
            ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>TurkTrade | Recover Password</title>

            <!-- Google Font: Source Sans Pro -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="dashboard/plugins/fontawesome-free/css/all.min.css">
            <!-- icheck bootstrap -->
            <link rel="stylesheet" href="dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="dashboard/dist/css/adminlte.min.css">
        </head>
        <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="https://turktradfe.ca" class="h1"><b>TurkTrade</b></a>
                </div>
                <?php
            if(isset($_POST["email"])){
                require_once "../func/functions.php";
                $email = $_POST["email"];
                $e_mail_check = mysqli_query($con,"select * from Users where email='$email'");
                if($email == ""){
                    $error = "You did not fill required e-mail area.";
                }else {
                    if (mysqli_num_rows($e_mail_check) == 0) {
                        $error = "We could not find your e-mail address on our file.";
                    } else {
                        require_once "../func/functions.php";
                        $user_array = mysqli_fetch_array($e_mail_check);
                        $check_active_requests = mysqli_query($con,"select * from password_recovery where user_id='$user_array[0]' and status='0' order by id DESC");
                        date_default_timezone_set('America/Toronto');
                        $requests_array = mysqli_fetch_array($check_active_requests);
                        $date_now = date("Y-m-d H:i:s");
                        $date_auth = $requests_array[3];
                        $difference = strtotime($date_now)-strtotime($date_auth);
                        if(mysqli_num_rows($check_active_requests) != 0 && $difference < 86400){
                            $error = "You already requested for password recovery. Please click the link that was sent to your e-mail.";
                        }else {
                            $token = md5(uniqid() . rand(100000, 999999) . date("Y-m-d-H-i-s"));
                            date_default_timezone_set('America/Toronto');
                            $date = date("Y-m-d H:i:s");
                            $create_password_recovery = mysqli_query($con, "insert into password_recovery (user_id,token,date,status) values ('$user_array[0]','$token','$date','0')");
                            if ($create_password_recovery) {
                                $message = "We have received your password recovery request. Please click the button below to recover your password. You have 1 day to click the link on mail.<br>";
                                $message .= "<a href='https://my.turktrade.ca/recover_password.php?auth=$token'><button style='background-color:skyblue;border-radius:3px;color:white;padding:10px;'>Recover Your Password</button></a>";
                                $send_mail = send_e_mail($email, "Password Recovery", $message);
                                if ($send_mail == "OK") {
                                    $success = "We have sent you a password recovery e-mail. Please check your inbox and junk mail.";
                                } else {
                                    $error = $send_mail;
                                }
                            }
                        }
                    }
                }
            }
            if(isset($error)){
                ?>
                <div class="alert alert-danger alert-dismissible" style="width:100%;margin:auto;position:relative;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    <? echo $error; ?>
                </div>
                <?php
            }elseif(isset($success)){
                ?>
                <div class="alert alert-success alert-dismissible" style="width:100%;margin:auto;position:relative;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                    <? echo $success; ?>
                </div>
                <?php
            }
            ?>
            <div class="card-body">
                <p class="login-box-msg">Please enter your e-mail to get password recovery to your e-mail address.</p>
                <form action="recover_password.php" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your E-mail Address" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-at"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Send Recovery Link</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="login.php">Login</a>
                </p>
            </div>
            <?php
        }else{
            $check_auth = mysqli_query($con,"select * from password_recovery where token='$auth' and status='0'");
            if(mysqli_num_rows($check_auth) == 0){
                header("location:recover_password.php");
            }else {
                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>TurkTrade | Recover Password</title>

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
                <?php
            date_default_timezone_set('America/Toronto');
            $date_now = date("Y-m-d H:i:s");
            $auth_array = mysqli_fetch_array($check_auth);
            $date_auth = $auth_array[3];
            if(strtotime($date_now) - strtotime($date_auth) > 86400){
            ?>
                <div class="alert alert-danger alert-dismissible" style="top:150px;width:400px;margin:auto;position:relative;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    Password recovery link has expired. <a href="recover_password.php">Click</a> to get a new link.
                </div>
            <?php
            }else{
                if(isset($_POST["password"])){
                    $password = isset($_POST["password"]) ? $_POST["password"] : "";
                    $password2 = isset($_POST["password2"]) ? $_POST["password2"] : "";
                    if ($password == "" || $password2 == "") {
                        $error = "You did not fill required password fields.";
                    } elseif (strlen($password) < 6) {
                        $error = "Password should be at least 6 characters.";
                    } elseif ($password != $password2) {
                        $error = "Passwords you entered does not match.";
                    } else {
                        $new_password = md5($password);
                        $user_id = $auth_array[1];
                        $update_password = mysqli_query($con, "update Users set password='$new_password' where id='$user_id'");
                        if ($update_password) {
                            $use_auth = mysqli_query($con, "update password_recovery set status='1' where token='$auth'");
                            if ($use_auth) {
                                $success = "We have changed your password successfully. <a href=\"login.php\">Return To
                                        Login Page.</a>";
                            }
                        }
                    }
                }
            ?>
                <body class="hold-transition login-page">
                <div class="login-box">
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <a href="https://turktrade.ca" class="h1"><b>TurkTrade</b></a>
                        </div>
                        <div class="card-body">
                            <?php
                            if(isset($error)) {
                                ?>
                                <div class="alert alert-danger alert-dismissible"
                                     style="width:auto;margin:auto;position:relative;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    <? echo $error; ?>
                                </div>
                                <?php
                            }elseif(isset($success)){
                                ?>
                                <div class="alert alert-success alert-dismissible"
                                     style="width:auto;margin:auto;position:relative;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                    <? echo $success; ?>
                                </div>
                                <?php
                            }
                            ?>
                            <p class="login-box-msg">You are only one step a way from your new password, recover your
                                password
                                now.</p>
                            <form action="recover_password.php?auth=<? echo $auth; ?>" method="post">
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="password2" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block">Change password</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>

                            <p class="mt-3 mb-1">
                                <a href="login.php">Login</a>
                            </p>
                        </div>
                        <?php
                        }
            }
        }

        ?>
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
