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
    <link rel="stylesheet" href="css/item.css">
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

  <br>
  <div class="item">
      <ul>
        <li><a href="create_group.php">新しく限定公開グループを作る</a></li>
        <li><a href="create_issue.php">新しく問題を作る</a></li>
    </ul>
  </div>

  <div class="footer">
    <p>Copyright@AIT_SawanoLab</p>
  </div>


  </body>
</html>
