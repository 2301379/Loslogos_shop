<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム画面(ゲスト)</title>
    <link rel="stylesheet" href="./css/cart.css">
</head>

<body>
    <div class="container">
        <div class="top-bar">
            <a href="index.php">
                <span class="site-title">𝓛𝓸𝓼𝓵𝓸𝓰𝓸𝓼</span>
            </a>
        </div>
        <?php
        session_start();
        $total = 0;

        // 商品削除機能
        if (isset($_GET['remove_id'])) {
            $remove_id = $_GET['remove_id'];
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['product_id'] == $remove_id) {
                    unset($_SESSION['cart'][$key]);
                    break;
                }
            }
            $_SESSION['cart'] = array_values($_SESSION['cart']);  // 配列のインデックスを再整理
        }

        // カートが空の場合のメッセージ
        if (empty($_SESSION['cart'])) {
            echo "<p>カートは空です。</p>";
        } else {
            echo "<h1>カートの中身</h1>";
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr><th>商品名</th><th>価格</th><th>数量</th><th>小計</th><th>操作</th></tr>";
            echo "</thead>";
            echo "<tbody>";

            // カート内のアイテムを表示
            foreach ($_SESSION['cart'] as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;

                echo "<tr>";
                echo "<td>{$item['product_name']}</td>";
                echo "<td>{$item['price']}円</td>";
                echo "<td>{$item['quantity']}</td>";
                echo "<td>{$subtotal}円</td>";
                echo "<td><a href='?remove_id={$item['product_id']}'>削除</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

            // 合計金額の表示
            echo "<h2>合計: {$total}円</h2>";
        }
        ?>

        <div class="back-button-container">
            <a href="index.php">
                <button class="back-button">ホームへ戻る</button>
            </a>
            <a href="rezi.php">
                <button class="back-button">レジに進む</button>
            </a>
        </div>




    </div>
</body>

</html>