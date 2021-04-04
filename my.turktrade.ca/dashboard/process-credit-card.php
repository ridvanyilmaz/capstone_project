<?php
require_once "../../func/functions.php";
require_once "../../config.php";

$session_token = $_POST["session-token"];
$card_token = $_POST["token"];
if($session_token == "" || $card_token == ""){
    echo "Invalid Session";
}else {
    $pull_session_data = mysqli_query($con, "select * from fund_deposit_session where token='$session_token'");
    $session_array = mysqli_fetch_array($pull_session_data);
    if ($session_array[5] == 1 || $session_array[5] == "") {
        echo "Invalid Session";
    } else {
        $use_session = mysqli_query($con, "update fund_deposit_session set completed='1' where token='$session_token'");
        if ($use_session) {
            $pull_account_info = mysqli_query($con,"select * from accounts where user_id='$session_array[6]' and account_number='$session_array[2]'");
            $rows = mysqli_num_rows($pull_account_info);
            if($rows == 0 || $rows == ""){
                echo "ERROR";
            }else {
                $account_array = mysqli_fetch_array($pull_account_info);
                $result = stripe_charge_card($card_token, $session_array[3], $account_array[3]);
                if ($result[0] == "OK") {
                    date_default_timezone_set('America/Toronto');
                    $date = date("Y-m-d H:i:s");
                    $create_payment_id = mysqli_query($con,"insert into fund_deposit_session_payment_id (funds_session_token,stripe_id,date) values ('$session_token','$result[1]','$date')");
                    if($create_payment_id) {
                        $description = "Deposit funds with credit card";
                        $add_balance = credit_account($session_array[6], $session_array[2], $session_array[3], $description);
                        if ($add_balance[0] == "OK") {
                            echo "Payment was successful. Funds are deposited to your account.";
                        }
                    }
                } else {
                    echo $result[0];
                }
            }
        }
    }
}