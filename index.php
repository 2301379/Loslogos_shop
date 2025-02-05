<?php
// データベース接続情報
$host = 'mysql313.phy.lolipop.lan';  // ホスト名
$dbname = 'loslogosshop'; // データベース名
$user = 'LAA1557214';       // ユーザー名
$password = 'Pass0331';       // パスワード（ローカルの場合、空白が一般的）

try {
    // データベース接続
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 商品データを取得
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム画面(ゲスト)</title>
    <link rel="stylesheet" href="./css/ghome.css">
</head>

/
<body>
    <div class="container">
        <div class="top-bar">
            <a href="index.php">
                <span class="site-title">𝓛𝓸𝓼𝓵𝓸𝓰𝓸𝓼</span>
            </a>
            <a href="cart_view.php">
                <button class="cart-btn">🛒</button>
            </a>
        </div>

        <!-- 商品リストを表示 -->
        <div class="content">
            <div class="product-container">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="<?= htmlspecialchars($product['detail_page']) ?>">
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        </a>
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="price">¥<?= number_format($product['price']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>
