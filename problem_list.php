<?php
  //セッションのスタート
  session_start();

  // ログイン確認　最終的にチェック外す！
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
    <title>画像処理チャレンジ: IPC</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/table.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
  </head>

  <body>
  <header>
        <h1><a href="index_login.php">画像処理プログラム判定サイト</a></h1>
        <div id="fixedBox" class="nav">
        <ul id="itemMenu">
            <li><a href="problem_list.php">問題一覧</a></li>
            <li><a href="problem_setting.php">問題作成</a></li>
            <!-- <li><a href="mypage.php">マイページ</a></li> -->
            </ul>

            <ul id="LoginTop">
            <li id="quickstart-sign-in"><a href="logout.php">ログアウト</a></li>
    <!--          <li><a href="#">Top</a></li>-->
        </ul>
        </div>
        </header>
  <br>

  <h2>問題一覧</h2>
  <!-- テーブル配置（参考：https://techacademy.jp/magazine/5858、（http://dwcc.blog.fc2.com/blog-entry-31.html、http://dwcc.blog.fc2.com/blog-entry-31.html）） -->
    <table class="problem">
    <thead>
      <tr>
        <th>問題タイトル</th>
        <th>正解済み</th>
      <tr>
    </thead>
    <tbody>
    <?php
    require_once __DIR__.'/functions.php';
    $dbh = connectDB();
    // // SELECT文を変数に格納
    // $sql0 = 'SELECT * FROM problem_tb';
    // SELECT文を変数に格納 (参考；https://www.dbonline.jp/mysql/join/index2.html、澤野先生に教えてもらった)
    //DISTINCT = 重複消す
    // $sql = 'Select DISTINCT `problem_tb`.`id` as `id`, `problem_tb`.`title` as `title`, `answer_history_tb`.`right_wrong` as `right_wrong` FROM `problem_tb` LEFT JOIN `answer_history_tb` ON `problem_tb`.`id` = `answer_history_tb`.`problem_id` WHERE `answer_history_tb`.`user_id` = '.$_SESSION['id'].'';
    //上のだと解答したものしか問題表示されなくなる
    // SELECT文を変数に格納→サブクエリ化する（参考：https://www.dbonline.jp/mysql/select/index20.html#section1）
    $sql = 'Select DISTINCT `problem_tb`.`id`, `problem_tb`.`title`, `answer_history_tb`.`right_wrong` FROM `problem_tb` LEFT OUTER JOIN (SELECT * FROM `answer_history_tb` WHERE `answer_history_tb`.`user_id` = '.$_SESSION['id'].' and `answer_history_tb`.`right_wrong`=0) as `answer_history_tb` on `problem_tb`.id = `answer_history_tb`.`problem_id`';
    // SQLステートメントを実行し、結果を変数に格納
    $stmt = $dbh->query($sql);
    // foreach文で配列の中身を一行ずつ出力
    // （whileはこれ？→https://techacademy.jp/magazine/12348）
    foreach ($stmt as $row) {
        // データベースのフィールド名で出力
        //php id ページ遷移（参考：https://ja.stackoverflow.com/questions/16810/php%E3%81%A7id%E3%82%92%E6%8C%81%E3%81%9F%E3%81%9B%E3%81%A6%E3%83%9A%E3%83%BC%E3%82%B8%E9%81%B7%E7%A7%BB%E3%81%97%E3%81%9F%E3%81%84）
        echo '<td>';
        echo '<a href="problem_page.php?id='.$row['id'].'">'.$row['title'].'</a>';
        echo '</td>';
        if (is_null($row['right_wrong'])) {
            echo '<td></td>';
        } elseif ($row['right_wrong'] == 0) {
            echo '<td><div class="problem_check"></div></td>';
        } else {
            echo '<td></td>';
        }
        echo '</tr>';
        // echo 'てすと'.$row['right_wrong']; //確認用
    }
    ?>
    <tbody>
    </table>

  <footer>
    <p>Copyright@AIT_SawanoLab</p>
  </footer>


  </body>
</html>
