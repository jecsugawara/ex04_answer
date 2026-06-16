<?php
require_once("config.php");
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    //print('データベース接続成功');   
} catch (PDOException $e) {
    exit('データベース接続失敗。' . $e->getMessage());
}
?>