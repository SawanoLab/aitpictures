<!-- 結局使ってない、ちょっとアレンジしてるの使ってる -->
<html>
<head>
    <meta charset="UTF-8"/>
    <title>問題一覧</title>
</head>
<body>
<?php
    require_once __DIR__.'/functions.php';
    $dbh = connectDB();

    $id = $_GET['id'];
    // SELECT文を変数に格納
    $sql = 'SELECT * FROM problem_tb';

    // SQLステートメントを実行し、結果を変数に格納
    $stmt = $dbh->query($sql);

    // foreach文で配列の中身を一行ずつ出力
    foreach ($stmt as $row) {
        if ($id === $row['id']) {
            $title = $row['title'];
            echo '<h1>'.$title.'</h1>';
            break;
        }
    }
?>
</body>
</html>