<?php
function get_live_stock_value($stock_code)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://apidojo-yahoo-finance-v1.p.rapidapi.com/market/get-spark?symbols=$stock_code&interval=1m&range=1d",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: apidojo-yahoo-finance-v1.p.rapidapi.com",
            "x-rapidapi-key: YAHOO_RAPIDAPI_KEY"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response, true);
        date_default_timezone_set('America/Toronto');
        $timestamp = date("Y-m-d H:i:s",end($data["$stock_code"]["timestamp"]));
        $close_data = end($data["$stock_code"]["close"]);
        return array($timestamp,$close_data);
    }
}
function find_stock_id($stock_code){
    $con = mysqli_connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME");
    $pull_stock = mysqli_query($con,"select id from stocks where symbol='$stock_code'");
    $stock_id_pull = mysqli_fetch_array($pull_stock);
    return $stock_id_pull[0];
}
function find_stock_code($stock_id){
    $con = mysqli_connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME");
    $pull_stock = mysqli_query($con,"select symbol from stocks where id='$stock_id'");
    $stock_id_pull = mysqli_fetch_array($pull_stock);
    return $stock_id_pull[0];
}
function find_user_id_by_e_mail($e_mail){
    $con = mysqli_connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME");
    $pull_users = mysqli_query($con,"select * from Users where email='$e_mail'");
    if(mysqli_num_rows($pull_users) == 0){
        return array("E-mail was not found.");
    }else {
        $users_array = mysqli_fetch_array($pull_users);
        return array("OK",$users_array[0]);
    }
}
function stripe_charge_card($token,$amount,$currency){
    $curl = curl_init();
    $amount_cents = $amount*100;
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.stripe.com/v1/charges?amount=$amount_cents&currency=$currency&source=$token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer STRIPE_SECRET_API_KEY","Content-Type:application/x-www-form-urlencoded"

        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response,true);
        $amount_captured = $data["amount_captured"];
        $captured = $data["captured"];
        $status = $data["status"];
        $id = $data["id"];
        if($amount_captured == $amount_cents && $captured == true && $status == "succeeded"){
            return array("OK",$id);
        }else{
            $error = $data["error"]["code"];
            return array($error,"Not Provided");
        }
    }
}
function debit_account($user_id,$account_number,$amount,$description){
    $con = mysqli_connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME");
    date_default_timezone_set('America/Toronto');
    $account_query = mysqli_query($con,"select user_id,available_balance,overdraft_limit,balance from accounts where account_number='$account_number'");
    $check_account_ownership = mysqli_fetch_array($account_query);
    if($check_account_ownership[0] != $user_id || mysqli_num_rows($account_query) == 0){
        return "Account ownership conflict.";
    }else{
        if($check_account_ownership[1] < $amount && $check_account_ownership[2] < $amount){
            return array("Account does not have sufficient funds.");
        }elseif($check_account_ownership[1] < $amount && $check_account_ownership[2] >= $amount){
            $new_balance = $check_account_ownership[3] - $amount;
            $new_available_balance = $check_account_ownership[1] - $amount;
            $new_od_limit = $check_account_ownership[2] - $amount;
            $update_balances = mysqli_query($con,"update accounts set balance='$new_balance',available_balance='$new_available_balance',overdraft_limit='$new_od_limit' where account_number='$account_number'");
            if($update_balances){
                $transaction_id = md5(uniqid().date("Y-m-d-H-i-s").rand(100000,999999));
                $date = date("Y-m-d H:i:s");
                $create_transaction_log = mysqli_query($con,"insert into account_transaction_history (account_number,transaction_id,date,description,before_balance,after_balance,amount) values ('$account_number','$transaction_id','$date','$description','$check_account_ownership[3]','$new_balance','-$amount')");
                if($create_transaction_log){
                    return array("OK",$transaction_id);
                }
            }
        }elseif($check_account_ownership[1] >= $amount){
            $new_balance = $check_account_ownership[3] - $amount;
            $new_available_balance = $check_account_ownership[1] - $amount;
            $update_balances = mysqli_query($con,"update accounts set balance='$new_balance',available_balance='$new_available_balance' where account_number='$account_number'");
            if($update_balances){
                $transaction_id = md5(uniqid().date("Y-m-d-H-i-s").rand(100000,999999));
                $date = date("Y-m-d H:i:s");
                $create_transaction_log = mysqli_query($con,"insert into account_transaction_history (account_number,transaction_id,date,description,before_balance,after_balance,amount) values ('$account_number','$transaction_id','$date','$description','$check_account_ownership[3]','$new_balance','-$amount')");
                if($create_transaction_log){
                    return array("OK",$transaction_id);
                }
            }
        }
    }
}
function credit_account($user_id,$account_number,$amount,$description){
    $con = mysqli_connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME");
    date_default_timezone_set('America/Toronto');
    $account_query = mysqli_query($con,"select user_id,available_balance,overdraft_limit,balance,defined_overdraft_limit from accounts where account_number='$account_number'");
    $check_account_ownership = mysqli_fetch_array($account_query);
    if($check_account_ownership[0] != $user_id || mysqli_num_rows($account_query) == 0){
        return "Account ownership conflict.";
    }else{
        $new_balance = $check_account_ownership[3]+$amount;
        $new_available_balance = $check_account_ownership[1]+$amount;
        $query = "update accounts set balance='$new_balance',available_balance='$new_available_balance'";
        if($check_account_ownership[4] != 0.00) {
            if ($check_account_ownership[2] < $check_account_ownership[4]) {
                if ($check_account_ownership[2] + $amount >= $check_account_ownership[4]) {
                    $new_overdraft_limit = $check_account_ownership[4];
                } elseif ($check_account_ownership[2] + $amount < $check_account_ownership[4]) {
                    $new_overdraft_limit = $check_account_ownership[2] + $amount;
                }
                $query .= ",overdraft_limit='$new_overdraft_limit'";
            }
        }
        $query .= " where account_number='$account_number' and user_id='$user_id'";
        $add_balance = mysqli_query($con,$query);
        if($add_balance){
            $transaction_id = md5(uniqid().date("Y-m-d-H-i-s").rand(100000,999999));
            $date = date("Y-m-d H:i:s");
            $create_transaction_log = mysqli_query($con,"insert into account_transaction_history (account_number,transaction_id,date,description,before_balance,after_balance,amount) values ('$account_number','$transaction_id','$date','$description','$check_account_ownership[3]','$new_balance','$amount')");
            if($create_transaction_log){
                return array("OK",$transaction_id);
            }
        }
    }
}
function find_account_information($user_id,$account_number,$currency){
    $con = mysqli_connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME");
    $account_query = mysqli_query($con,"select * from accounts where account_number='$account_number' and currency='$currency' and user_id!='$user_id'");
    if(mysqli_num_rows($account_query) == 0){
        return array("Account was not found.");
    }else {
        $account_array = mysqli_fetch_array($account_query);
        $user_id = $account_array[1];
        $user_info_query = mysqli_fetch_array(mysqli_query($con,"select first_name,last_name from Users where id='$user_id'"));
        $user_full_name = $user_info_query[0]." ".$user_info_query[1];
        return array("OK",$user_full_name);
    }

}
function find_user_id_by_account_number($account_number){
    $con = mysqli_connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME");
    $account_query = mysqli_query($con,"select * from accounts where account_number='$account_number'");
    if(mysqli_num_rows($account_query) == 0){
        return array("Account was not found.");
    }else {
        $account_query_array = mysqli_fetch_array($account_query);
        return array("OK",$account_query_array[1]);
    }

}
function send_e_mail($recipient,$subject,$message){
    require_once "../PHPMailer/MailSender.php";
    $mail_class = new MailSender;
    $mail_class->setrecipient($recipient);
    $mail_class->setsubject($subject);
    $mail_class->setMessage($message);
    $mail_class->sendmail();
    return $mail_class->getresult();
}
function send_e_mail_from_dashboard($recipient,$subject,$message){
    require_once "../../PHPMailer/MailSender.php";
    $mail_class = new MailSender;
    $mail_class->setrecipient($recipient);
    $mail_class->setsubject($subject);
    $mail_class->setMessage($message);
    $mail_class->sendmail();
    return $mail_class->getresult();
}
