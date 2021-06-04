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
                        <tr><th><a href="titlesort.php">Tytuł</a></th><th><a href="authorsort.php">Autor</a></th><th><a
                                        href="ownersort.php">Owner</a></th><th>okładka</th>  </tr>
                    </thead>

                    <tbody>

                    <?php

                    $queryBooks = $db->query("Select * FROM ".$_SESSION['login']);

                    if (isset($_SESSION['sortby'])) {
                        if ($_SESSION['sortby'] == 'author') {
                            $queryBooks = $db->query("Select * FROM ".$_SESSION['login']." ORDER BY author");
                        }
                        if ($_SESSION['sortby'] == 'title') {
                            $queryBooks = $db->query("Select * FROM ".$_SESSION['login']." ORDER BY title");
                        }
                        if ($_SESSION['sortby'] == 'owner') {
                            $queryBooks = $db->query("Select * FROM ".$_SESSION['login']." ORDER BY owner");
                        }
                    }



                    $books =  $queryBooks->fetchAll();
                    foreach ($books as $book){

                            echo "<tr><td>".$book['title']."</td><td>".$book['author']."</td><td>".$book['owner']."</td><td><a target='_blank' href='http://lubimyczytac.pl/szukaj/ksiazki?phrase=".$book['title']."&main_search=1'><img src='{$book['label']}' alt='' height='100'></a></td></tr>";

                        }




                    ?>

                    </tbody>

                    </table>

                    </div>

           </div>
</div>



</body>

</html>
