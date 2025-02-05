<?php

try {
    // PDOを使用して接続
    $pdo = new PDO("mysql:dbname=loslogos", "root","");
    echo 'データベース接続成功！';
} catch (PDOException $e) {
    echo 'データベース接続エラー: ' . $e->getMessage();
}
?>
