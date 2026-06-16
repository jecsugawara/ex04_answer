<?php
require_once("db_connect.php");
$cid = $_GET['cid'];
$cname = $_GET['cname'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex0402</title>
</head>
<body>
    <h1>ex0402.php</h1>
    <h2>26jy02xx 電子タロウ</h2>
    <?php
    // カテゴリー一覧を表示する
    try {
        $sql = "SELECT maker_name, goods_id, goods_name, price, stock
                FROM w_goods 
                    INNER JOIN w_maker  ON w_maker.maker_id = w_goods.maker_id
                    INNER JOIN w_category  ON w_category.category_id = w_goods.category_id
                WHERE w_goods.category_id = :cid AND price IS NOT NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cid', $cid);
        $stmt->execute();
        $pdo = null; // データベース接続を閉じる
    } catch (PDOException $e) {
        echo "データベースエラー: " . $e->getMessage();
        exit;
    }
    echo ("<h3>カテゴリー : $cname</h3>");
    echo '<TABLE border="1">';
    echo ("<TR><TH>メーカー</TH><TH>商品名</TH><TH>価格</TH><TH>在庫数</TH></TR>");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $maker = $row['maker_name'];
        $gid = $row['goods_id'];
        $gname = $row['goods_name'];
        $price = $row['price'];
        $stock = $row['stock'];
        echo ("<TR>");
        echo ("<TD>$maker</TD>");
        echo ("<TD><a href=\"ex0501.php?gid=$gid\">$gname</a></TD>");
        echo ("<TD>$price</TD>");
        echo ("<TD>$stock</TD>");
        echo ("</TR>");
    }
    echo '</TABLE>';

    ?>
    <a href="ex0401.php">戻る</a>
</body>
    
</html>