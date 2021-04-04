<?php
session_start();
unset($_SESSION["myturktrade"]);
session_destroy();
header("location:../login.php");