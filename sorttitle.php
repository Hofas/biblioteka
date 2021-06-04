<?php
session_start();
$_SESSION['sortby']="title";
header("location: biblioteka.php");
