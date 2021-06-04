<?php
session_start();
if (!isset($_SESSION['udanarejestracja'])){

    header('location:index.php');
    exit();
}
unset($_SESSION['udanarejestracja']);



?>

<html>
<head>
    <link rel="stylesheet" href="main.css" type="text/css">
</head>
<body>
<?php
echo "Witam ciebie ".$_SESSION['imie']."<br/>";
?>
Gratuluję udanej rejestracji w naszej Bibliotece
<br/>
<a href="index.php">Możesz się zalogować </a>
<?php
session_unset();

?>

</body>
</html>
