<?php
/*
連線資料庫用的副程式
*/
$host = 'localhost'; //執行DB Server 的主機
$user = 'jc'; //登入DB用的DB 帳號
$pass = '12345'; //登入DB用的DB 密碼
$dbName = 'shopping_cart'; //使用的資料庫名稱
/* $db 即為未來執行SQL指令所使用的物件 */
$db = mysqli_connect($host, $user, $pass, $dbName) or die('Error with MySQL connection'); //跟MyMSQL連線並登入

mysqli_query($db,"SET NAMES utf8"); //設定編碼為 unicode utf8
?>