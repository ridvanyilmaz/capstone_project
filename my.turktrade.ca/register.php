<?php
session_start();
if(isset($_SESSION["myturktrade"])){
    header("location:dashboard/index.php");
}else {
    require_once "../config.php";
    if ($_POST) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $dob = $_POST["dob"];
        $country = $_POST["country"];
        $check_mail = mysqli_query($con,"select * from Users where email='$email'");
        $error = "";
        $success = "";
        if(mysqli_num_rows($check_mail) != 0){
            $error = "The e-mail address you provided is already registered.";
        }elseif($password != $password2){
            $error = "The password you provided does not match.";
        }elseif (strlen($password) < 6){
            $error = "The password should be at least 6 characters.";
        }elseif (mysqli_num_rows(mysqli_query($con,"select * from country where country_id='$country'")) == 0 || !is_numeric($country)){
            $error = "Country selection is invalid.";
        }elseif($email == "" || $password == "" || $password2 == "" || $fname == "" || $lname == "" || $dob == "" || $country == ""){
            $error = "Please fill all required parameters.";
        }else{
            require_once "../func/functions.php";
            $password_encrypted = md5($password);
            $create_row_users = mysqli_query($con,"insert into Users (first_name,last_name,email,date_of_birth,country,password,status) values 
('$fname','$lname','$email','$dob','$country','$password_encrypted','0')");
            $description = "Account has registration deactivation. Please click link on the e-mail sent.";
            $user_id = find_user_id_by_e_mail($email);
            $create_row_status_record = mysqli_query($con,"insert into account_status_record (user_id,description,active) values ('$user_id[1]','$description','1')");
            if($create_row_users && $create_row_status_record){
                $user_id = find_user_id_by_e_mail($email);
                if($user_id[0] == "OK") {
                    date_default_timezone_set('America/Toronto');
                    $date = date("Y-m-d H:i:s");
                    $token = md5(uniqid().rand(100000,999999).date("Y-m-d-H-i-s"));
                    $create_verification_record = mysqli_query($con, "insert into account_verification (user_id,token,date,status) values ('$user_id[1]','$token','$date','0')");
                    if($create_verification_record) {
                        $message = "We have received your account creation request. Your account was created successfully. However, you need to activate your account by clicking button below to begin using your account. Please activate your account.<br>";
                        $message .= "<a href='https://my.turktrade.ca/account_verification.php?auth=$token'><button style='background-color:skyblue;padding:10px;color:white;border-radius:3px;'>Activate Your Account</button></a>";
                        $send_e_mail = send_e_mail($email, "Account Verification", $message);
                        if($send_e_mail == "OK") {
                            $success = "Your account has been successfully created. You need to activate your account by clicking the link on e-mail we just sent. After that, you can <a href='login.php'>login</a> to your account.";
                        }else{
                            $error = $send_e_mail;
                        }
                    }
                }
            }
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
                        <div class="alert alert-danger" style="top:90px;position:relative;">
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
                    <?php
                    if ($success != "") {

                        ?>
                        <div class="alert alert-success" style="top:90px;position:relative;">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>Success Message:</b><? echo $success; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div style="padding:10px;border-radius:5px;top:55px;position:relative;width:1000px;">
                        <form action="register.php" method="post">
                            <table cellpadding="5">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
                                        </div>
                                        <div class="form-group">
                                            <label>Create a Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Create a Password">
                                        </div>
                                        <div class="form-group">
                                            <label>Repeat Password</label>
                                            <input type="password" name="password2" class="form-control" placeholder="Repeat Password">
                                        </div>
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="fname" class="form-control" placeholder="First Name">
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="lname" class="form-control" placeholder="Last Name">
                                        </div>
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" name="dob" class="form-control" placeholder="Date of Birth">
                                        </div>
                                        <div class="form-group">
                                            <label>Country:</label>
                                            <select class="form-control" name="country">
                                                <?php
                                                $get_country = mysqli_query($con,"select * from country");
                                                while($country_array=mysqli_fetch_array($get_country)){
                                                    echo"<option value='$country_array[0]'>$country_array[2]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="btn btn-primary">Next</button>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php
}
?>