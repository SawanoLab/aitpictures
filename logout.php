<?php
//セッション開始
session_start();
session_unset(); //セッションの初期化
session_destroy(); //セッションを破棄
//個別に消す→使用する正しいコードは、単一のセッション名の設定を解除する場合にのみ unset($_SESSION['session_name']) です。（参考：https://www.it-swarm-ja.tech/ja/php/php%E3%81%AEsessionunset%EF%BC%88%EF%BC%89%E3%81%A8sessiondestroy%EF%BC%88%EF%BC%89%E3%81%AE%E9%81%95%E3%81%84%E3%81%AF%E4%BD%95%E3%81%A7%E3%81%99%E3%81%8B%EF%BC%9F/970531679/#:~:text=%E4%BD%BF%E7%94%A8%E3%81%99%E3%82%8B%E6%AD%A3%E3%81%97%E3%81%84%E3%82%B3%E3%83%BC%E3%83%89%E3%81%AF,'session_name'%5D)%20%E3%81%A7%E3%81%99%E3%80%82&text=session_destroy()%20%E3%81%AF%E3%83%9A%E3%83%BC%E3%82%B8%E3%81%AE%E7%A7%BB%E5%8B%95,%E3%82%BB%E3%83%83%E3%82%B7%E3%83%A7%E3%83%B3%E3%82%92%E5%89%8A%E9%99%A4%E3%81%97%E3%81%BE%E3%81%99%E3%80%82）
// session_unset($_SESSION['name']); //セッションの初期化 内容だけ消す
// session_destroy($_SESSION['name']); //セッションを破棄　セッション名自体を消す
// session_unset($_SESSION['id']); //セッションの初期化 内容だけ消す
// session_destroy($_SESSION['id']); //セッションを破棄　セッション名自体を消す
// session_unset($_SESSION['login']); //セッションの初期化 内容だけ消す
// session_destroy($_SESSION['login']); //セッションを破棄　セッション名自体を消す
// session_unset($_SESSION['user']); //セッションの初期化 内容だけ消す
// session_destroy($_SESSION['user']); //セッションを破棄　セッション名自体を消す
?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;" charset="utf-8">
  <title>ログアウト</title>
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
        トップページに戻る
        <a href="index.php"><input type="submit" value="トップページ"></a>
      </p>
      
    
    </div>
  </body>
</html>


