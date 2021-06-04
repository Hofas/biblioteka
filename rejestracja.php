<?php
session_start();
if(isset($_POST['login'])){
    $validate = true;
    $login= $_POST['login'];

    //validacja dlugoci login 3 do 15 znakow
    if ((strlen($login)<3)||strlen($login)>15){
        $validate = false;
        $_SESSION['e_login'] = "Login tylko między 3 a 15 znaków";
    }

    //validacja skladni loginu: tylko A-Za-z0-9
    if (!ctype_alnum($login)){
        $validate = false;
        $_SESSION['e_login'] = "Login może zawierać jedynie litery i cyfry";
    }

    //validacja imie tylko [A-Za-z]
    $imie = $_POST['imie'];
    $_SESSION['imie'] = $imie;
    if (!preg_match("/^[a-zęóąśłżźćĘÓĄŚŁŻŹĆ]+$/i",$imie)){
        $validate = false;
        $_SESSION['e_imie'] = "Imie może się składać jedynie z dużych i małych liter bez spacji";

    }
    //validacja nazwiska tylko [A-Za-z]
    $nazwisko = $_POST['nazwisko'];
    if (!preg_match("/^[a-zęóąśłżźćĘÓĄŚŁŻŹĆ]+$/i",$nazwisko)){
        $validate = false;
        $_SESSION['e_nazwisko'] = "Nazwisko może się składać jedynie z dużych i małych liter bez spacji";

    }


    //validacja maila
    $mail = $_POST['mail'];
    if (filter_var($mail,FILTER_VALIDATE_EMAIL)== false){
        $validate = false;
        $_SESSION['e_mail'] = "wprowadz prawidłowy E-Mail:".$mail." jest zły";

    }
    //validacja hasła
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    if (strlen($pass1)<5){
        $validate = false;
        $_SESSION['e_pass'] = "hasło jes za króktkie min 5 znakow";

    }


    if(!($pass1==$pass2)){
        $validate = false;
        $_SESSION['e_pass'] = "hasła nie są identyczne";

    }

    mysqli_report(MYSQLI_REPORT_STRICT);
    require_once "connect.php";

    try {

        $connect = new mysqli($host,$db_user,$db_pass,$db_name);

        if($connect->connect_errno!=0){

            throw new Exception($connect->errno); //or mysqli_connect_error() ten sam efekt
        }
        else {   //jest połączenie z bazą

            //validacja istnienia takiego maila
            $MailQuery = $connect->query("SELECT id FROM users where mail='$mail'");
            if(!$MailQuery){
                throw new Exception($connect->connect_errno);
            }
            else {
                if ($MailQuery->num_rows>0){
                    $validate=false;
                    $_SESSION['e_mail']="Już taki adres email figuruje u nas w bazie";
                }
            }
            //Validacja istnienia takiego loginu
            $LoginQuery = $connect->query("SElECT id FROM users where login='$login'");
            if(!$LoginQuery){
                throw new Exception($connect->errno);
                            }
                else {
                    if ($LoginQuery->num_rows>0){
                        $validate=false;
                        $_SESSION['e_login']="Już taki Login figuruje u nas w bazie";

                    }
                }

            if ($validate) {  //dodanie usera do bazy
                mysqli_set_charset($connect, "utf8");
                $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
                $InsertNewUser = $connect->query("INSERT INTO users VALUES(NULL,'$login','$imie','$nazwisko','$mail','$pass_hash')");
                if (!$InsertNewUser) {
                    throw new Exception($connect->errno);

                } else {

                    $_SESSION['udanarejestracja'] = true;
                    header('Location: witamy.php');
                }
            }
            $connect->close();

        }

    }
    catch (Exception $e){echo $e;exit();}


}



?>

<html>
<head>
    <title> Rejestracja Nowego Usera   </title>
    <link rel="stylesheet" href="main.css" type="text/css">
</head>
<body>
<div class="main">
    <h1>Rejestracja Nowego Użytkownika</h1>
<div class="reg">
    <form method="post">


    Login:
    <br/>
    <input type="text" name="login" <?php if (isset($login)){ echo "value='$login'";}?>>
    <br/>
    <?php
    if (isset($_SESSION['e_login'])){
        echo "<span style = color:red>".$_SESSION['e_login']."</span>";
        unset($_SESSION['e_login']);
    }

    ?>
    <br/>
    Imię:
    <br/>
    <input type="text" name="imie" <?php if (isset($imie)){ echo "value='$imie'";}?>>
    <br/>
    <?php
    if (isset($_SESSION['e_imie'])){
        echo "<span style = color:red>".$_SESSION['e_imie']."</span>";
        unset($_SESSION['e_imie']);
    }


    ?>

    <br/>
    Nazwisko:
    <br/>
    <input type="text" name="nazwisko" <?php if (isset($nazwisko)){ echo "value='$nazwisko'";}?>>
    <br/>
    <?php
    if (isset($_SESSION['e_nazwisko'])){
        echo "<span style = color:red>".$_SESSION['e_nazwisko']."</span>";
        unset($_SESSION['e_nazwisko']);
    }


    ?>

    <br/>
    Mail:
    <br/>
    <input type="text" name="mail" <?php if (isset($mail)){ echo "value='$mail'";}?>>
    <br/>
    <?php
    if (isset($_SESSION['e_mail'])){
        echo "<span style = color:red>".$_SESSION['e_mail']."</span>";
        unset($_SESSION['e_mail']);
    }


    ?>
    <br/>
    Hasło:
    <br/>
    <input type="password" name="pass1">
    <br/><br/>
    Powtórz Hasło:
    <br/>
    <input type="password" name="pass2">
    <br/>
    <?php
    if (isset($_SESSION['e_pass'])){
        echo "<span style = color:red>".$_SESSION['e_pass']."</span>";
        unset($_SESSION['e_pass']);
    }


    ?>


    <br/>
<input type="submit" value="Utwórz nowego użytkonika">

</form>
</div>
</div>
</body>



</html>
