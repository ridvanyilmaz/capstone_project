<?php
session_start();
if(!isset($_SESSION["myturktrade"])){
    header("location:../login.php");
}else {
    require_once "../../config.php";
    header('Content-type: image/jpeg;');
    $user_id = $_SESSION["myturktrade"];
    $get_image = mysqli_query($con,"select * from profile_picture where user_id='$user_id' order by id DESC");
    if(mysqli_num_rows($get_image) == 0){
        $a = file_get_contents("dist/img/avatar5.png");
        echo $a;
    }else {
        $array = mysqli_fetch_array($get_image);
        $a = file_get_contents("../../pictures/$array[2]");
        echo $a;
    }

}