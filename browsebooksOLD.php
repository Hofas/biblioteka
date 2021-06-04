<?php
session_start();
require_once "dbase.php";
?>

<!DOCTYPE HTML>

<html lang="pl">

<head>

    <meta charset="utf-8">
    <link rel="stylesheet" href="main.css" type="text/css">

</head>


<body>


<div class="main">
            <div class="logo">

            Książki dostępne w naszej Bibliotece

            </div>

            <div id="browse_content">

                    <div id="browse_menue">

                        <form action="biblioteka.php">
                            <input class="menue" type="submit" value="Powrót">
                        </form>

                    </div>

                    <div id="browse_table">

                    <table class="blueTable">

                    <thead>
                        <tr><th>Tytuł</th><th>Autor</th><th>Owner</th><th>okładka</th>  </tr>
                    </thead>

                    <tbody>

                    <?php

                    $owner = $_SESSION['id'];
                    $queryUsers = $db->query("Select * FROM users WHERE id !=$owner" );

                    $users =  $queryUsers->fetchAll();
                    foreach ($users as $user){
                        $id = $user['id'];
                        $imie = $user['imie'];
                        $nazwisko = $user['nazwisko'];
                        $mail= $user['mail'];
                        $queryBooks = $db->query("Select * FROM books WHERE owner = $id");

                        $books = $queryBooks->fetchAll();
                        foreach ($books as $book){

                            echo "<tr><td>".$book['title']."</td><td>".$book['author']."</td><td>".$imie." ".$nazwisko."</td><td><img src='{$book['label']}' alt='' height='100'></td></tr>";

//                            $login = $_SESSION['login'];
//                            $own = $imie." ".$nazwisko;
//                            $booktitle = $book['title'];
//                            $bookauthor = $book['author'];
//                            $booklabel= $book['label'];
//
//
//                            $sql = "INSERT INTO ".$login." (id,title,author,owner,mail,label)
//                            VALUES (NULL ,'$booktitle','$bookauthor','$own','$mail','$booklabel')";
//
//                            $db->exec($sql);

                        }


                    }

                    ?>

                    </tbody>

                    </table>

                    </div>

           </div>
</div>



</body>

</html>
