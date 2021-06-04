<?php

require_once "connect.php";

try{
    $db = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8",$db_user,$db_pass,
        [PDO::ATTR_EMULATE_PREPARES=>false,
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}

catch (PDOException $error){
    echo "napotkano błąd: ".$error->getMessage();

}