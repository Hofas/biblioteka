<?php
session_start();
if (isset($_SESSION['id'])){
	header('Location: biblioteka.php');
	exit();
}

    if((isset($_POST['login'])) && (strlen($_POST['login'])<1) || (isset($_POST['pass'])) && (strlen($_POST['pass'])<1)){
        $_SESSION['e_login']="podaj login i pass";
    }
    else
    {
        if (isset($_POST['login'])) {
            require_once "connect.php";
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $login = htmlentities($login,ENT_QUOTES,"UTF-8");
            mysqli_report(MYSQLI_REPORT_STRICT); //Throw mysqli_sql_exception for errors instead of warnings
            try {
            //    global $connect;
                $connect = new mysqli($host, $db_user, $db_pass, $db_name);

                if ($connect->connect_errno!=0) {
                    throw new Exception($connect->error);
                } else {
                    // udane połączeie z bazą
                    $login = mysqli_real_escape_string($connect,$login);
                    mysqli_set_charset($connect,"utf8");
                  if ($LoginQuery=$connect->query("SELECT * FROM users WHERE login='$login'")){

                      $_SESSION['e_login']='Nie ma tekiego usera u nas w bazie';

                    if ($LoginQuery->num_rows>0){

                        $row=$LoginQuery->fetch_assoc();
                         if (password_verify($pass,$row['pass'])){
                            $_SESSION['login'] = $row['login'];
                            $_SESSION['imie']= $row['imie'];
                            $_SESSION['nazwisko'] = $row['nazwisko'];
                            $_SESSION['mail'] = $row['mail'];
                            $_SESSION['id'] = $row['id'];
                            //$_SESSION['user'] = $row['login'];

                             if ($connect->query('SELECT 1 FROM '.$login)){

                                 $sql ='drop table '.$login;

                                 $connect->query($sql);
                                 create_table($login);
                                 fillUpTable($login);
                                 } // jest baza
                             else{
                                 create_table($login);
                                 fillUpTable($login);
                                        } // nie ma bazy

                             header("location: biblioteka.php");

                             $connect->close();
                                exit();
                             }
                                 else {

                                $_SESSION['e_login']='Bad Password';
                            }
                          }


                    }
                    else {


                        throw new Exception($connect->error);
                    }


                    $connect->close();
                   // header("location: biblioteka.php");
                }
            } catch (Exception $e) {
               // echo $e;
                echo "<span style='color: red'> Chwilowe problemy z bazą przepraszamy za usterki </span> <br/>";
              //  exit();
            };
        }
    }
	
function create_table($name){
    $host="localhost";
    $db_user="root";
    $db_pass="";
    $db_name="biblioteka";

    $sql = "CREATE TABLE ".$name." (
                                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                title VARCHAR(30) NOT NULL,
                                author VARCHAR(30) NOT NULL,
                                owner varchar(50),
                                mail varchar(50),
                                label varchar(50)
                                )";


    $connect = new mysqli($host, $db_user, $db_pass, $db_name);

    $connect->query($sql);
    }
function fillUpTable($name){

        $host="localhost";
        $db_user="root";
        $db_pass="";
        $db_name="biblioteka";


        try{
        $db = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8",$db_user,$db_pass,
            [PDO::ATTR_EMULATE_PREPARES=>false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    catch (PDOException $error){
        echo "napotkano błąd: ".$error->getMessage();

    }

    $owner = $_SESSION['id'];
    $queryUsers = $db->query("Select * FROM users WHERE id !=$owner");

    $users = $queryUsers->fetchAll();
    foreach ($users as $user) {
        $id = $user['id'];
        $imie = $user['imie'];
        $nazwisko = $user['nazwisko'];
        $mail = $user['mail'];
        $queryBooks = $db->query("Select * FROM books WHERE owner = $id");

        $books = $queryBooks->fetchAll();
        foreach ($books as $book) {

//            echo "<tr><td>" . $book['title'] . "</td><td>" . $book['author'] . "</td><td>" . $imie . " " . $nazwisko . "</td><td><img src='{$book['label']}' alt='' height='100'></td></tr>";

//                            $login = $_SESSION['login'];
                            $own = $imie." ".$nazwisko;
                            $booktitle = $book['title'];
                            $bookauthor = $book['author'];
                            $booklabel= $book['label'];


                            $sql = "INSERT INTO ".$name." (id,title,author,owner,mail,label)
                            VALUES (NULL ,'$booktitle','$bookauthor','$own','$mail','$booklabel')";

                            $db->exec($sql);

        }


    }


};


?>

<!DOCTYPE HTML>
<html lang="pl-PL">

<head>
	<meta charset="utf-8" />
	<title> Bibliotega Selgrosu </title>
    <link rel="stylesheet" href="main.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Charm|Open+Sans" rel="stylesheet">
</head>
<body>
<div class="main">
<div class="logo">
    Biblioteka Pracowników Selgrosu
</div>
     <div class="logform">




<form method="post">

Login: <input type="text" name="login" placeholder="Login">

Pass: <input type="password" name="pass" placeholder="Hasło">
    



    <?php
    if(isset($_SESSION['e_login'])){
        echo "<BR/><span style='color:red'>".$_SESSION['e_login']."</span>";
        unset($_SESSION['e_login']);
    }


    ?>
    <br/><BR/>
<input type="submit" value="Zaloguje Się">
</br></br>

</form>

<a href="rejestracja.php"> Rejestracja nowego użytkownika </a>

         <form action="forgetpass.php">
             <input id="resetbut" type="submit" value="Reset Pass">
         </form>

    </div>

    </div>
</body>
</html>