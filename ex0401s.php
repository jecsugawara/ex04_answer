<?php
require_once("db_connect.php");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex0401s</title>
</head>

<body>
    <h1>ex0401s.php</h1>
    <h2>26jy02xx 電子タロウ</h2>
    <h3>カテゴリー一覧</h3>
    <?php
    // カテゴリー一覧を表示する
    try {
        $sql = "SELECT category_id, category_name FROM w_category ORDER BY category_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $pdo = null; // データベース接続を閉じる
    } catch (PDOException $e) {
        echo "データベースエラー: " . $e->getMessage();
        exit;
    }   

    echo $stmt->rowCount() . "件のカテゴリーが見つかりました。<BR>";

    print "<UL>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cid = $row['category_id'];
        $cname = $row['category_name'];
        echo "<LI>" . "<a href='ex0402s.php?cid=$cid'>$cname</a>"  .  "</LI>";
    }
    echo "</UL>";
    ?>
</body>

</html>