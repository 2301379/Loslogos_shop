<?php
// データベース接続情報
$host = 'mysql305.phy.lolipop.lan'; // またはIPアドレスを使用
$db = 'LAA1557214-php2024';
$user = 'LAA1557214';
$pass = 'ここに正しいパスワード';

try {
    // PDOを使用して接続
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    echo 'データベース接続成功！';
} catch (PDOException $e) {
    echo 'データベース接続エラー: ' . $e->getMessage();
}
?>
