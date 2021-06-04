<?php
session_start();
$_SESSION['sortby'] = "owner";
header("location: browsebooks.php");
