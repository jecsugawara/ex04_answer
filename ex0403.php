<?php
require_once("db_connect.php");
$gname = $_POST['gname'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex0403</title>
</head>

<body>
    <h1>ex0403.php</h1>
    <h2>26jy02xx 電子タロウ</h2>
    <?php
    try {
        $sql = "SELECT maker_name, category_name, goods_id, goods_name, price, stock
                FROM w_goods 
                    INNER JOIN w_maker  ON w_maker.maker_id = w_goods.maker_id
                    INNER JOIN w_category  ON w_category.category_id = w_goods.category_id
                WHERE w_goods.goods_name LIKE :gname AND w_goods.price IS NOT NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':gname', "%$gname%");
        $stmt->execute();
        $pdo = null; // データベース接続を閉じる
    } catch (PDOException $e) {
        echo "データベースエラー: " . $e->getMessage();
        exit;
    }

    echo "<h3>検索商品名 : $gname</h3>";
    $count = $stmt->rowCount();
    if ($count > 0) {
        echo '<TABLE border="1">';
        echo "<TR><TH>メーカー名</TH><TH>カテゴリー名</TH><TH>商品名</TH><TH>単価</TH><TH>在庫数</TH></TR>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $maker = $row['maker_name'];
            $cname = $row['category_name'];
            $gid = $row['goods_id'];
            $gname = $row['goods_name'];
            $price = $row['price'];
            $stock = $row['stock'];
            echo "<TR>",
            "<TD>$maker</TD>",
            "<TD>$cname</TD>",
            "<TD><a href=\"ex0501.php?gid=$gid\">$gname</a></TD>",
            "<TD>$price</TD>",
            "<TD>$stock</TD>",
            "</TR>";
        }
        echo '</TABLE>';
    } else {
        echo "該当商品はありません<BR>";
    }
    ?>
    <br>
    <a href="ex0403.html">戻る</a>
</body>

</html>