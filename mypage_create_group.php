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
      $sql = 'SELECT * FROM group_tb WHERE creator_id="'.$user_id.'"';
      $sth = $dbh->query($sql);//SQLの実行
      $result = $sth->fetchALL(PDO::FETCH_ASSOC);
    }
  ?>

  <br>
  <h2>作成したグループ一覧</h2>
  <table class="questions">
    <thead>
      <tr class="problem_tr">
        <th>グループ名</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($result as $row) {
        $creator_id = $row['creator_id'];
        if($user_id==$creator_id){
          echo "<tr><td>".$row['group_name']."</td></tr>";
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
