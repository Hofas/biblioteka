<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8"/>
<title>Reset Pass</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="main">
    <h1>Reset Hasła</h1>
<div id="resetpass">


    <form action="" method="post">
        Podaj Maila <br><br>
        <input type="email" name="mail">
        <input type="submit" value="Reset Pass">

    </form>
<?php
use PHPMailer\PHPMailer\PHPMailer;


if (isset($_POST['mail']) && strlen($_POST['mail'])<1){
    header('location: index.php');
//    echo "sss";
} elseif (isset($_POST['mail']) && strlen($_POST['mail'])>1) {
    require_once "dbase.php";
    $email = $_POST['mail'];
    $querry = $db->query("SELECT mail FROM users where mail='" . $email . "'");
    if ($querry->rowCount()>0) {
        $token ="abcdefghijklmnoprstuwxyz1234567890";
        $token = str_shuffle($token);
        $token = substr($token,5,20);
        echo "mail wysłany...";
        $db->query("UPDATE users SET token='$token',expiretoken=Date_Add(NOW(),INTERVAL 10 minute) where mail='$email'");
	
	    $subject = "Reset Hasła dla Biblioteki";

	    $msg = "

        <html>
                <head>
                  <title>Birthday Reminders for August</title>
                </head>
                <body>
                  <p>Witam</p>
                    W celu resetu hasła kliknij w link:<br> 
                         <a href='http://spzw7-101005/biblioteka/resetpass.php?email=$email&token=$token'>http://spzw7-101005/biblioteka/resetpass.php?email=$email&token=$token</a><br><br>             
                
                          Pozdrowienia ze świata książek<br>
                          Hofas
                           
                </body>
        </html>
    
         
         ";

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=UTF-8';

        $headers[] = 'From: Biblioteka <biblioteka@selgros.pl>';



        mail($email, $subject, $msg, implode("\r\n", $headers));



         

    } else {

        echo "mail nie odnaleziony";

    }
}


?>

</div>


</div>



</body>



</html>