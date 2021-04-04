<?php
session_start();
if(!isset($_SESSION["myturktrade"])){
    header("location:../login.php");
}else {
    require_once "../../config.php";
    $user_id = $_SESSION["myturktrade"];
    $user_pull_query = mysqli_query($con, "select * from Users where id='$user_id'");
    $user_query = mysqli_fetch_array($user_pull_query);
    $user_full_name = $user_query[1] . " " . $user_query[2];
    $user_email = $user_query[3];
    $messages_unread_query = mysqli_num_rows(mysqli_query($con,"select id from user_messages where user_id='$user_id' and message_read='0'"));
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My TurkTrade Dashboard</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- IonIcons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">

        <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    </head>
    <!--
    `body` tag options:

      Apply one or more of the following classes to to the body tag
      to get the desired effect

      * sidebar-collapse
      * sidebar-mini
    -->
    <body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
            </ul>


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <?php
                        if($messages_unread_query != 0){
                            echo"<span class=\"badge badge-danger navbar-badge\">$messages_unread_query</span>";
                            if($messages_unread_query == 1) {
                                $notification_text = "You have $messages_unread_query message.";
                            }else{
                                $notification_text = "You have $messages_unread_query messages.";
                            }
                        }else{
                            $notification_text = "You have no messages.";
                        }
                        $messages_pull = mysqli_query($con,"select * from user_messages where user_id='$user_id' and message_read='0'");
                        ?>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <?php
                            while($message=mysqli_fetch_array($messages_pull)){
                            ?>
                            <div class="media">
                                <img src="profile_pic.php" alt="User Avatar"
                                     class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        <? echo $message[4]; ?>
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm"><? echo $message[2]; ?></p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <? echo $message[3]; ?></p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <?php
                        }
                        ?>
                        <a href="?s=mailbox" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">0 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> <? //echo $notification_text;?>
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <!--<img src="#" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                     style="opacity: .8"> -->
                <span class="brand-text font-weight-light">MyTurkTrade</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="profile_pic.php" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><? echo $user_full_name;?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data - widget="treeview" role="menu"
                        data - accordion="false">
                        <!--Add icons to the links using the . nav - icon class
                with font-awesome or any other icon font library-->
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> Dashboard Main Page </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="?s=buy-stocks" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Buy Stocks
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?s=my-portfolio" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    My Portfolio (Sell Stocks)
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?s=my-accounts" class="nav-link">
                                <i class="nav-icon fas fa-money-check"></i>
                                <p>
                                    My Accounts
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?s=transfer" class="nav-link">
                                <i class="nav-icon fas fa-exchange-alt"></i>
                                <p>
                                    Transfer Funds
                                </p>
                            </a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-euro-sign"></i>
                                <p>
                                    Forex
                                </p>
                            </a>
                        </li>
                        -->
                        <li class="nav-item">
                            <a href="?s=profile" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    My Profile
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->

            </div>
            <!-- /.sidebar -->
        </aside>
<?php
$s = $_GET["s"];
if($s == ""){
?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">TurkTrade Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Profit-Loss Calculation</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="card">
                                <?php
                                $user_portfolio_pull = mysqli_query($con,"select stock_id,quantity,utoken from portfolio where user_id='$user_id'");
                                if(mysqli_num_rows($user_portfolio_pull) == 0){
                                    ?>
                                    <div class="callout callout-warning">
                                        <h5>You do not have any stocks.</h5>

                                        <p>Profit/Loss calculation is not available because you dont have stocks. To buy stocks, go to Buy Stocks menu.</p>
                                    </div>
                                    <?php
                                }else{
                                ?>
                                <div class="card-header border-0">
                                    <h3 class="card-title">Stock List</h3>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-sm">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="#" class="btn btn-tool btn-sm">
                                            <i class="fas fa-bars"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body table-responsive p-0">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                        <tr>
                                            <th>Stock You Have</th>
                                            <th>Total Current Value</th>
                                            <th>Total Cost to You</th>
                                            <th>Your Profit</th>
                                            <th>More</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        require_once "../../func/functions.php";
                                        while($portfolio_data_array = mysqli_fetch_array($user_portfolio_pull)){
                                            $utoken = $portfolio_data_array[2];
                                            $pull_transaction_log_data = mysqli_query($con,"select price,quantity from stock_transaction_log where portfolio_token='$utoken' and transaction_type='Buy'");
                                            $pull_transaction_log_data_sell = mysqli_query($con,"select price,quantity from stock_transaction_log where portfolio_token='$utoken' and transaction_type='Sell'");
                                            $stock_code = find_stock_code($portfolio_data_array[0]);
                                            $stock_value_pull = mysqli_fetch_array(mysqli_query($con,"select stock_current from stock_prices where stock_code='$stock_code' and stock_current!='0.00' order by pulled_date DESC"));
                                            $cost = 0;
                                            $quantity = 0;
                                            while($pull_transaction_log_data_array = mysqli_fetch_array($pull_transaction_log_data)) {
                                                $cost += $pull_transaction_log_data_array[0]*$pull_transaction_log_data_array[1];
                                                $quantity += $pull_transaction_log_data_array[1];
                                            }
                                            while($pull_transaction_log_data_sell_array = mysqli_fetch_array($pull_transaction_log_data_sell)) {
                                                $cost -= $pull_transaction_log_data_sell_array[0]*$pull_transaction_log_data_sell_array[1];
                                                $quantity -= $pull_transaction_log_data_sell_array[1];
                                            }
                                            $total_current_value = $stock_value_pull[0] * $quantity;
                                            if ($total_current_value > $cost) {
                                                $prefix = "+";
                                                $class = "fas fa-arrow-up";
                                                $difference = $total_current_value - $cost;
                                                $percentage = $difference/($cost/100);
                                                $color = "green";
                                            } elseif ($total_current_value < $cost) {
                                                $prefix = "-";
                                                $class = "fas fa-arrow-down";
                                                $difference = $cost - $total_current_value;
                                                $percentage = $difference/($cost/100);
                                                $color = "red";
                                            } elseif ($total_current_value == $cost) {
                                                $prefix = "";
                                                $class = "fas fa-arrow-right";
                                                $difference = 0.00;
                                                $color = "gray";
                                            }
                                        ?>
                                        <tr>
                                            <td>
                                                <img src="dist/img/stock-market.jpg"
                                                     class="img-circle img-size-32 mr-2">
                                                <? echo $stock_code;?>
                                            </td>
                                            <td>$<?echo number_format($total_current_value,2,",",".");?> USD</td>
                                            <td>$<?echo number_format($cost,2,",",".");?> USD</td>
                                            <td>
                                                <small style="color:<? echo $color; ?>;">
                                                    <i class="<? echo $class;?>"></i>
                                                    <?echo $prefix."%".number_format($percentage,2,",",".");?>
                                                </small>

                                                <? echo $prefix."$".number_format($difference,2,",",".");?>
                                            </td>
                                            <td>
                                                <a href="#" class="text-muted">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                            <?php
                                            $cost = 0;
                                            $quantity = 0;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                    <?}?>
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-lg-6">

                            <div class="card">
                                <?php
                                $user_portfolio_pull = mysqli_query($con,"select stock_id,quantity,utoken from portfolio where user_id='$user_id'");
                                if(mysqli_num_rows($user_portfolio_pull) == 0){
                                    ?>
                                    <div class="callout callout-warning">
                                        <h5>You do not have any stocks.</h5>

                                        <p>Graph is not available as you do not have any stocks.</p>
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                <?}?>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <?php
        }elseif($s == "buy-stocks") {
    $p = isset($_GET["p"])?$_GET["p"]:"";
    if($p == ""){
?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Buy Stocks</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                <li class="breadcrumb-item active">Buy Stock</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <?php
            $user_account_query = mysqli_query($con, "select * from accounts where user_id='$user_id'");
            if (mysqli_num_rows($user_account_query) == 0) {
                ?>
                <section class="content">
                    <div class="callout callout-info" style="width:500px;margin:auto;position:relative;">
                        <h5>You do not have an account to buy stocks.</h5>

                        <p>You need to open a TurkTrade account to make transactions such as balance upload, buy stocks
                            and sell
                            stocks. To open account, please go to My Accounts section from the menu.</p>
                    </div>
                </section>

                <?
            } else {
                ?>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Stock List</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Symbol</th>
                                                    <th>Name</th>
                                                    <th>Last Value (USD)</th>
                                                    <td>Change (%)</td>
                                                    <th>Last Value Pulled</th>
                                                    <th>Details</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $stock_list_pull = mysqli_query($con, "select * from stocks");
                                                $count = 0;
                                                while ($array_stock = mysqli_fetch_array($stock_list_pull)) {
                                                    $count++;
                                                    $pull_stock_prices = mysqli_fetch_array(mysqli_query($con, "select stock_current,pulled_date,previous_close from stock_prices where stock_code='$array_stock[1]' and stock_current!='0.00' order by id DESC"));
                                                    $current_price = $pull_stock_prices[0];
                                                    $closed = $pull_stock_prices[2];
                                                    if($current_price < $closed){
                                                        $color = "red";
                                                        $prefix = "-";
                                                        $difference = $closed-$current_price;
                                                    }elseif($current_price > $closed){
                                                        $color = "green";
                                                         $prefix = "+";
                                                         $difference = $current_price-$closed;
                                                    }elseif($current_price == $closed){
                                                        $color = "gray";
                                                         $prefix = "";
                                                         $difference = 0;
                                                    }
                                                    $difference_percentage = number_format($difference/($closed/100),2,",",".");
                                                    echo "
                                                                <tr>
                                                                <td>$array_stock[1]</td>
                                                                <td>$array_stock[2]</td>
                                                                <td style='background-color:$color;color:white;'>$pull_stock_prices[0]</td>
                                                                <td style='color:$color;'>$prefix$difference_percentage %</td>
                                                                <td>$pull_stock_prices[1]</td>
                                                                <td><a href='?s=buy-stocks&p=stock-details&id=$count'><button type=\"button\" class=\"btn btn-block btn-info\">Details</button></a></td>
                                                                </tr>
                                                                ";
                                                }
                                                ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>Symbol</th>
                                                    <th>Name</th>
                                                    <th>Last Value (USD)</th>
                                                    <th>Change (%)</th>
                                                    <th>Last Value Pulled</th>
                                                    <th>Details</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                <?php
            }
            echo "</div>";
            }elseif($p == "stock-details"){
            $t = isset($_GET["t"]) ? $_GET["t"] : "";
            if ($t == ""){
            ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Buy Stocks</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                    <li class="breadcrumb-item active">Buy Stock</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>
                <?php
                $id = isset($_GET["id"]) ? $_GET["id"] : "";
                if (!is_numeric($id)) {
                    ?>
                    <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                        <h5>Error</h5>

                        <p>An error occurred. Please try again.</p>
                    </div>
                    <?php
                } else {
                    $stock_list_pull = mysqli_query($con, "select * from stocks");
                    $count = 0;
                    while ($array_stock = mysqli_fetch_array($stock_list_pull)) {
                        $count++;
                        if ($count == $id) {
                            break;
                        }
                    }
                    if ($array_stock[0] != $id || $array_stock[0] == "") {
                        ?>
                        <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                            <h5>Error</h5>

                            <p>An error occurred. Please try again.</p>
                        </div>
                        <?php
                    } else {
                        $pull_stock_prices = mysqli_fetch_array(mysqli_query($con, "select stock_current,pulled_date from stock_prices where stock_code='$array_stock[1]' order by id DESC"));
                        ?>
                        <section class="content" style="width:400px;margin:auto;position:relative;">
                            <div class="container-fluid">
                                <div class="callout callout-info">
                                    <h5>Data Latency</h5>

                                    <p>Stock price data latency is 10 minutes in weekdays between 9:30 AM - 4:00 PM EST.</p>
                                </div>
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Stock Information</h3>
                                    </div>
                                    <table width="100%">
                                        <tr>
                                            <td>Name of the Stock:</td>
                                            <td><? echo $array_stock[2]; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Last Pulled Time of Price:</td>
                                            <td><? echo $pull_stock_prices[1]; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Last Price of the Stock:</td>
                                            <td><? echo $pull_stock_prices[0]; ?> USD</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg" id="stock-buy-button" style="width:100%;">
                                                    Buy This Stock
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </section>
                        <br>
                        <section class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- interactive chart -->
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="far fa-chart-bar"></i>
                                                    Interactive Area Chart
                                                </h3>

                                                <div class="card-tools">
                                                    Real time
                                                    <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                                                        <button type="button" class="btn btn-default btn-sm active"
                                                                data-toggle="on">On
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-sm"
                                                                data-toggle="off">Off
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="interactive" style="height: 300px;"></div>
                                            </div>
                                            <!-- /.card-body-->
                                        </div>
                                        <!-- /.card -->

                                    </div>
                                    <!-- /.col -->
                                </div>
                            </div>
                        </section>
                                <?php
                                    $token_buy_stock_form = md5(uniqid().date("Y-m-d-H-i-s-").rand(100000,999999));
                                    $description = "Stock-buy-form-opened";
                                    $date = date("Y-m-d H:i:s");
                                    $insert_session_row = mysqli_query($con,"insert into form_session (token,description,time,status) values ('$token_buy_stock_form','$description','$date','0')");
                                    $_SESSION["stock-buy-form"] = $token_buy_stock_form;
                                ?>

                        <section class="content" style="width:400px;margin:auto;position:relative;">
                            <div class="modal fade" id="modal-lg">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Buy Stock</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Stock Buying Screen</h3>
                                                </div>
                                                <form action="?s=buy-stocks&p=stock-details&t=stock-buy-approve" method="post">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>Quantity of Stock</label>
                                                            <input type="text" name="quantity" class="form-control"
                                                                   placeholder="Quantity of Stock"
                                                                   required>
                                                            <input type="hidden" name="stock" value="<? echo $array_stock[0]; ?>">
                                                        </div>
                                                    <div class="form-group">
                                                            <label>Select the Account You Want to Use for this Purchase</label>
                                                            <select name='account' class="form-control select2" style="width: 100%;">
                                                                <?php
                                                                $accounts_pull = mysqli_query($con,"select account_number,currency,available_balance from accounts where user_id='$user_id'");
                                                                $count = 0;
                                                                while($account_array = mysqli_fetch_array($accounts_pull)){
                                                                    $count++;
                                                                    echo"<option value='$count'>Account Number: $account_array[0] Available Balance: $account_array[3] $account_array[2]</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <input type="hidden" name="stock" value="<? echo $array_stock[0]; ?>">
                                                        </div>
                                                    </div>
                                                    <input type="submit" value="Proceed to Buy Stock" class="btn btn-block btn-info">
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-outline-light">Save changes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </section>
                        <?php
                    }
                }
                echo "</div>";
                }elseif($t == "stock-buy-approve"){
                    ?>
                <div class="content-wrapper">
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Buy Stocks</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                        <li class="breadcrumb-item"><a href="?s=buy-stocks">Buy Stock</a></li>
                                        <li class="breadcrumb-item active">Buy Stock Approval</li>
                                    </ol>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>
                    <?php
                                        $a = isset($_GET["a"])?$_GET["a"]:"";
                                        if($a == "") {
                                        if(isset($_SESSION["stock-buy-form"])){
                                        $page_session_token = $_SESSION["stock-buy-form"];
                                        $page_session_token_pull = mysqli_fetch_array(mysqli_query($con,"select status from form_session where token='$page_session_token'"));
                                        $use_page_token = mysqli_query($con,"update form_session set status='1' where token='$page_session_token'");
                                        if($page_session_token_pull[0] == 1 || $page_session_token_pull[0] == ""){
                                         ?>
                                        <div class="callout callout-danger" style="width: 500px;margin:auto;position:relative;">
                                         <h5>Form submitted twice!</h5>
                                            <p>Because your form submitted more than once, we aborted the process. Please try again.</p>
                                             </div>
                                        <?php
                                        }else{
                                        if($use_page_token){
                                        $id = isset($_GET["id"]) ? $_GET["id"] : "";
                                        $stock = $_POST["stock"];
                                        if (!is_numeric($stock) || !isset($_POST["stock"])) {
                                        ?>
                                        <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>
                                        <p>An error occurred. Please try again.</p>
                                        </div>
                                        <?php
                                        }else{
                                        $stock_list_pull = mysqli_query($con, "select * from stocks");
                                        $count = 0;
                                        while ($array_stock = mysqli_fetch_array($stock_list_pull)) {
                                        $count++;
                                        if ($count == $stock) {
                                        break;
                                        }
                                        }
                                       if ($array_stock[0] != $stock || $array_stock[0] == "") {
                                       ?>
                                        <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>
                                        <p>An error occurred. Please try again.</p>
                                        </div>
                                        <?php
                                       }else{
                                        $account = $_POST["account"];
                                        if(!is_numeric($account) || $account == ""){
                                        ?>
                                        <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>

                                        <p>An error occurred. Please try again.</p>
                                        </div>
                                        <?php
                                         }else{
                                        $account_check = mysqli_query($con,"select user_id,account_number from accounts where user_id='$user_id'");
                                        $count = 0;
                                        while($account_array=mysqli_fetch_array($account_check)){
                                            $count++;
                                            if($count == $account){
                                                break;
                                            }
                                        }
                                        if($account_array[0] == "" || $account_array[0] != $user_id){
                                            ?>
                                            <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5
                                            <p>An error occurred. Please try again.</p>
                                            </div>

                                            <?php
                                        }else{
                                        $quantity = $_POST["quantity"];
                                        if($quantity < 1 || !isset($_POST["quantity"]) || $_POST["quantity"] == ""){
                                        ?>
                                        <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5
                                        <p>You entered invalid value for stock quantity.</p>
                                        </div>
                                         <?php
                                        }else{
                                        ?>
                                        <div class="callout callout-warning"
                                             style="width:400px;margin:auto;position:relative;">
                                            <h5>Stock Buy Approval</h5>

                                            <p>You have <strong>20 seconds</strong> to approve this transaction. Please
                                                check below for transaction details.</p>
                                        </div>
                                        <?php
                                        require_once "../../func/functions.php";
                                        $stock_code = $array_stock[1];
                                        $array_stock_result = get_live_stock_value($stock_code);
                                        $date_of_data = $array_stock_result[0];
                                        $tp = $array_stock_result[1]*$quantity;
                                        $price_now = number_format($array_stock_result[1],2,",",".");
                                        $total_price = number_format($tp,2,",",".");
                                        date_default_timezone_set('America/Toronto');
                                        $date = date("Y-m-d H:i:s");
                                        $token = md5(uniqid().$date.rand(100000,999999));
                                        $stock_session_create = mysqli_query($con,"insert into stock_buy_session (user_id,token,date_data,stock_code,price_per_stock,total_price,completed,account_debited,quantity) values ('$user_id','$token','$date','$stock_code','$array_stock_result[1]','$tp','0','$account_array[1]','$quantity')");
                                        echo mysqli_error($con);
                                        if($stock_session_create){
                                            $_SESSION["stock-buy-approval"] = $token;
                                        }
                                        ?>
                                        <br>
                                        <section class="content" style="width:500px;margin:auto;position:relative;">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Stock Buy Approval Screen</h3>
                                                </div>
                                                    <div class="card-body">
                                                        <table width="100%">
                                                            <tr>
                                                                <td>Price Data Date:</td>
                                                                <td><? echo $date_of_data?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Price Per Stock:</td>
                                                                <td><? echo $price_now." USD"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Total Amount:</td>
                                                                <td><? echo $total_price." USD"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Account will be Debited:</td>
                                                                <td><? echo $account_array[1]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <a href="?s=buy-stocks&p=stock-details&t=stock-buy-approve&a=stock-buy-approve-process"><button type="button" class="btn btn-block btn-success" style="width:100%;">Approve Stock Buy</button></a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                            </div>
                                        </section>
                                        <?php
                                        }
                                        }
                                        }
                                        }
                                       }
                                       }
                                        }
                                        }
                                    }elseif($a == "stock-buy-approve-process"){
                                        $stock_buy_session = $_SESSION["stock-buy-approval"];
                                        if($stock_buy_session == "" || !isset($stock_buy_session)){
                                        ?>
                                            <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>
                                            <p>An error occurred. Please try again.</p>
                                            </div>
                                        <?php
                                         unset($_SESSION["stock-buy-approval"]);
                                        }else{
                                            $pull_session = mysqli_query($con,"select * from stock_buy_session where token='$stock_buy_session'");
                                            if(mysqli_num_rows($pull_session) == 0){
                                                ?>
                                                 <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>
                                            <p>An error occurred. Please try again</p>
                                            </div>
                                                <?php
                                             unset($_SESSION["stock-buy-approval"]);
                                            }else{
                                                date_default_timezone_set('America/Toronto');
                                                $current_time = date("Y-m-d H:i:s");
                                                $session_data_array = mysqli_fetch_array($pull_session);
                                                $diff = strtotime($current_time) - strtotime($session_data_array[3]);
                                                if($diff > 20){
                                                    ?>
                                                     <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                                     <h5>Error</h5>
                                                     <p>Stock buy session expired. Please approve your transaction in 20 seconds.</p>
                                                     </div>
                                                    <?php
                                                unset($_SESSION["stock-buy-approval"]);
                                                }else{
                                                    $user_account_check = mysqli_fetch_array(mysqli_query($con,"select user_id from accounts where account_number='$session_data_array[8]'"));
                                                    if($session_data_array[1] != $user_id || $user_account_check[0] != $user_id){
                                                        ?>
                                                        <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                                            <h5>Error</h5
                                                        <p>An error occurred. Please try again</p>
                                                        </div>
                                                        <?php

                                                    unset($_SESSION["stock-buy-approval"]);
                                                    }else{
                                                        require_once "../../func/functions.php";
                                                        $stock_code = $session_data_array[4];
                                                        $description = "Stock Bought: $stock_code";
                                                        $debit_account = debit_account($user_id,$session_data_array[8],$session_data_array[6],$description);
                                                        if($debit_account[0] != "OK"){
                                                            ?>
                                                            <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                                            <h5>Error</h5
                                                            <p><? echo $debit_account[0];?></p>
                                                            </div>

                                                            <?php
                                                         unset($_SESSION["stock-buy-approval"]);
                                                        }elseif($debit_account[0] == "OK"){
                                                            $stock_id = find_stock_id($session_data_array[4]);
                                                            $check_portfolio = mysqli_query($con,"select quantity,utoken from portfolio where user_id='$user_id' and stock_id='$stock_id'");
                                                            if(mysqli_num_rows($check_portfolio) != 0){
                                                                $portfolio_array = mysqli_fetch_array($check_portfolio);
                                                                $new_quantity = $portfolio_array[0] + $session_data_array[9];
                                                                $portfolio_update = mysqli_query($con,"update portfolio set quantity='$new_quantity' where user_id='$user_id' and stock_id='$stock_id'");
                                                                date_default_timezone_set('America/Toronto');
                                                                $date = date("Y-m-d H:i:s");
                                                                $portfolio_history_update = mysqli_query($con,"update portfolio_history set quantity='$new_quantity',date_updated='$date' where user_id='$user_id' and stock_id='$stock_id'");
                                                                if($portfolio_update && $portfolio_history_update){
                                                                    $stock_transaction_log_create = mysqli_query($con, "insert into stock_transaction_log (transaction_id,stock_id,price,quantity,transaction_type,portfolio_token) values ('$debit_account[1]','$stock_id','$session_data_array[5]','$session_data_array[9]','Buy','$portfolio_array[1]')");
                                                                    if ($stock_transaction_log_create) {
                                                                        $complete_session = mysqli_query($con, "update stock_buy_session set completed='1' where token='$session_data_array[2]'");
                                                                        if ($complete_session) {
                                                                            ?>
                                                                            <div class="callout callout-success"
                                                                                 style="width:400px;margin:auto;position:relative;">
                                                                                <h5>Transaction Completed</h5>
                                                                                <p>You have bought stocks successfully.
                                                                                    Stocks were added to your
                                                                                    portfolio.</p>
                                                                            </div>
                                                                            <?php
                                                                            unset($_SESSION["stock-buy-approval"]);
                                                                        }
                                                                    }
                                                                }
                                                            }else {
                                                                $u_token = md5(uniqid().rand(100000,999999).date("Y-m-d-H-i-s"));
                                                                $portfolio_create = mysqli_query($con, "insert into portfolio (user_id,stock_id,quantity,utoken) values ('$session_data_array[1]','$stock_id','$session_data_array[9]','$u_token')");
                                                                date_default_timezone_set('America/Toronto');
                                                                $date = date("Y-m-d H:i:s");
                                                                $portfolio_history_create = mysqli_query($con, "insert into portfolio_history (user_id,stock_id,quantity,utoken,date_updated,active) values ('$session_data_array[1]','$stock_id','$session_data_array[9]','$u_token','$date','1')");
                                                                if ($portfolio_create && $portfolio_history_create) {
                                                                 $stock_transaction_log_create = mysqli_query($con, "insert into stock_transaction_log (transaction_id,stock_id,price,quantity,transaction_type,portfolio_token) values ('$debit_account[1]','$stock_id','$session_data_array[5]','$session_data_array[9]','Buy','$u_token')");
                                                                    if ($stock_transaction_log_create) {
                                                                        $complete_session = mysqli_query($con, "update stock_buy_session set completed='1' where token='$session_data_array[2]'");
                                                                        if ($complete_session) {
                                                                            ?>
                                                                            <div class="callout callout-success"
                                                                                 style="width:400px;margin:auto;position:relative;">
                                                                                <h5>Transaction Completed</h5>
                                                                                <p>You have bought stocks successfully.
                                                                                    Stocks were added to your
                                                                                    portfolio.</p>
                                                                            </div>
                                                                            <?php
                                                                            unset($_SESSION["stock-buy-approval"]);
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                echo"</div>";
                }
                }
}elseif($s == "my-accounts"){
    $t = isset($_GET["t"])?$_GET["t"]:"";
    if($t == ""){
    ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>My Accounts</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                <li class="breadcrumb-item active">My Accounts</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <a href="?s=open-account">
                <button type="button" class="btn btn-block btn-primary" style="width:200px;margin:10px;">Open an
                    Account
                </button>
            </a>
            <?php
            $user_account_query = mysqli_query($con, "select * from accounts where user_id='$user_id'");
            if (mysqli_num_rows($user_account_query) == 0) {
                ?>
                <div class="callout callout-info" style="width:500px;margin:auto;position:relative;">
                    <h5>You do not have TurkTrade account.</h5>

                    <p>You do not have any accounts with TurkTrade. To open an account, click the button above.</p>
                </div>
                <?php
            } else {
                ?>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Accounts List</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Account Number</th>
                                                <th>Balance</th>
                                                <th>Available Balance</th>
                                                <th>Details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $account_order_count = 0;
                                            while ($account_array = mysqli_fetch_array($user_account_query)) {
                                                $account_order_count++;
                                                $balance = number_format($account_array[6], 2, ",", ".");
                                                $available_balance = number_format($account_array[7], 2, ",", ".");
                                                $overdraft_limit = number_format($account_array[8], 2, ",", ".");
                                                echo "
                                        <tr>
                                        <td>$account_array[2]</td>
                                        <td><strong>$balance $account_array[3]</strong></td>
                                        <td><strong>$available_balance $account_array[3]</strong></td>
                                        <td><strong><a href='?s=my-accounts&t=account-details&id=$account_order_count'><button type=\"button\" class=\"btn btn-block btn-info\">Details</button></a></strong></td>
                                        </tr>
                                            ";
                                            }

                                            ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>Account Number</th>
                                                <th>Balance</th>
                                                <th>Available Balance</th>
                                                <th>Details</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </section>
                <?php
            }
            echo "</div>";
            }elseif($t == "account-details"){
                ?>
                <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Account Details</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                    <li class="breadcrumb-item"><a href="?s=my-accounts">My Accounts</a></li>
                                    <li class="breadcrumb-item active">Account Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
                $id = isset($_GET["id"])?$_GET["id"]:"";
                if($id == "" || !is_numeric($id)){
                ?>
                    <div class="callout callout-danger" style="width:500px;margin:auto;position:relative;">
                        <h5>Error</h5>
                        <p>An error occurred. Please try again.</p>
                    </div>
                <?php
                }else{
                    $user_account_query = mysqli_query($con, "select * from accounts where user_id='$user_id'");
                    $count = 0;
                    while($account_array=mysqli_fetch_array($user_account_query)){
                        $count++;
                        if($count == $id){
                            break;
                        }
                    }
                    if($account_array[1] != $user_id){
                    ?>
                        <div class="callout callout-danger" style="width:50%;margin:auto;position:relative;">
                            <h5>Error</h5>
                            <p>An error occurred. Please try again.</p>
                        </div>
                    <?php
                    }else{
                        $account_number = $account_array[2];
                        $date_opened = $account_array[4];
                        $balance = number_format($account_array[6],2,",",".");
                        $available_balance = number_format($account_array[7],2,",",".");
                        $overdraft_limit = number_format($account_array[8],2,",",".");
                        $defined_overdraft_limit = number_format($account_array[9],2,",",".");
                        ?>
                <section class="content" style="width:500px;margin:auto;position:relative;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <!-- Default box -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Your Account's Details</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table width="100%">
                                            <tr>
                                                <td>Account Number:</td>
                                                <td><? echo $account_number; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Date Opened:</td>
                                                <td><? echo $date_opened; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Balance:</td>
                                                <td><? echo $balance." ". $account_array[3]; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Available Balance:</td>
                                                <td><? echo $available_balance." ". $account_array[3]; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Overdraft Limit:</td>
                                                <td><? echo $defined_overdraft_limit." ". $account_array[3]; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Available Overdraft Limit:</td>
                                                <td><? echo $overdraft_limit." ". $account_array[3]; ?></td>
                                            </tr>
                                            <tr><td colspan="2" style="text-align:center;font-weight: bold;"><hr>Deposit Funds<hr></td> </tr>
                                            <tr>
                                                <form action="?s=my-accounts&t=deposit-funds" method="post">
                                                <td><input type="number" name="amount" class="form-control" placeholder="Deposit Amount"></td>
                                                <td><input type="submit" value="Deposit Funds" class="btn btn-block btn-primary"></td>
                                                <input type="hidden" name="account" value="<? echo $count;?>">
                                                </form>
                                            </tr>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                </section>
                        <?php
                        $account_history_pull = mysqli_query($con,"select * from account_transaction_history where account_number='$account_number' ORDER BY id DESC");
                        if(mysqli_num_rows($account_history_pull) == 0){
                            ?>
                            <section>
                                <hr>
                                <h3>Account Transaction History</h3>
                                <div class="container-fluid">
                                    <div class="callout callout-info" style="width:400px;margin:auto;position:relative;">
                                        <h5>No Account History</h5>
                                         <p>Your account does not have transaction history.</p>
                                    </div>
                                </div>
                            </section>
                            <?php
                        }else {
                            ?>
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Your Account's Transaction History</h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                                        <table id="example1" class="table table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th>Date of Transaction</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                                <th>Before Balance</th>
                                                                <th>After Balance</th>
                                                                <th>Details</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            while($transaction_history_array = mysqli_fetch_array($account_history_pull)){
                                                                $amount = number_format($transaction_history_array[7],2,",",".");
                                                                $before_balance = number_format($transaction_history_array[5],2,",",".");
                                                                $after_balance = number_format($transaction_history_array[6],2,",",".");
                                                                echo"
                                                                <tr>
                                                                <td>$transaction_history_array[3]</td>
                                                                <td>$transaction_history_array[4]</td>
                                                                <td>$amount</td>
                                                                <td>$before_balance</td>
                                                                <td>$after_balance</td>
                                                                <td><button type=\"button\" class=\"btn btn-block btn-info\">Details</button></td>
                                                                </tr>
                                                                ";
                                                            }
                                                            ?>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Date of Transaction</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                                <th>Before Balance</th>
                                                                <th>After Balance</th>
                                                                <th>Details</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                            <?php
                        }
                    }
                }
                echo" </div>";
            }elseif($t == "deposit-funds"){
            ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Account Details</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                    <li class="breadcrumb-item"><a href="?s=my-accounts">My Accounts</a></li>
                                    <li class="breadcrumb-item">Account Details</li>
                                    <li class="breadcrumb-item active">Deposit Funds Credit Card Payment</li>
                                </ol>
                            </div>
                        </div>
                    </div>
            <?php
                if(!$_POST["amount"] || !$_POST["account"]){
                    ?>
                    <div class="callout callout-danger" style="width:500px;margin:auto;position:relative;">
                        <h5>Error</h5>
                        <p>An error occurred. Please try again.</p>
                    </div>
                    <?php
                }else{
                    $amount = $_POST["amount"];
                    $account = $_POST["account"];
                    if($amount < 0 || !is_numeric($amount) || !is_numeric($account) || $account < 1){
                        ?>
                        <div class="callout callout-danger" style="width:500px;margin:auto;position:relative;">
                        <h5>Error</h5>
                        <p>The amount format you entered is not valid.</p>
                         </div>
                        <?php
                    }else{
                        $account_check = mysqli_query($con,"select account_number from accounts where user_id='$user_id'");
                        $count = 0;
                        while($account_check__array=mysqli_fetch_array($account_check)){
                            $count++;
                            if($count == $account){
                                break;
                            }
                        }
                        if($account_check__array[0] == ""){
                            ?>
                            <div class="callout callout-danger" style="width:500px;margin:auto;position:relative;">
                            <h5>Error</h5>
                            <p>An error occurred. Please try again.</p>
                             </div>
                            <?php
                        }else{
                            $token = md5(uniqid().rand(100000,999999).date("Y-m-d-H-i-s"));
                            $amount = number_format($amount,2,".","");
                            $date = date("Y-m-d H:i:s");
                            $account_session_create = mysqli_query($con,"insert into fund_deposit_session (token,account_number,amount,date,completed,user_id) values ('$token','$account_check__array[0]','$amount','$date','0','$user_id')");
                            if($account_session_create){
                                ?>
                                <script src="https://js.stripe.com/v3/"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<style type="text/css">

    form {
        width: 100%;
        margin: 20px auto;
    }

    label {
        height: 35px;
        position: relative;
        color: #8798AB;
        display: block;
        margin-top: 30px;  margin-bottom: 20px;
    }

    label > span {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        font-weight: 300;
        line-height: 32px;
        color: #8798AB;
        border-bottom: 1px solid #586A82;
        transition: border-bottom-color 200ms ease-in-out;
        cursor: text;
        pointer-events: none;
    }

    label > span span {
        position: absolute;
        top: 0;
        left: 0;
        transform-origin: 0% 50%;
        transition: transform 200ms ease-in-out;
        cursor: text;
    }

    label .field.is-focused + span span,
    label .field:not(.is-empty) + span span {
        transform: scale(0.68) translateY(-36px);
        cursor: default;
    }

    label .field.is-focused + span {
        border-bottom-color: #34D08C;
    }

    .field {
        background: transparent;
        font-weight: 300;
        border: 0;
        color: white;
        outline: none;
        cursor: text;
        display: block;
        width: 100%;
        line-height: 32px;
        padding-bottom: 3px;
        transition: opacity 200ms ease-in-out;
    }

    .field::-webkit-input-placeholder { color: #8898AA; }
    .field::-moz-placeholder { color: #8898AA; }

    /* IE doesn't show placeholders when empty+focused */
    .field:-ms-input-placeholder { color: #424770; }

    .field.is-empty:not(.is-focused) {
        opacity: 0;
    }

    form > button {
        float: left;
        display: block;
        background: #34D08C;
        color: white;
        border-radius: 2px;
        border: 0;
        margin-top: 20px;
        font-size: 19px;
        font-weight: 400;
        width: 100%;
        height: 47px;
        line-height: 45px;
        outline: none;
    }

    button:focus {
        background: #24B47E;
    }

    button:active {
        background: #159570;
    }

    .outcome {
        float: left;
        width: 100%;
        padding-top: 8px;
        min-height: 20px;
        text-align: center;
    }

    .success, .error {
        display: none;
        font-size: 15px;
    }

    .success.visible, .error.visible {
        display: inline;
    }

    .error {
        color: #E4584C;
    }

    .success {
        color: #34D08C;
    }

    .success .token {
        font-weight: 500;
        font-size: 15px;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Deposit Funds Payment Form</h3>
                    </div>
                    <div class="card-body">
                         <form>
                             <input type="hidden" name="session-token" value="<? echo $token; ?>">
                            <label>
                                <div id="card-element" class="field is-empty"></div>
                                <span><span>Credit or debit card</span></span>
                            </label>
                            <button type="submit">Pay $<? echo $amount;?> USD</button>
                            <div class="outcome">
                                <div class="error" role="alert"></div>
                                <div class="success">
                                    <span class="result"></span>
                                </div>
                            </div>
                        </form>
                        <script>
                            var stripe = Stripe('pk_test_51GzelkKoyizV9YXqiLSFjTYF7UKu6ElviNfn8mfgrPlu5CvmHSGI2S3hl7QEN7utmr9D6E98Vx0lTg0TiDUNGFxA00Zb98N89T');
                            var elements = stripe.elements();

                            var card = elements.create('card', {
                                iconStyle: 'solid',
                                style: {
                                    base: {
                                        iconColor: '#8898AA',
                                        color: 'black',
                                        lineHeight: '36px',
                                        fontWeight: 300,
                                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                        fontSize: '19px',

                                        '::placeholder': {
                                            color: '#8898AA',
                                        },
                                    },
                                    invalid: {
                                        iconColor: '#e85746',
                                        color: '#e85746',
                                    }
                                },
                                classes: {
                                    focus: 'is-focused',
                                    empty: 'is-empty',
                                },
                            });
                            card.mount('#card-element');

                            var inputs = document.querySelectorAll('input.field');
                            Array.prototype.forEach.call(inputs, function(input) {
                                input.addEventListener('focus', function() {
                                    input.classList.add('is-focused');
                                });
                                input.addEventListener('blur', function() {
                                    input.classList.remove('is-focused');
                                });
                                input.addEventListener('keyup', function() {
                                    if (input.value.length === 0) {
                                        input.classList.add('is-empty');
                                    } else {
                                        input.classList.remove('is-empty');
                                    }
                                });
                            });

                            function setOutcome(result) {
                                var successElement = document.querySelector('.success');
                                var errorElement = document.querySelector('.error');
                                successElement.classList.remove('visible');
                                errorElement.classList.remove('visible');

                                if (result.token) {
                                    var form = document.querySelector('form');
                                      var userdata = {'token':result.token.id,'session-token':form.querySelector('input[name=session-token]').value};
                                    $.ajax({
                                        type: "POST",
                                        url: "process-credit-card.php",
                                        data:userdata,
                                        success: function(data){
                                            console.log(data);
                                            successElement.querySelector('.result').textContent = data;
                                            successElement.classList.add('visible');
                                        }
                                    });
                                } else if (result.error) {
                                    errorElement.textContent = result.error.message;
                                    errorElement.classList.add('visible');
                                }
                            }

                            card.on('change', function(event) {
                                setOutcome(event);
                            });

                            document.querySelector('form').addEventListener('submit', function(e) {
                                e.preventDefault();
                                stripe.createToken(card).then(setOutcome);
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

                                <?php
                            }
                        }
                    }
                }
                echo"</div>";
            }
}elseif($s == "open-account"){
    $token = $_SESSION["open-account-token"] = md5(uniqid().date("Y-m-d-h-i-s"));
    $time = date("Y-m-d H:i:s");
    $description = "Account Create Form Session";
    $token_row_create = mysqli_query($con,"insert into form_session (token,description,time,status) values ('$token','$description','$time','0')");
    if($token_row_create) {
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Open an Account</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                <li class="breadcrumb-item active">Open an Account</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content" style="width:400px;margin:auto;position:relative;">
                <div class="callout callout-warning">
                    <h5>You are about to open a TurkTrade account.</h5>

                    <p>We will open you a TurkTrade account in United States Dollars after you confirm your
                        password.</p>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Please Confirm Your Password Before Proceeding</h3>
                    </div>
                    <form action="?s=open-account-proceed" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       required>
                                <input type="hidden" name="token" value="<? echo $_SESSION["open-account-token"]; ?>">
                            </div>
                        </div>
                        <input type="submit" value="Proceed to Open Account" class="btn btn-block btn-info">
                    </form>
                </div>
            </section>
        </div>
        <?php
    }
}elseif($s == "open-account-proceed"){
    ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Open an Account</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                <li class="breadcrumb-item active">Open an Account Result</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
    <?php
    if(isset($_SESSION["open-account-token"]) && isset($_POST["token"])){
        $token = $_SESSION["open-account-token"];
        $form_session_pull = mysqli_fetch_array(mysqli_query($con,"select status from form_session where token='$token'"));
        if($_SESSION["open-account-token"] != $_POST["token"] || $form_session_pull[0] == 1){
            ?>
            <div class="callout callout-danger" style="width: 500px;margin:auto;position:relative;">
                <h5>Form submitted twice!</h5>

                <p>Because your form submitted more than once, we aborted the process. Please try again.</p>
            </div>
            <?php
        }else{
            $use_token = mysqli_query($con,"update form_session set status='1' where token='$token'");
            $password = $_POST["password"];
            if(empty($password)){
                ?>
                <div class="alert alert-danger alert-dismissible" style="width: 500px;margin:auto;position:relative;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    Please enter your password before submitting.
                </div>
                <?php
            }else{
                $password_query = mysqli_fetch_array(mysqli_query($con,"select password from Users where id='$user_id'"));
                if($password_query[0] != md5($password)){
                    ?>
                    <div class="alert alert-danger alert-dismissible" style="width: 500px;margin:auto;position:relative;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        We were not able to confirm your password therefore we aborted the process.
                    </div>
                    <?php
                }else{
                    $date = date("Y-m-d H:i:s");
                    $pull_last_number = mysqli_fetch_array(mysqli_query($con,"select account_number from account_number_count where id='1'"));
                    $new_account_number = $pull_last_number[0] + rand(100,999);
                    $update_account_number = mysqli_query($con,"update account_number_count set account_number='$new_account_number' where id='1'");
                    $create_account_user = mysqli_query($con,"insert into accounts (user_id,account_number,currency,date_opened,status,balance,available_balance,overdraft_limit,defined_overdraft_limit) values 
('$user_id','$new_account_number','USD','$date','1','0.00','0.00','0.00','')");
                    if($create_account_user){
                        ?>
                        <div class="alert alert-success alert-dismissible" style="width: 500px;margin:auto;position:relative;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Alert!</h5>
                            We have created an account in United States dollar. Now you can make transactions.
                        </div>
                        <?php
                    }
                }
            }
        }
    }
    ?>

            </div>
    <?php
}elseif($s == "my-portfolio"){
    $p = isset($_GET["p"])?$_GET["p"]:"";
    if($p == ""){
            ?>
                    <div class="content-wrapper">
                        <!-- Content Header (Page header) -->
                        <section class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h1>My Portfolio</h1>
                                    </div>
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                            <li class="breadcrumb-item active">My Portfolio</li>
                                        </ol>
                                    </div>
                                </div>
                            </div><!-- /.container-fluid -->
                        </section>
                        <?php
                        $pull_portfolio = mysqli_query($con, "select * from portfolio where user_id='$user_id' and quantity!='0'");
                        if (mysqli_num_rows($pull_portfolio) == 0) {
                            ?>
                            <div class="callout callout-warning" style="width:400px;margin:auto;position: relative;">
                                <h5>You do not have any stocks.</h5>

                                <p>You do not have stocks to view. To buy stocks, go to Buy Stocks menu.</p>
                            </div>
                            <?php
                        } else {
                            ?>
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">List of Stocks You Have</h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                                        <table id="example1" class="table table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th>Stock Code</th>
                                                                <th>Stock Name</th>
                                                                <th>Quantity You Have</th>
                                                                <th>Sell</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            require_once "../../func/functions.php";
                                                            $count = 0;
                                                            while ($portfolio_array = mysqli_fetch_array($pull_portfolio)) {
                                                                $count++;
                                                                $stock_code = find_stock_code($portfolio_array[2]);
                                                                $pull_stocks = mysqli_fetch_array(mysqli_query($con, "select security from stocks where symbol='$stock_code'"));
                                                                echo "
                                                                <tr>
                                                                <td>$stock_code</td>
                                                                <td>$pull_stocks[0]</td>
                                                                <td>$portfolio_array[3]</td>
                                                                <td><a href='?s=my-portfolio&p=stock-sell-screen&id=$count'><button type=\"button\" class=\"btn btn-block btn-info\">Sell</button></a></td>
                                                                </tr>
                                                                ";
                                                            }
                                                            ?>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Stock Code</th>
                                                                <th>Stock Name</th>
                                                                <th>Quantity You Have</th>
                                                                <th>Sell</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                            <?php
                        }
                        echo "</div>";
                        }elseif($p == "stock-sell-screen"){
                        ?>
                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1>Stock Selling Screen</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                                <li class="breadcrumb-item"><a href="?s=my-portfolio">My Portfolio</a></li>
                                                <li class="breadcrumb-item active">Stock Selling Screen</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div><!-- /.container-fluid -->
                            </section>
                            <?php
                            $id = isset($_GET["id"])?$_GET["id"]:"";
                            if($id == "" || !is_numeric($id)){
                                ?>
                                <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                    <h5>Error</h5>

                                    <p>An error occurred. Please try again.</p>
                                </div>
                                <?php
                            }else{
                                $pull_portfolio = mysqli_query($con, "select * from portfolio where user_id='$user_id' and quantity!='0'");
                                $count = 0;
                                while($portfolio_array = mysqli_fetch_array($pull_portfolio)){
                                    $count++;
                                    if($count == $id){
                                        break;
                                    }
                                }
                                if($portfolio_array[0] == "" || $portfolio_array[0] == 0){
                                    ?>
                                    <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>

                                        <p>An error occurred. Please try again.</p>
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                    <section class="content" style="width:400px;margin:auto;position:relative;">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Stock Selling Form</h3>
                                            </div>
                                            <form action="?s=my-portfolio&p=stock-sell-screen-approval" method="post">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Quantity of Stocks You are Selling</label>
                                                        <input type="text" name="quantity" class="form-control" placeholder="Quantity"
                                                               required>
                                                        <input type="hidden" name="stock" value="<? echo $id; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Select the account you want to get the funds</label>
                                                        <select name="account" class="form-control">
                                                            <?php
                                                                $pull_accounts = mysqli_query($con,"select account_number,available_balance from accounts where user_id='$user_id'");
                                                                $count = 0;
                                                                while($accounts_array = mysqli_fetch_array($pull_accounts)){
                                                                    $count++;
                                                                    echo"<option value='$count'>Account Number: $accounts_array[0] Available Balance:$$accounts_array[1] USD</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="submit" value="Proceed to Sell Your Stock" class="btn btn-block btn-info">
                                            </form>
                                        </div>
                                    </section>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                        }elseif($p == "stock-sell-screen-approval"){
                            ?>
                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1>Stock Selling Screen</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                                <li class="breadcrumb-item"><a href="?s=my-portfolio">My Portfolio</a></li>
                                                <li class="breadcrumb-item">Stock Selling Screen</li>
                                                <li class="breadcrumb-item active">Stock Selling Screen Approval</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div><!-- /.container-fluid -->
                            </section>
                            <?php
                            if(isset($_POST["stock"]) && isset($_POST["quantity"]) && isset($_POST["account"])) {
                                $stock = $_POST["stock"];
                                $quantity = $_POST["quantity"];
                                $account = $_POST["account"];
                                if($stock == "" || $account == "" || $quantity == "" || !is_numeric($quantity) || $quantity < 1 || !is_numeric($account) || !is_numeric($stock)){
                                ?>
                                    <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>

                                        <p>An error occurred. Please try again.</p>
                                    </div>
                                <?php
                                }else{
                                    $portfolio_pull = mysqli_query($con, "select * from portfolio where user_id='$user_id' and quantity!='0'");;
                                    $account_pull = mysqli_query($con,"select account_number from accounts where user_id='$user_id'");
                                    $count = 0;
                                    while($portfolio_array = mysqli_fetch_array($portfolio_pull)){
                                        $count++;
                                        if($count == $stock){
                                            break;
                                        }
                                    }
                                    if($portfolio_array[0] == "" || $portfolio_array == 0){
                                    ?>
                                        <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>

                                            <p>An error occurred. Please try again.</p>
                                        </div>
                                    <?php
                                    }else{
                                        $count = 0;
                                        while($account_array = mysqli_fetch_array($account_pull)){
                                            $count++;
                                            if($count == $account){
                                                break;
                                            }
                                        }
                                        if($account_array[0] == 0 || $account_array == ""){
                                        ?>
                                            <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                                <h5>Error</h5>

                                                <p>An error occurred. Please try again.</p>
                                            </div>
                                        <?php
                                        }else{
                                            if($portfolio_array[3] < $quantity){
                                                ?>
                                                <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                                    <h5>Error</h5>

                                                    <p>You do not have enough amount of stocks to sell. Please adjust your quantity.</p>
                                                </div>
                                                <?php
                                            }else {
                                                ?>
                                                <div class="callout callout-warning"
                                                     style="width:400px;margin:auto;position:relative;">
                                                    <h5>Stock Sell Approval</h5>

                                                    <p>You have <strong>20 seconds</strong> to approve this transaction.
                                                        Please
                                                        check below for transaction details.</p>
                                                </div>
                                                <?php
                                                require_once "../../func/functions.php";
                                                $stock_code = find_stock_code($portfolio_array[2]);
                                                $stock_value = get_live_stock_value($stock_code);
                                                $stock_value_per_stock = number_format($stock_value[1], 2, ".", "");
                                                $total_price = $stock_value_per_stock * $quantity;
                                                date_default_timezone_set('America/Toronto');
                                                $token = uniqid().rand(100000,999999).date("Y-m-d-H-i-s");
                                                $date = date("Y-m-d H:i:s");
                                                $sell_stock_session_create = mysqli_query($con,"insert into stock_sell_session (user_id,token,date_data,stock_code,price_per_stock,total_price,completed,account_credited,quantity) values ('$user_id','$token','$date','$stock_code','$stock_value_per_stock','$total_price','0','$account_array[0]','$quantity') ");
                                                if($sell_stock_session_create) {
                                                    $_SESSION["stock-sell-session"] = $token;
                                                    ?>
                                                    <section class="content"
                                                             style="width:500px;margin:auto;position:relative;">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Stock Sell Approval Screen</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td>Price Data Date:</td>
                                                                        <td><? echo $stock_value[0] ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Price Per Stock:</td>
                                                                        <td><? echo number_format($stock_value[1], 2, ",", ".") . " USD"; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Total Amount:</td>
                                                                        <td><? echo number_format(($stock_value_per_stock * $quantity), 2, ",", ".") . " USD"; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Account will be Credited:</td>
                                                                        <td><? echo $account_array[0]; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <a href="?s=my-portfolio&p=stock-sell-process">
                                                                                <button type="button"
                                                                                        class="btn btn-block btn-success"
                                                                                        style="width:100%;">Approve
                                                                                    Stock Sell Transaction
                                                                                </button>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>

                                                        </div>
                                                    </section>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            }else{
                                ?>
                                <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                    <h5>Error</h5>

                                    <p>An error occurred. Please try again.</p>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                            <?php
                        }elseif($p == "stock-sell-process"){
                        ?>
                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1>Stock Selling Screen</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                                <li class="breadcrumb-item"><a href="?s=my-portfolio">My Portfolio</a></li>
                                                <li class="breadcrumb-item">Stock Selling Screen</li>
                                                <li class="breadcrumb-item">Stock Selling Screen Approval</li>
                                                <li class="breadcrumb-item active">Stock Selling Process</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div><!-- /.container-fluid -->
                            </section>
                            <?php
                            if($_SESSION["stock-sell-session"] == "" || !isset($_SESSION["stock-sell-session"])){
                                unset($_SESSION["stock-sell-session"]);
                                ?>
                                <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                    <h5>Error</h5>

                                    <p>An error occurred. Please try again.</p>
                                </div>
                                <?php
                            }else{
                                $token = $_SESSION["stock-sell-session"];
                                $stock_sell_session_pull = mysqli_query($con,"select * from stock_sell_session where token='$token'");
                                if(mysqli_num_rows($stock_sell_session_pull) == 0){
                                    unset($_SESSION["stock-sell-session"]);
                                    ?>
                                    <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>

                                        <p>An error occurred. Please try again.</p>
                                    </div>
                                    <?php
                                }else{
                                    $session_array = mysqli_fetch_array($stock_sell_session_pull);
                                    if($session_array[1] != $user_id){
                                        unset($_SESSION["stock-sell-session"]);
                                        ?>
                                        <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>

                                            <p>An error occurred. Please try again.</p>
                                        </div>
                                        <?php
                                    }else{
                                        date_default_timezone_set('America/Toronto');
                                        $current_time = date("Y-m-d H:i:s");
                                        $session_date = $session_array[3];
                                        $diff = strtotime($current_time) - strtotime($session_date);
                                        if($diff > 20){
                                            unset($_SESSION["stock-sell-session"]);
                                            ?>
                                            <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                                <h5>Error</h5>
                                                <p>Stock sell session expired. Please approve your transaction in 20 seconds.</p>
                                            </div>
                                            <?php
                                        }else{
                                            $account_pull = mysqli_query($con,"select user_id from accounts where account_number='$session_array[8]'");
                                            $account_array = mysqli_fetch_array($account_pull);
                                            if($account_array[0] != $user_id){
                                                ?>
                                                <div class="callout callout-danger" style="width:400px;margin:auto;position:relative;">
                                                    <h5>Error</h5>
                                                    <p>Stock sell session expired. Please approve your transaction in 20 seconds.</p>
                                                </div>
                                                <?php
                                            }else{
                                                require_once "../../func/functions.php";
                                                $stock_id = find_stock_id($session_array[4]);
                                                $pull_portfolio = mysqli_query($con,"select * from portfolio where user_id='$user_id' and stock_id='$stock_id'");
                                                $portfolio_array = mysqli_fetch_array($pull_portfolio);
                                                if($portfolio_array[3] == $session_array[9]){
                                                    $update_portfolio_history = mysqli_query($con,"update portfolio_history set quantity='0',date_updated='$current_time',active='0' where utoken='$portfolio_array[4]'");
                                                    if($update_portfolio_history) {
                                                        $update_portfolio = mysqli_query($con,"delete from portfolio where utoken='$portfolio_array[4]'");
                                                        if($update_portfolio) {
                                                            $description = "Stock sold: $session_array[4] Quantity: $session_array[9]";
                                                            $credit_account = credit_account($user_id, $session_array[8], $session_array[6], $description);
                                                            if ($credit_account[0] == "OK") {
                                                                $create_stock_transaction_log = mysqli_query($con, "insert into stock_transaction_log (transaction_id,stock_id,price,quantity,transaction_type,portfolio_token) values ('$credit_account[1]','$stock_id','$session_array[5]','$session_array[9]','Sell','$portfolio_array[4]')");
                                                                if ($create_stock_transaction_log) {
                                                                    $complete_session = mysqli_query($con, "update stock_sell_session set completed='1' where token='$token'");
                                                                    if ($complete_session) {
                                                                        unset($_SESSION["stock-sell-session"]);
                                                                        ?>
                                                                        <div class="callout callout-success"
                                                                             style="width:400px;margin:auto;position:relative;">
                                                                            <h5>Transaction Completed</h5>
                                                                            <p>You have sold stocks successfully.
                                                                                Funds were added to your
                                                                                selected account.</p>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    $new_quantity = $portfolio_array[3] - $session_array[9];
                                                    $update_portfolio_history = mysqli_query($con,"update portfolio_history set quantity='$new_quantity',date_updated='$current_time' where utoken='$portfolio_array[4]'");
                                                    if($update_portfolio_history){
                                                        $update_portfolio = mysqli_query($con,"update portfolio set quantity='$new_quantity' where utoken='$portfolio_array[4]'");
                                                        if($update_portfolio){
                                                            $description = "Stock sold: $session_array[4] Quantity: $session_array[9]";
                                                            $credit_account = credit_account($user_id,$session_array[8],$session_array[6],$description);
                                                            if($credit_account[0] == "OK"){
                                                                $create_stock_transaction_log = mysqli_query($con,"insert into stock_transaction_log (transaction_id,stock_id,price,quantity,transaction_type,portfolio_token) values ('$credit_account[1]','$stock_id','$session_array[5]','$session_array[9]','Sell','$portfolio_array[4]')");
                                                                if($create_stock_transaction_log){
                                                                    $complete_session = mysqli_query($con,"update stock_sell_session set completed='1' where token='$token'");
                                                                    if($complete_session){
                                                                        unset($_SESSION["stock-sell-session"]);
                                                                        ?>
                                                                        <div class="callout callout-success"
                                                                             style="width:400px;margin:auto;position:relative;">
                                                                            <h5>Transaction Completed</h5>
                                                                            <p>You have sold stocks successfully.
                                                                                Funds were added to your
                                                                                selected account.</p>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <?php
                        }
                        }elseif($s == "transfer"){
                        ?>
                        <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1>Transfer Between Accounts</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Dashboard Home</a></li>
                                                <li class="breadcrumb-item active">Transfer Funds</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div><!-- /.container-fluid -->
                            </section>
                        <?php
                        $accounts_pull = mysqli_query($con,"select * from accounts where user_id='$user_id' and status !=0");
                        if(mysqli_num_rows($accounts_pull) == 0){
                            ?>
                            <div class="callout callout-warning">
                                <h5>You do not have any accounts.</h5>

                                <p>You do not have account to make transfer.</p>
                            </div>
                            <?php
                        }else{
                            $p = isset($_GET["p"]) ? $_GET["p"] : "";
                            if ($p == "") {
                                ?>
                                <section class="content" style="width:400px;margin:auto;position:relative;">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Please Make a Selection</h3>
                                        </div>
                                        <form action="?s=transfer&p=account-select" method="post">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input type="radio" name="transfer-type" class="form-check-input"
                                                           value="1">
                                                    <label class="form-check-label">I want to transfer between my
                                                        accounts</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" name="transfer-type" class="form-check-input"
                                                           value="2">
                                                    <label class="form-check-label">I want to transfer to another
                                                        TurkTrade account</label>
                                                </div>
                                            </div>
                                            <input type="submit" value="Next Step: Account Selection"
                                                   class="btn btn-block btn-info">
                                        </form>
                                    </div>
                                </section>
                                <?php
                            } elseif ($p == "account-select") {
                                $transfer_type = $_POST["transfer-type"];
                                if($transfer_type == "" || !isset($_POST["transfer-type"])){
                                ?>
                                    <div class="callout callout-danger"
                                         style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>

                                        <p>You did not make required selection.</p>
                                    </div>
                                <?php
                                }else {
                                    if (!is_numeric($transfer_type) || $transfer_type != 1 && $transfer_type != 2) {
                                        ?>
                                        <div class="callout callout-danger"
                                             style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>

                                            <p>An error occurred. Please try again.</p>
                                        </div>
                                        <?php
                                    } else {
                                        if($transfer_type == 1 || $transfer_type == 2) {
                                            ?>
                                            <section class="content" style="width:400px;margin:auto;position:relative;">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Select the source of funds</h3>
                                                    </div>
                                                    <form action="?s=transfer&p=target-account" method="post">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Select the account
                                                                    you are transferring funds from</label>
                                                                <select name="account-from" class="form-control">
                                                                    <?php
                                                                    $count = 0;
                                                                    while ($account_pull_array = mysqli_fetch_array($accounts_pull)) {
                                                                        $count++;
                                                                        echo "<option value='$count'>Account Number: $account_pull_array[2] Available Balance: $account_pull_array[7] $account_pull_array[3]</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <small class="form-text text-muted">We'll debit this account.</small>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="transfer-type" value="<? echo $transfer_type;?>">
                                                        <input type="submit" value="Step 2: Select Target Account"
                                                               class="btn btn-block btn-info">
                                                    </form>
                                                </div>
                                            </section>
                                            <?php
                                        }
                                    }
                                }
                            }elseif($p == "target-account"){
                                $account_from = $_POST["account-from"];
                                $transfer_type = $_POST["transfer-type"];
                                if(!is_numeric($account_from) || $account_from == "" || $account_from < 1 || $transfer_type == "" || !isset($_POST["transfer-type"]) || !is_numeric($transfer_type) || $transfer_type != 1 && $transfer_type != 2){
                                ?>
                                    <div class="callout callout-danger"
                                         style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>

                                        <p>An error occurred. Please try again.</p>
                                    </div>
                                <?php
                                }else {
                                    $count = 0;
                                    while ($account_pull_array = mysqli_fetch_array($accounts_pull)) {
                                        $count++;
                                        if($count == $account_from){
                                            break;
                                        }
                                    }
                                    if($account_pull_array[0] == 0 || $account_pull_array == ""){
                                    ?>
                                        <div class="callout callout-danger"
                                             style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>

                                            <p>An error occurred. Please try again.</p>
                                        </div>
                                    <?php
                                    }else{
                                        if($transfer_type == 1){
                                                                    $target_account_pull = mysqli_query($con,"select * from accounts where user_id='$user_id' and currency='$account_pull_array[3]' and status!='0' and account_number!='$account_pull_array[2]'");
                                                                    if(mysqli_num_rows($target_account_pull) == 0){
                                                                    ?>
                                                                        <div class="callout callout-danger"
                                                                             style="width:400px;margin:auto;position:relative;">
                                                                            <h5>Error</h5>

                                                                            <p>You do not have any available account to transfer to. This error may occur if you have inactive accounts, account in other currency or only one account.</p>
                                                                        </div>

                                                                    <?php
                                                                    }else {
                                                                        ?>
                                                                        <section class="content" style="width:400px;margin:auto;position:relative;">
                                                                            <div class="card card-primary">
                                                                                <div class="card-header">
                                                                                    <h3 class="card-title">Select the target of funds</h3>
                                                                                </div>
                                                                                <form action="?s=transfer&p=transfer-approval" method="post">
                                                                                    <div class="card-body">
                                                                                        <div class="form-group">
                                                                                            <label>Select the account
                                                                                                you are transferring funds to</label>
                                                                                            <select name="account-to" class="form-control">
                                                                        <?php
                                                                        $count = 0;
                                                                        while ($account_pull_array = mysqli_fetch_array($target_account_pull)) {
                                                                            $count++;
                                                                            echo "<option value='$count'>Account Number: $account_pull_array[2] Available Balance: $account_pull_array[7] $account_pull_array[3]</option>";
                                                                        }
                                                                        ?>
                                                                        </select>
                                                                        <small class="form-text text-muted">We'll credit this account.</small>
                                                                        <div class="form-group">
                                                                            <label>Amount of Transfer</label>
                                                                            <input type="number" name="amount" class="form-control" placeholder="Amount of Transfer"> <? echo "$account_pull_array[3]";?>
                                                                        </div>

                                                                        </div>
                                                                        </div>
                                                                        <input type="hidden" name="account-from"
                                                                               value="<? echo $account_from; ?>">
                                                                        <input type="hidden" name="transfer-type"
                                                                               value="<? echo $transfer_type; ?>">
                                                                        <input type="submit"
                                                                               value="Step 3: Transfer Approval"
                                                                               class="btn btn-block btn-info">
                                                                        </form>
                                                                        </div>
                                                                        </section>
                                                                        <?php
                                                                    }
                                        }elseif($transfer_type == 2){
                                        ?>
                                            <section class="content" style="width:400px;margin:auto;position:relative;">
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Select the source of funds</h3>
                                                    </div>
                                                    <form action="?s=transfer&p=transfer-approval" method="post">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label>Enter the account number
                                                                    you are transferring funds to</label>
                                                                <input type="number" name="account-to" class="form-control">
                                                                <small class="form-text text-muted">We'll credit this account.</small>
                                                                <div class="form-group">
                                                                    <label>Amount of Transfer</label>
                                                                    <input type="number" name="amount" class="form-control" placeholder="Amount of Transfer"> <? echo "$account_pull_array[3]";?>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="account-from"
                                                               value="<? echo $account_from; ?>">
                                                        <input type="hidden" name="transfer-type"
                                                               value="<? echo $transfer_type; ?>">
                                                        <input type="submit"
                                                               value="Step 3: Transfer Approval"
                                                               class="btn btn-block btn-info">
                                                    </form>
                                                </div>
                                            </section>
                                        <?php
                                        }
                                    }
                                }
                            }elseif($p == "transfer-approval"){
                                $account_from = $_POST["account-from"];
                                $account_to = $_POST["account-to"];
                                $transfer_type = $_POST["transfer-type"];
                                $amount = $_POST["amount"];
                                if(!is_numeric($account_from) || $account_from == "" || $account_from < 1 || !is_numeric($account_to) || $account_to == "" || $account_to < 1 || $transfer_type == "" || !isset($_POST["transfer-type"]) || $amount <= 0 || !is_numeric($amount) || !is_numeric($transfer_type) || $transfer_type != 1 && $transfer_type != 2){
                                    ?>
                                    <div class="callout callout-danger"
                                         style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>

                                        <p>An error occurred. Please try again.</p>
                                    </div>
                                    <?php
                                }else{
                                    if($amount == ""){
                                        ?>
                                        <div class="callout callout-danger"
                                             style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>

                                            <p>You did not fill required amount area.</p>
                                        </div>
                                        <?php
                                    }else{
                                        $count = 0;
                                        while ($account_pull_array = mysqli_fetch_array($accounts_pull)) {
                                            $count++;
                                            if($count == $account_from){
                                                break;
                                            }
                                        }
                                        if($account_pull_array[0] == 0 || $account_pull_array == ""){
                                            ?>
                                            <div class="callout callout-danger"
                                                 style="width:400px;margin:auto;position:relative;">
                                                <h5>Error</h5>

                                                <p>An error occurred. Please try again.</p>
                                            </div>
                                            <?php
                                        }else {
                                            if ($transfer_type == 1) {
                                                $target_account_pull = mysqli_query($con, "select * from accounts where user_id='$user_id' and currency='$account_pull_array[3]' and status!='0' and account_number!='$account_pull_array[2]'");
                                                $count = 0;
                                                while ($target_account_pull_array = mysqli_fetch_array($target_account_pull)) {
                                                    $count++;
                                                    if ($count == $account_to) {
                                                        break;
                                                    }
                                                }
                                                if ($target_account_pull_array[0] == 0 || $target_account_pull_array == "") {
                                                    ?>
                                                    <div class="callout callout-danger"
                                                         style="width:400px;margin:auto;position:relative;">
                                                        <h5>Error</h5>

                                                        <p>An error occurred. Please try again.</p>
                                                    </div>
                                                    <?php
                                                } else {
                                                    date_default_timezone_set('America/Toronto');
                                                    $date = date("Y-m-d H:i:s");
                                                    $token = md5(uniqid() . $date . rand(100000, 999999));
                                                    $create_transfer_session = mysqli_query($con, "insert into fund_transfer_session (user_id,token,date,transfer_type,account_from,account_to,amount,completed) values ('$user_id','$token','$date','$transfer_type','$account_pull_array[2]','$target_account_pull_array[2]','$amount','0')");
                                                    if ($create_transfer_session) {
                                                        $_SESSION["transfer-funds"] = $token;
                                                        ?>

                                                        <section class="content"
                                                                 style="width:400px;margin:auto;position:relative;">
                                                            <div class="card card-primary">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">Approval Screen</h3>
                                                                </div>
                                                                <form action="?s=transfer&p=transfer-process"
                                                                      method="post">
                                                                    <div class="card-body">
                                                                        <table width="100%">
                                                                            <tr>
                                                                                <td>
                                                                                    Source Account:
                                                                                </td>
                                                                                <td>
                                                                                    <? echo $account_pull_array[2]; ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Target Account:
                                                                                </td>
                                                                                <td>
                                                                                    <? echo $target_account_pull_array[2]; ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Amount:
                                                                                </td>
                                                                                <td>
                                                                                    <? echo $amount . " " . $target_account_pull_array[3]; ?>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <input type="submit"
                                                                               value="Final Step: Approve Your Transfer"
                                                                               class="btn btn-block btn-info">
                                                                </form>
                                                            </div>
                                                        </section>
                                                        <?php
                                                    }
                                                }
                                            }elseif($transfer_type == 2){
                                                require_once "../../func/functions.php";
                                                $pull_other_account = find_account_information($user_id,$account_to,$account_pull_array[3]);
                                                if($pull_other_account[0] != "OK"){
                                                    ?>
                                                    <div class="callout callout-danger"
                                                         style="width:400px;margin:auto;position:relative;">
                                                        <h5>Error</h5>

                                                        <p><? echo $pull_other_account[0];?></p>
                                                    </div>
                                                    <?php
                                                }else{
                                                    date_default_timezone_set('America/Toronto');
                                                    $date = date("Y-m-d H:i:s");
                                                    $token = md5(uniqid() . $date . rand(100000, 999999));
                                                    $create_transfer_session = mysqli_query($con, "insert into fund_transfer_session (user_id,token,date,transfer_type,account_from,account_to,amount,completed) values ('$user_id','$token','$date','$transfer_type','$account_pull_array[2]','$account_to','$amount','0')");
                                                    if($create_transfer_session){
                                                        $_SESSION["transfer-funds"] = $token;
                                                        ?>
                                                        <section class="content"
                                                                 style="width:400px;margin:auto;position:relative;">
                                                            <div class="card card-primary">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">Approval Screen</h3>
                                                                </div>
                                                                <form action="?s=transfer&p=transfer-process"
                                                                      method="post">
                                                                    <div class="card-body">
                                                                        <table width="100%">
                                                                            <tr>
                                                                                <td>
                                                                                    Source Account:
                                                                                </td>
                                                                                <td>
                                                                                    <? echo $account_pull_array[2]; ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Target Account:
                                                                                </td>
                                                                                <td>
                                                                                    <? echo $account_to; ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Owner of Target Account:
                                                                                </td>
                                                                                <td>
                                                                                    <? echo $pull_other_account[1]; ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Amount:
                                                                                </td>
                                                                                <td>
                                                                                    <? echo $amount . " " . $account_pull_array[3]; ?>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <input type="submit"
                                                                               value="Final Step: Approve Your Transfer"
                                                                               class="btn btn-block btn-info">
                                                                </form>
                                                            </div>
                                                        </section>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }elseif($p == "transfer-process"){
                                if(!isset($_SESSION["transfer-funds"]) || $_SESSION["transfer-funds"] == ""){
                                ?>
                                    <div class="callout callout-danger"
                                         style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>

                                        <p>An error occurred. Please try again.</p>
                                    </div>
                                <?php
                                }else{
                                    $token = $_SESSION["transfer-funds"];
                                    $transfer_session_pull = mysqli_query($con,"select * from fund_transfer_session where token='$token' and user_id='$user_id'");
                                    if(mysqli_num_rows($transfer_session_pull) == 0){
                                        ?>
                                        <div class="callout callout-danger"
                                             style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>

                                            <p>An error occurred. Please try again.</p>
                                        </div>
                                        <?php
                                    }else{
                                        $transfer_session_array = mysqli_fetch_array($transfer_session_pull);
                                        if($transfer_session_array[1] != $user_id){
                                            ?>
                                            <div class="callout callout-danger"
                                                 style="width:400px;margin:auto;position:relative;">
                                                <h5>Error</h5>

                                                <p>An error occurred. Please try again.</p>
                                            </div>
                                            <?php
                                        }else {
                                            require_once "../../func/functions.php";
                                            $account_from = $transfer_session_array[5];
                                            $account_to = $transfer_session_array[6];
                                            $other_user_id = find_user_id_by_account_number($account_to);
                                            if($other_user_id[0] != "OK"){
                                                ?>
                                                <div class="callout callout-danger"
                                                     style="width:400px;margin:auto;position:relative;">
                                                    <h5>Error</h5>

                                                    <p><? echo $other_user_id[0];?></p>
                                                </div>
                                                <?php
                                            }else {
                                                $amount = $transfer_session_array[7];
                                                $description_from = "Outgoing Transfer to Account: $account_to";
                                                $debit_account = debit_account($user_id, $account_from, $amount, $description_from);
                                                if ($debit_account[0] == "OK") {
                                                    $description_to = "Incoming Transfer from : $account_from";
                                                    $credit_account = credit_account($other_user_id[1], $account_to, $amount, $description_to);
                                                    if ($credit_account[0] == "OK") {
                                                        date_default_timezone_set('America/Toronto');
                                                        $date = date("Y-m-d H:i:s");
                                                        $fund_transfer_log = mysqli_query($con, "insert into fund_transfer_log (account_from_transaction_id,account_to_transaction_id,amount,date) values ('$debit_account[1]','$credit_account[1]','$amount','$date')");
                                                        if ($fund_transfer_log) {
                                                            $complete = mysqli_query($con, "update fund_transfer_session set completed='1' where token='$token'");
                                                            if ($complete) {
                                                                ?>
                                                                <div class="callout callout-success"
                                                                     style="width:400px;margin:auto;position:relative;">
                                                                    <h5>Transaction Completed</h5>
                                                                    <p>Transfer completed successfully.</p>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                } elseif ($debit_account[0] != "OK") {
                                                    ?>
                                                    <div class="callout callout-danger"
                                                         style="width:400px;margin:auto;position:relative;">
                                                        <h5>Error</h5>

                                                        <p><? echo $debit_account[0]; ?></p>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            }
                        echo "</div>";
                        }elseif($s == "profile"){
                        ?>
                            <div class="content-wrapper">
                            <!-- Content Header (Page header) -->
                            <section class="content-header">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1>Profile</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Dashboard
                                                        Home</a></li>
                                                <li class="breadcrumb-item active">Profile</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div><!-- /.container-fluid -->
                            </section>
                        <?php
                            $p = isset($_GET["p"])?$_GET["p"]:"";
                            if($p == "") {
                                ?>
                                    <section class="content">
                                        <table width="20%">
                                            <tr>
                                                <td>
                                                    <a href="?s=profile&p=change-password">
                                                        <button type="button" class="btn btn-block btn-primary"
                                                                style="width:200px;margin:10px;">Change Your Password
                                                        </button>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="?s=profile&p=change-picture">
                                                        <button type="button" class="btn btn-block btn-primary"
                                                                style="width:300px;margin:10px;">Change Your Profile
                                                            Picture
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </section>
                                <?php
                            }elseif($p == "change-picture"){
                            ?>
                                <section class="content" style="width:400px;margin:auto;position:relative;">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Changing the Profile Picture</h3>
                                        </div>
                                        <form action="?s=profile&p=change-picture-process" method="post" enctype="multipart/form-data">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Select your Picture</label>
                                                    <input type="file" name="pic" class="form-control-file" required>
                                                </div>
                                            </div>
                                            <input type="submit" value="Change Your Profile Picture" class="btn btn-block btn-info">
                                        </form>
                                    </div>
                                </section>
                            <?php
                            }elseif($p == "change-picture-process"){
                                if(!file_exists($_FILES['pic']['tmp_name']) || !is_uploaded_file($_FILES['pic']['tmp_name'])) {
                                    ?>
                                    <div class="callout callout-danger"
                                         style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>

                                        <p>You did not upload a picture.</p>
                                    </div>
                                    <?php
                                }else{
                                    $file_type = $_FILES['pic']['type'];
                                    $allowed = array("image/jpeg", "image/png");
                                    if(!in_array($file_type, $allowed)) {
                                        ?>
                                        <div class="callout callout-danger"
                                             style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>

                                            <p>Only jpg, jpeg and png files are allowed.</p>
                                        </div>
                                        <?php
                                    }else{
                                        $file = $_FILES['pic']['tmp_name'];
                                        $file_name = $_FILES['pic']['name'];
                                        $unique_name = md5(uniqid().rand(100000.999999).date("Y-m-d-H-i-s")).$file_name;
                                        date_default_timezone_set('America/Toronto');
                                        $date = date("Y-m-d H:i:s");
                                        $create_pic = mysqli_query($con,"insert into profile_picture (user_id,directory,original_name,date_uploaded) values ('$user_id','$unique_name','$file_name','$date')");
                                        if($create_pic) {
                                            if (move_uploaded_file($file, "../../pictures/$unique_name")) {
                                                ?>
                                                <div class="callout callout-success"
                                                     style="width:400px;margin:auto;position:relative;">
                                                    <h5>Picture Uploaded</h5>
                                                    <p>Your profile picture has been changed.</p>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            }elseif($p == "change-password"){
                                ?>
                                <section class="content" style="width:400px;margin:auto;position:relative;top:30px;">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Changing the Password</h3>
                                        </div>
                                        <form action="?s=profile&p=change-password-process" method="post">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Enter Your Current Password</label>
                                                    <input type="password" name="current_password" class="form-control" placeholder="Your Current Password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Enter Your New Password</label>
                                                    <input type="password" name="password" class="form-control" placeholder="Your New Password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Repeat Your New Password</label>
                                                    <input type="password" name="password2" class="form-control" placeholder="Repeat Your New Password" required>
                                                </div>
                                            </div>
                                            <input type="submit" value="Step2: E-Mail Verification" class="btn btn-block btn-info">
                                        </form>
                                    </div>
                                </section>
                                <?php
                            }elseif($p == "change-password-process"){
                                if(!$_POST){
                                    ?>
                                    <div class="callout callout-danger"
                                         style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>
                                        <p>An error occurred.</p>
                                    </div>
                                    <?php
                                }else {
                                    require_once "../../func/functions.php";
                                    $current_password = $_POST["current_password"];
                                    $password = $_POST["password"];
                                    $password2 = $_POST["password2"];
                                    if ($current_password == "" || $password == "" || $password2 == "") {
                                        ?>
                                        <div class="callout callout-danger"
                                             style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>
                                            <p>You did not provide your password information. Transaction Cancelled.</p>
                                        </div>
                                        <?php
                                    } else {
                                        $check_current_password = mysqli_fetch_array(mysqli_query($con, "select password from Users where id='$user_id'"));
                                        if ($check_current_password[0] != md5($current_password)) {
                                            ?>
                                            <div class="callout callout-danger"
                                                 style="width:400px;margin:auto;position:relative;">
                                                <h5>Error</h5>
                                                <p>We could not verify your current password. Transaction cancelled.
                                                    Session
                                                    Aborted. Please login again.</p>
                                            </div>
                                            <?php
                                            unset($_SESSION["myturktrade"]);
                                        } elseif ($password != $password2) {
                                            ?>
                                            <div class="callout callout-danger"
                                                 style="width:400px;margin:auto;position:relative;">
                                                <h5>Error</h5>
                                                <p>Your new passwords do not match.</p>
                                            </div>
                                            <?php
                                        } elseif (strlen($password) < 6) {
                                            ?>
                                            <div class="callout callout-danger"
                                                 style="width:400px;margin:auto;position:relative;">
                                                <h5>Error</h5>
                                                <p>Your password should be at least 6 characters.</p>
                                            </div>
                                            <?php
                                        } else {
                                            $random_number = rand(10000000, 99999999);
                                            $subject = "Change Password Request";
                                            $message = "We received your password change request. Please use this code to change your password. Your code is: $random_number";
                                            $send_mail = send_e_mail_from_dashboard($user_email, $subject, $message);
                                            date_default_timezone_set('America/Toronto');
                                            $date = date("Y-m-d H:i:s");
                                            $new_password = md5($password);
                                            $token = md5(uniqid() . date("Y-m-d-H-i-s") . rand(100000, 999999));
                                            $password_change_session = mysqli_query($con, "insert into password_change (user_id,new_password,email_code,token,date,completed) values ('$user_id','$new_password','$random_number','$token','$date','0')");
                                            $_SESSION["password_change"] = $token;
                                            if ($send_mail && $password_change_session) {
                                                ?>
                                                <div class="callout callout-warning"
                                                     style="margin:auto;position:relative;width:400px;">
                                                    <h5>Verification E-Mail sent.</h5>
                                                    <p>We sent a one time security code to your e-mail address for your
                                                        password
                                                        change request. Please enter that code below.</p>
                                                </div>
                                                <section class="content"
                                                         style="width:400px;margin:auto;position:relative;top:30px;">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Verification</h3>
                                                        </div>
                                                        <form action="?s=profile&p=change-password-process-finish"
                                                              method="post">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label>Enter the E-Mail Code</label>
                                                                    <input type="text" name="code" class="form-control"
                                                                           placeholder="E-Mail Code" autocomplete="off" required>
                                                                </div>
                                                            </div>
                                                            <input type="submit" value="Change Your Password"
                                                                   class="btn btn-block btn-info">
                                                        </form>
                                                    </div>
                                                </section>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            }elseif($p == "change-password-process-finish"){
                                $code = $_POST["code"];
                                if($code == ""){
                                    ?>
                                    <div class="callout callout-danger"
                                         style="width:400px;margin:auto;position:relative;">
                                        <h5>Error</h5>
                                        <p>You did not provide an e-mail code. Transaction Cancelled.</p>
                                    </div>
                                    <?php
                                    unset($_SESSION["password_change"]);
                                }else {
                                    if (!isset($_SESSION["password_change"]) || !is_numeric($code)) {
                                        ?>
                                        <div class="callout callout-danger"
                                             style="width:400px;margin:auto;position:relative;">
                                            <h5>Error</h5>
                                            <p>An Error Occurred.</p>
                                        </div>
                                        <?php
                                    } else {
                                        $session_token = $_SESSION["password_change"];
                                        $check_token = mysqli_query($con, "select * from password_change where token='$session_token' and user_id='$user_id' and completed='0'");
                                        if (mysqli_num_rows($check_token) == 0) {
                                            ?>
                                            <div class="callout callout-danger"
                                                 style="width:400px;margin:auto;position:relative;">
                                                <h5>Error</h5>
                                                <p>An Error Occurred.</p>
                                            </div>
                                            <?php
                                            unset($_SESSION["password_change"]);
                                        } else {
                                            $pull_session_data = mysqli_fetch_array($check_token);
                                            if ($pull_session_data[3] != $code) {
                                                ?>
                                                <div class="callout callout-danger"
                                                     style="width:400px;margin:auto;position:relative;">
                                                    <h5>Error</h5>
                                                    <p>E-mail code you provided is not valid. Transaction Cancelled.</p>
                                                </div>
                                                <?php
                                                unset($_SESSION["password_change"]);
                                            }else{
                                                $new_password = $pull_session_data[2];
                                                $update_password = mysqli_query($con,"update Users set password='$new_password' where id='$user_id'");
                                                if($update_password){
                                                    $complete_session = mysqli_query($con,"update password_change set completed='1' where token='$session_token'");
                                                    if($complete_session){
                                                        ?>
                                                        <div class="callout callout-success"
                                                             style="width:400px;margin:auto;position:relative;">
                                                            <h5>Transaction Completed</h5>
                                                            <p>We changed your password. Please login again.</p>
                                                        </div>
                                                        <?php
                                                        unset($_SESSION["password_change"]);
                                                        unset($_SESSION["myturktrade"]);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            echo"</div>";
                        }elseif($s == "mailbox"){
                        ?>


                        <?php
                            echo"</div>";
                        }
        ?>
        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>2020 <a href="https://turktrade.ca">TurkTrade</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- DataTables  & Plugins -->
            <script src="plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
            <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
            <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
            <script src="plugins/jszip/jszip.min.js"></script>
            <script src="plugins/pdfmake/pdfmake.min.js"></script>
            <script src="plugins/pdfmake/vfs_fonts.js"></script>
            <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
            <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
            <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE -->
    <script src="dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
            <script>
                $(function () {
                    $("#example1").DataTable({
                        "responsive": true, "lengthChange": false, "autoWidth": false,
                        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                    });
                });
            </script>
            <!-- SweetAlert2 -->
            <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard3.js"></script>
            <!-- FLOT CHARTS -->
            <script src="plugins/flot/jquery.flot.js"></script>
            <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
            <script src="/plugins/flot/plugins/jquery.flot.resize.js"></script>

    </body>
    </html>
    <?php
}