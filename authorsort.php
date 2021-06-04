<?php
session_start();
$_SESSION['sortby'] = "author";
header("location: browsebooks.php");
