<?php
session_start();
if (!isset($_SESSION['imie'])){
    header('location: index.php');
    exit();
}

    require_once "dbase.php";

?>


<!DOCTYPE HTML>

<html lang="pl">

<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="main.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="main">
    <div class="logo">
<?php
echo "Witamy ".$_SESSION['imie']." w naszej Bibliotece ";
echo "<br/><BR/>"

?> <!--  Wyświetlanie powitania-->
    </div>
    <div id="menueB">

            <form action="addbooks.php">
                <input class="menue" type="submit" value="Dodaj Książkę">
            </form>

<!--        <div id="dummy">-->
<!--            <input  class="menue" type="submit" value="dummy">-->
<!--        </div>-->

        <form action="browsebooks.php">
            <input class="menue" type="submit" value="Przeglądaj dostępne książki">
        </form>

            <form action="logout.php">
                <input class="menue" type="submit" value="Wyloguj">
            </form>
    </div>

    <div id="content">

        <form method="post" action="deleteselected.php">

            <table class="blueTable">
                <thead>
                <tr><th></th><th><a href="sorttitle.php">Tytuł</a></th> <th><a href="sortauthor.php">Autor</a></th><th>Okładka</th></tr>
                </thead>
                <tbody>
                <?php
                $owner =$_SESSION['id'];

                $MyBooksQuery = $db->query("SELECT * FROM books WHERE owner=$owner" );

                if (isset($_SESSION['sortby'])) {
                    if ($_SESSION['sortby'] == 'title') {
                        $MyBooksQuery = $db->query("SELECT * FROM books WHERE owner=$owner ORDER BY title");
                    }
                    if ($_SESSION['sortby'] == 'author') {
                        $MyBooksQuery = $db->query("SELECT * FROM books WHERE owner=$owner ORDER BY author");
                    }
                }
                $books = $MyBooksQuery->fetchAll();
                foreach ($books as $book){
                    echo "<tr> <td><input type='checkbox' name='checkbox[]' value='{$book['id']}' ></td><td> {$book['title']} </td> <td>{$book['author']}</td><td style='text-align: center;height: 100px'><img src='{$book['label']}' alt='' height='100'></td></tr>";
                }
                ?>



                </tbody>
            </table>

            <input id="deleteselected" class="menue" type="submit" name="deleteSelected" value="Usuń wybrane">

        </form> <!--Tabela -->

    </div>
    <div style="clear: both"></div>
</div>
</body>
</html>


