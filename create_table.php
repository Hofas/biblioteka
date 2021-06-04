<?php
require_once "dbase.php";
//require_once "connect.php";
?>

<!DOCTYPE HTML>
<html>

<head>


</head>

<body>
<form action="" method="post">
    table name:
    <input type="text" name="name">
    <input type="submit" value="create">

</form>
<br><br>
<form action="" method="post">
    table to delete:
    <input type="text" name="name_del">
    <input type="submit" value="delete">

</form>
<?php

$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$tmp_name = substr(str_shuffle($string),5,20) ;

if (isset($_POST['name'])) {
    $sql = "CREATE TABLE " . $_POST['name'] . " (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    title VARCHAR(30) NOT NULL,
    author VARCHAR(30) NOT NULL,
    owner varchar(50),
    mail varchar(50),
    label varchar(50)
    )";

//$db->exec($sql);
    $connect = new mysqli($host, $db_user, $db_pass, $db_name);
    $connect->query($sql);
}
if (isset($_POST['name_del'])){
    $sql ="drop table ".$_POST['name_del'];
    $connect = new mysqli($host, $db_user, $db_pass, $db_name);
    $connect->query($sql);

}

?>

</body>

</html>