<?php
//セッションのスタート
session_start();
?>
<html>
  <head>
    <title>画像処理チャレンジ: IPC</title>
    <meta charset="utf-8">
	<link rel="stylesheet" href="css/index_login.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
  </head>

  <body>
    <?php
    // if (!((isset($_SESSION['login']) && $_SESSION['login'] == 'OK'))) {
    //     //ログインフォームへ
    //     header('Location:index.php');
    //     // 終了
    //     exit();
    // }
  //接続用関数の呼び出し
  require_once __DIR__.'/functions.php';
     ?>
    <div class="header">
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
  </div>

<div class ="main">
	<div class = "login">
	  <?php
    echo '<h2>'.'ようこそ'.$_SESSION['name'].'さん　'.'あなたはログインをしています'.'</h2>';
    // echo '<h2>'.$_SESSION['id'].'</h2>'; //確認用
    ?>
	<div class="contents">
	  <p>このサイトは誰でも無料で利用できる<br>画像処理を行うプログラミング問題のオンライン採点システムです。<br><br>
		  <!-- ＜各ページの説明＞<br><br>
公開問題<br>一般公開されている問題リストです。どなたでも解答できます。
		  <br><br>
新規作成<br>限定公開グループを作るページと新しく問題を作るページがあります。<br>
　　　　　限定公開グループを作る…グループをつくりメンバーを決めることで特定の人しか閲覧できなくなります。<br>
						　マイページでグループのメンバーを編集できます。<br>
　　　　　新しく問題を作るページ…公開設定で一般公開か限定公開のグループを複数選択することができます。<br>
						　必要事項を埋めてください。<br>
		  <br>
		  マイページ<br>今まで自分が　解いた・作った問題やグループ　が　閲覧・編集　できます。</p> -->
  </div>

  <div class="footer">
    <footer>Copyright@AIT_SawanoLab</footer>
  </div>


  </body>
</html>
	  
