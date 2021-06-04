<?php
require_once "dbase.php";

if(isset($_GET['email']) && isset($_GET['token'])){

    $email= $_GET['email'];
    $token =  $_GET['token'];
    $sql = $db->query("Select id From users where
    mail = '$email' and token = '$token' And token <>'' and expiretoken > NOW() 
    ");
    if ($sql->rowCount()>0) {
        echo "<!DOCTYPE HTML> 
        <html>  
        <head>
        <link rel=\"stylesheet\" href=\"main.css\" type=\"text/css\"> 
        
        
        
        </head>
        <body>
        <div class='main'> 
         <h1>Podaj nowe hasło:</h1>
        <div id='resetpass'>
        
            ";

        echo " <form method='post'>
        <input type='password' name='newpass'> <br><br>
        <input type='submit' value='Zresetuj Hasło'>
        </form>
        ";
        echo "<br><br>";
        if (isset($_POST['newpass']) && strlen($_POST['newpass']) >5 ){
            $newPass = $_POST['newpass'];
            $newhaszpass = password_hash($newPass,PASSWORD_DEFAULT);

         $db->query("UPDATE users SET pass='$newhaszpass', token = '' WHERE mail='$email' AND token ='$token' AND token<>''");
            header('Location: index.php');
            exit();
        }
        else {echo "<span style='color: red'>Hasło musi mieć co najmniej 5 znaków</span>";}

    echo "</div>
</div>

        </body>
        
        
        
        </html>";


    }
    else {
        header('Location: index.php');
        exit();

    }


}
else
{header('Location: index.php');
exit();
}

?>