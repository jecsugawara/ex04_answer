<?php
require_once("db_connect.php");
$cid = $_GET['cid'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex0402s</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>ex0402s.php</h1>
    <h2>26jy02xx 電子タロウ</h2>
    <?php
    // あるカテゴリーの商品一覧を表示する(メーカー名、商品名、価格、在庫数)
    try {
        $sql = "SELECT maker_name, goods_id, goods_name, price, stock, category_name
                FROM w_goods 
                    INNER JOIN w_maker  ON w_maker.maker_id = w_goods.maker_id
                    INNER JOIN w_category  ON w_category.category_id = w_goods.category_id
                WHERE w_goods.category_id = :cid AND w_goods.price IS NOT NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cid', $cid);
        $stmt->execute();
        $pdo = null; // データベース接続を閉じる
    } catch (PDOException $e) {
        echo "データベースエラー: " . $e->getMessage();
        exit;
    }
    $count = $stmt->rowCount();
    echo $count . "件の商品が見つかりました。<BR>";
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $cname = $results[0]['category_name'];

    echo ("<h3>カテゴリー : $cname</h3>");
    echo '<TABLE>';
    echo ("<TR><TH>No.</TH><TH>メーカー</TH><TH>商品名</TH><TH>価格</TH><TH>在庫数</TH></TR>");
    foreach ($results as $i => $row) {
        $maker = $row['maker_name'];
        $gid   = $row['goods_id'];
        $gname = $row['goods_name'];
        $price = $row['price'];
        $stock = $row['stock'];
        if(empty($stock)){
            $stock = "在庫なし";
        }
        echo "<TR>",
             "<TD>" . ($i + 1) . "</TD>",
             "<TD>$maker</TD>",
             "<TD><a href=\"ex0501.php?gid=$gid\">$gname</a></TD>",
             "<TD>$price</TD>",
             "<TD>$stock</TD>",
             "</TR>\n";
    }
    echo '</TABLE>';
    ?>
    <br>
    <button type="button" onclick="history.back()">戻る</button>
</body>

</html>