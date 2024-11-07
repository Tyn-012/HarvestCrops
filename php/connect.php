<?php
    error_reporting (E_ALL ^ E_NOTICE);
    session_start();
    $connect = mysqli_connect("localhost", "root", "") or die("Connection Problem".mysqli_errno($connect));
    $database = mysqli_select_db($connect, "harvestcrops") or die("SQL Problem" . mysqli_error($connect));
?>