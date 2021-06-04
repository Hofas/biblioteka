<?php
session_start();

if (!isset($_SESSION['id'])){
    header("Location: index.php");
    exit();
}
require_once "dbase.php";
// $_FILES["label"]["name"] label=nazwa inputa; name=nazwa pliku
if (!empty($_POST['title']))    {
    $title = $_POST['title'];
    $author =$_POST['author'];
    $owner= $_SESSION['id'];

    $error_u = false;
    $extensions = array("jpg","jpeg","bmp");
    $label = "labels/".$_FILES["label"]["name"];
    $file_ext = explode('.',$_FILES["label"]['name']);
    $file_ext = end($file_ext);
    if (strlen($_FILES["label"]["name"])>1) {
        if (!in_array($file_ext, $extensions)) {
            $error_u = true;
            $_SESSION['error_uM'] = "Dozwolony upload jedynie jpg, jpeg oraz bmp";
        }
    }
    if (is_file($label)){
        $error_u = true;
        $_SESSION['error_uM'] = "Okładka o nazwie:".$_FILES['label']['name']." już istnieje, zmień nazwę";
    }

    if ($_FILES["label"]["size"]> 1000000){
        $error_u = true;
        $_SESSION['error_uM'] = "Dozwolony upload jedynie plików do 1 MB";
    }

    if ($error_u == false) {

        move_uploaded_file($_FILES["label"]["tmp_name"], "labels/" . $_FILES["label"]["name"]);
        //gdyby ktoś dodał książkę bez okładki to wstawiam nophoto.jpg
        if (strlen($_FILES["label"]["name"])<1){
            $label = "labels/nophoto.jpg";
        }

        //$id=$_SESSION['id'];
        $InsBooksQuery = $db->prepare("INSERT INTO books VALUES (NULL,:title,:author,:owner,:label )");
        $InsBooksQuery->bindValue(":title", $title, PDO::PARAM_STR);
        $InsBooksQuery->bindValue(":author", $author, PDO::PARAM_STR);
        $InsBooksQuery->bindValue(":owner", $owner, PDO::PARAM_INT);
        $InsBooksQuery->bindValue(":label", $label, PDO::PARAM_STR);


        $InsBooksQuery->execute();

        $_SESSION['addbook'] = "Dodano książkę z sukcesem";
//    header("location: addbooks.php");
    }
}

function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

?>

<!DOCTYPE HTML>
<html lang="pl">

    <head>
    <link rel="stylesheet" href="main.css" type="text/css">

    <meta charset="utf-8"/>
    <title>Add Books</title>

    <script src="jquery-3.4.0.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#labelik')
                        .attr('src', e.target.result);
                     $('#labelik')
                        .css('display', 'inline-block');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


</head>

<body>
<span style="text-align: center"><h2>Okładki najlepiej wziąść z lubimyczytac.pl</h2></span>
<div id="main_add">

    <div id="addForm">
    <form method="post" enctype="multipart/form-data">


        <h1>Tytuł:</h1>

    <input type="text" name="title" placeholder="Tutuł">

        <h1>Autor:</h1>

    <input type="text" name="author" placeholder="Autor">

        <div id="file_add">
    Okładka


       <input type="file" name="label" onchange="readURL(this);" placeholder="okłdka" accept=".jpg, .jpeg, .bmp"   >


    <input type="submit" value="add">
            <br><br>
            <a href="biblioteka.php">Do Twojej listy książek</a>
            <br><br>
<!--sesja wyświetlanie komuniaktu o błędzie walidacji lub suckesie dodania książki-->
    <?php
    if (isset($_SESSION['addbook'])){
        echo $_SESSION['addbook'];
        unset($_SESSION['addbook']);
    }
    if (isset($_SESSION['error_uM'])){
        echo "<strong><span style='color: red;'> ".$_SESSION['error_uM']."</span></strong>";
        unset ($_SESSION['error_uM']);

    }
    ?>

        </div>



    </form>
</div>
    <div id="IMG">
        <img id="labelik" src="#" style="display: none" >
    </div>
    <div style="clear: both"></div>

</div>
</body>
</html>