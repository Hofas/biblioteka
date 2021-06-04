<?php
session_start();
require_once "dbase.php";



if (isset($_POST['deleteSelected'])){
    $checkarr = $_POST['checkbox'];

    foreach ($checkarr as $id){

        $LabelToDelete = $db->query("Select label from books WHERE  id=$id");
        $file = $LabelToDelete->fetchColumn();
        if ($file!=="labels/nophoto.jpg") {
            unlink($file);
        }
        $db->query("Delete from books WHERE id=$id");

}
    unset($_POST['deleteSelected']);
}


header('location: index.php');