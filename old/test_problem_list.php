<html>
<head>
    <meta charset="UTF-8"/>
    <title>問題一覧</title>
</head>
<body>
<ul>
<?php
    require_once __DIR__.'/functions.php';
    $dbh = connectDB();

    // SELECT文を変数に格納
    $sql = 'SELECT * FROM problem_tb';

    // SQLステートメントを実行し、結果を変数に格納
    $stmt = $dbh->query($sql);

    // foreach文で配列の中身を一行ずつ出力
    foreach ($stmt as $row) {
        // データベースのフィールド名で出力
        //php id ページ遷移（参考：https://ja.stackoverflow.com/questions/16810/php%E3%81%A7id%E3%82%92%E6%8C%81%E3%81%9F%E3%81%9B%E3%81%A6%E3%83%9A%E3%83%BC%E3%82%B8%E9%81%B7%E7%A7%BB%E3%81%97%E3%81%9F%E3%81%84）
        echo '<li><a href="test_problem_answer.php?id='.$row['id'].'">'.$row['title'].'</a></li>';
    }
?>
</ul>
</body>
</html>