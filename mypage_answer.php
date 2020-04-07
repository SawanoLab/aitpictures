<?php
//セッションのスタート
session_start();
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
    <?php
    if(!((isset($_SESSION['login'])&&$_SESSION['login'] == 'OK'))){
    //ログインフォームへ
    header('Location:login.html');
    // 終了
    exit();
  }
  //接続用関数の呼び出し
  require_once(__DIR__.'/functions.php');
     ?>
    <div class="header">
      <h1><a href="index_login.php">画像処理プログラム判定サイト</a></h1>
      <div id="fixedBox" class="nav">
          <ul id="itemMenu">
          <li><a href="issue_public.php">公開問題</a></li>
          <li><a href="create.php">新規作成</a></li>
          <li><a href="mypage.php">マイページ</a></li>
          </ul>

          <ul id="LoginTop">
          <li id="quickstart-sign-in"><a href="logout.php">ログアウト</a></li>
<!--          <li><a href="#">Top</a></li>-->
          </ul>
        </div>
  </div>

  <?php
  $dbh=connectDB();
    if($dbh){
      //データベースへの問い合わせSQL文（文字列）　
      $user_id = $_SESSION['id'];
      $sql = 'SELECT * FROM user_Answer_tb WHERE user_id="'.$user_id.'"';
      $sth = $dbh->query($sql);//SQLの実行
      $result = $sth->fetchALL(PDO::FETCH_ASSOC);
    }
  ?>
  <br>
  <h2>正解済みの解答一覧</h2>
  <table class="questions">
    <thead>
      <tr class="problem_tr">
        <th>問題タイトル</th>
        <th>提出時間</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($result as $row) {
        $problem_id = $row['problem_id'];
        $sql_1 = 'SELECT title FROM problem_tb WHERE id="'.$problem_id.'"';
        $sth_1 = $dbh->query($sql_1);//SQLの実行
        $result_1 = $sth_1->fetchALL(PDO::FETCH_ASSOC);
        foreach ($result_1 as $row1) {
          echo "<tr><td>".$row1['title']."</td>";
          echo "<td>".$row['timestamp']."</td><tr>";
        }
      }

      ?>
    </tbody>
  </table>


  <div class="footer">
    <p>Copyright@AIT_SawanoLab</p>
  </div>


  </body>
</html>
