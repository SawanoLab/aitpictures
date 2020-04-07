<?php
//セッション開始
session_start();
session_unset();//セッションの初期化
session_destroy();//セッションを破棄
?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;" charset="utf-8">
    <title>画像処理チャレンジ: IPC</title>
    <link rel="stylesheet" type="text/css" href="css/logout.css" media="all" />
  </head>
  <body>
    <div id="logout">
      <p class="logout-title">
        Logout
      </p>
      <p class="logout-check">
        ログアウトしました.<br>
      </p>
      <p class="re-login">
        再ログインはこちらから
        <a href="login.html"><input type="submit" value="ログインページ"></a>
      </p>
      
    
    </div>
  </body>
</html>
