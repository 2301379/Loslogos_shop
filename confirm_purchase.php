<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loslogos</title>
    <link rel="stylesheet" href="./css/syousai.css">
</head>

<body>
    <div class="container">
        <div class="top-bar">
            <a href="index.html">
                <span class="site-title">𝓛𝓸𝓼𝓵𝓸𝓰𝓸𝓼</span>
            </a>
            <a href="cart_view.php">
                <button class="cart-btn">🛒</button>
            </a>
        </div>
        <?php
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 購入者情報を受け取る
            $customer_name = $_POST['name'] ?? '';
            $postal_code = $_POST['postal_code'] ?? '';
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';

            // バリデーションチェック
            if (empty($customer_name) || empty($postal_code) || empty($address) || empty($phone) || empty($email)) {
                echo "すべてのフィールドを入力してください。";
                exit;
            }

            // データベース接続
            $host = 'mysql312.phy.lolipop.lan';  // データベースホスト名
            $dbname = 'LAA1557214-loslogos'; // データベース名
            $user = 'LAA1557214';       // ユーザー名
            $password = 'kurato331';       // パスワード

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // 注文データを`orders`テーブルに登録
                $stmt = $pdo->prepare("INSERT INTO orders (customer_name, postal_code, address, phone, email, total_price) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$customer_name, $postal_code, $address, $phone, $email, $_SESSION['cart_total']]);

                // 注文IDを取得
                $order_id = $pdo->lastInsertId();

                // カート内の商品データを`order_items`テーブルに登録
                foreach ($_SESSION['cart'] as $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$order_id, $item['product_name'], $item['product_id'], $item['quantity'], $item['price'], $subtotal]);
                }

                // カートをクリア
                unset($_SESSION['cart']);
                unset($_SESSION['cart_total']);

                echo "購入が完了しました！";
                echo "<a href='index.php'>ホームに戻る</a>";
            } catch (PDOException $e) {
                echo "エラー: " . $e->getMessage();
            }
        }
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        }
        $_SESSION['cart_total'] = $total;  // 合計金額をセッションに保存

        ?>


    </div>

    <script src="./js/script.js"></script>
</body>

</html>