<?php
    //PDO的sql連線指令
    $dsn="mysql:host=localhost;dbname=expstore;charset=utf8";
    $user="sales";
    $db_password="";
    $link=new PDO($dsn,$user,$db_password);
    date_default_timezone_set("Asia/Taipei");
?>