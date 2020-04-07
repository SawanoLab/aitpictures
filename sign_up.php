<?php
//接続用関数の呼び出し
require_once(__DIR__.'/functions.php');
//セッションの生成
session_start();
if(!(isset($_POST['user'])&&
  isset($_POST['pass']))){
  header('Location:login.html');
}

if((isset($_POST['user'])&&
  $_POST['user']==""&&
  isset($_POST['pass']))){
  header('Location:login.html');
}

if((isset($_POST['user'])&&
  $_POST['pass']==""&&
  isset($_POST['pass']))){
  header('Location:login.html');
}

//ユーザ名/パスワード
$user = htmlspecialchars($_POST['user'],ENT_QUOTES);
$pass = htmlspecialchars($_POST['pass'],ENT_QUOTES);
$name = htmlspecialchars($_POST['name'],ENT_QUOTES);
$dbh=connectDB();
//DBへの接続
if($dbh){
  //データベースへの問い合わせSQL文（文字列）　
  $sql ='SELECT display_name FROM user_tb WHERE login_name="'.$user.'" AND login_password="'.$pass.'"';
  $sth = $dbh->query($sql);//SQLの実行
  //データの取得
  $result = $sth->fetchALL(PDO::FETCH_ASSOC);
}
//認証
//if(($user == 'x17000')&&($pass == 'webphp')){
if(count($result)==1){//配列数が唯一の場合
  //ログイン成功
  $login = 'OK';
}else{
  //ログイン失敗
  if((isset($_POST['user'])&&
    $_POST['user']==""&&
    isset($_POST['pass']))){

  }else if((isset($_POST['user'])&&
    $_POST['pass']==""&&
    isset($_POST['pass']))){

  }else if($dbh){
    $sql_1='INSERT INTO user_tb(login_name, login_password, display_name) VALUES("'.$user.'","'.$pass.'","'.$name.'")';
    $sth_1 = $dbh->query($sql_1);//SQLの実行
  }
}
$shh = null;//データの消去
$dbh=null;//DBを閉じる
//移動
if($login == 'OK'){
  header('Location:re_login.html');
}else{
}
 ?>

 <html>
 <head>
   <meta http-equiv="content-type" content="text/html;" charset="utf-8">
   <title>画像処理チャレンジ: IPC</title>
   <link rel="stylesheet" type="text/css" href="css/sign_up.css" media="all" />
 </head>
 <body>
    <div id="sign-up">
      <p class="sign-up-title">
        Sign up is completed
      </p>
      <p class="sign-up-text">
        登録が完了しました.<br>
        お手数ですがログインページへ移動し、ログインして下さい.<br>
      </p>
      <p class="submit">
        <a href="login.html">
          <input type="submit" value="ログインページ">
        </a>
      </p>
    </div>
 </body>
 </html>
