<?php
  //セッションのスタート
  session_start();

  // ログイン確認　最終的にチェック外す！
  if ((isset($_SESSION['login']) && $_SESSION['login'] == 'OK')) {
      //ログインフォームへ
      header('Location:index_login.php');
      // 終了
      // exit();
  }

        //接続用関数の呼び出し
        require_once __DIR__.'/functions.php';
?>
<html>
  <head>
    <title>画像処理チャレンジ: IPC</title>
    <meta charset="utf-8">
	<link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="header">
      <h1><a href="index_login.php">画像処理プログラム判定サイト</a></h1>
      <div id="fixedBox" class="nav">
          <ul id="itemMenu">
          <li><a href="problem_list.php">問題一覧</a></li>
          <li><a href="problem_setting.php">問題作成</a></li>
          <!-- <li><a href="mypage.php">マイページ</a></li> -->
          </ul>
          <ul id="LoginTop">
          <li><a href="login.php">ログイン</a></li>
          </ul>
        </div>
  </div>

  <div class ="main">
	  <div class = "login">
	  <h2>ようこそ 　あなたはログインをしていません</h2>
	  </div>
	  <div class="contents">
	  <p>ログインすることで問題解くことができます。<br>
ログイン、もしくはアカウント登録を右上のログインボタンから行なってください。

<br><br><br>＜アカウント登録が済んでいる方＞<br>ユーザー名とパスワードを入力してください。<br><br><br>
＜初めてサイトを使う方＞<br>1、右下の新規登録ボタンを押す
				<br>2、必要事項を埋めてください。
					<br>User Name…ユーザIDです。ログイン時に必要になります。
					<br>Password…パスワードです。ログイン時に必要になります。
					<br>Display Name…ブラウザ上で表記される名前です。
				<br>3、登録ボタンを押すとユーザー登録されます。<br>ログイン画面でログインを行なってください。</p>
	  </div>

	<div class="footer">
    <footer>Copyright@AIT_SawanoLab</footer>
  </div>
</body>
</html>