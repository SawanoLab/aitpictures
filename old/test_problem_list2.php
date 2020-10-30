<?php
  //セッションのスタート
  session_start();

  //ログイン確認　最終的にチェック外す！
  // if (!((isset($_SESSION['login']) && $_SESSION['login'] == 'OK'))) {
  //     //ログインフォームへ
  //     header('Location:index.php');
  //     // 終了
  //     // exit();
  // }

        //接続用関数の呼び出し
        require_once __DIR__.'/functions.php';
?>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>問題一覧</title>
    <link rel="stylesheet" href="css/table.css">
</head>
<body>
<ul>
<?php
    require_once __DIR__.'/functions.php';
    $dbh = connectDB();

    // SELECT文を変数に格納 (参考；https://www.dbonline.jp/mysql/join/index2.html、澤野先生に教えてもらった)
    $sql = 'Select DISTINCT `problem_tb`.`id` as `id`, `problem_tb`.`title` as `title`, `answer_history_tb`.`right_wrong` as `right_wrong` FROM `problem_tb` LEFT JOIN `answer_history_tb` ON `problem_tb`.`id` = `answer_history_tb`.`problem_id` WHERE `answer_history_tb`.`user_id` = 3';

    // SQLステートメントを実行し、結果を変数に格納
    $stmt = $dbh->query($sql);

    // foreach文で配列の中身を一行ずつ出力
    // （whileはこれ？→https://techacademy.jp/magazine/12348）
    foreach ($stmt as $row) {
        // データベースのフィールド名で出力
        //php id ページ遷移（参考：https://ja.stackoverflow.com/questions/16810/php%E3%81%A7id%E3%82%92%E6%8C%81%E3%81%9F%E3%81%9B%E3%81%A6%E3%83%9A%E3%83%BC%E3%82%B8%E9%81%B7%E7%A7%BB%E3%81%97%E3%81%9F%E3%81%84）
        echo '<li>';
        echo '<a href="test_problem_answer.php?id='.$row['id'].'">'.$row['title'].'</a>';
        if ($row['right_wrong'] == 0) {
            echo '<div class="problem_check"></div>';
        }
        echo '</li>';
    }
?>
</ul>
<div>
  
</div>
</body>
</html>