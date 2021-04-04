<?php
date_default_timezone_set('America/Toronto');
$now = new DateTime();
$begin = new DateTime('9:30');
$end = new DateTime('16:15');

if ($now >= $begin && $now <= $end) {

    function get_stock($stock_code)
    {
        $con = mysqli_connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME");
        $response = file_get_contents("https://finnhub.io/api/v1/quote?symbol=$stock_code&token=API_KEY1");
        $data = json_decode($response, true);
        if($data['c'] == 0.00){
            $response2 = file_get_contents("https://finnhub.io/api/v1/quote?symbol=$stock_code&token=API_KEY2_FOR_BACKUP");
            $data2 = json_decode($response2, true);
            $current = $data2['c'];
            $day_high = $data2['h'];
            $day_low = $data2['l'];
            $day_open = $data2['o'];
            $previous_close = $data2['pc'];
            $timestamp = date('Y-m-d H:i:s', $data2['t']);
            $date = date("Y-m-d H:i:s");
            $insert = mysqli_query($con, "insert into stock_prices (stock_code,stock_current,stock_high,stock_low,stock_open,previous_close,value_date,pulled_date) values ('$stock_code','$current','$day_high','$day_low','$day_open','$previous_close','$timestamp','$date')");
            if (!$insert) {
                die("ERROR");
            }
        }else {
            $current = $data['c'];
            $day_high = $data['h'];
            $day_low = $data['l'];
            $day_open = $data['o'];
            $previous_close = $data['pc'];
            $timestamp = date('Y-m-d H:i:s', $data['t']);
            $date = date("Y-m-d H:i:s");
            $insert = mysqli_query($con, "insert into stock_prices (stock_code,stock_current,stock_high,stock_low,stock_open,previous_close,value_date,pulled_date) values ('$stock_code','$current','$day_high','$day_low','$day_open','$previous_close','$timestamp','$date')");
            if (!$insert) {
                die("ERROR");
            }
        }
    }

    $con = mysqli_connect("localhost","DATABASE_USERNAME","DATABASE_PASSWORD","DATABASE_NAME");
    $pull_stocks = mysqli_query($con, "select symbol from stocks");
    $count = 0;
    while ($array = mysqli_fetch_array($pull_stocks)) {
        $count++;
        if ($count == 60) {
            $count = 0;
            sleep(60);
        }
        get_stock($array[0]);
    }
}else{
    echo "Not business hours.";
}