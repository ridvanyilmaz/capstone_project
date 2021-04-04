<?php
session_start();
if(!isset($_SESSION["myturktrade"])){
    header("location:login.php");
}else{
    header("location:dashboard/index.php");
}
