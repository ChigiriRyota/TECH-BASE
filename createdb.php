<?php
// DB接続設定
    // $dsn = 'mysql:dbname=tb240084db;host=localhost';
    // $user = 'tb-240084';
    // $password = 'HkS92SXE4z';
    $dsn = 'データベース名'
    $user = 'ユーザー名'
    $password = 'パスワード'
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql = "CREATE TABLE IF NOT EXISTS bulletinboard"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT"
    .");";
    $stmt = $pdo->query($sql);
    
    // $sql = 'DROP TABLE bulletinboard';
    // $stmt = $pdo->query($sql);
    
?>