<?php
//接続用関数の呼び出し
require_once(__DIR__.'/functions.php');
//セッションの生成
session_start();
if(!(isset($_POST['user'])&&isset($_POST['pass']))){
  header('Location:login.html');
}
//ユーザ名/パスワード
$user = htmlspecialchars($_POST['user'],ENT_QUOTES);
$pass = htmlspecialchars($_POST['pass'],ENT_QUOTES);
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
  //表示用ユーザ名のセッション変数に保存
  $_SESSION['name']=$result[0]['display_name'];
}else{
  //ログイン失敗
  //$login = 'Error';
}

if($dbh){
  //データベースへの問い合わせSQL文（文字列）　
  $sql_1 ='SELECT user_id FROM user_tb WHERE login_name="'.$user.'" AND login_password="'.$pass.'"';
  $sth_1 = $dbh->query($sql_1);//SQLの実行
  //データの取得
  $result_1 = $sth_1->fetchALL(PDO::FETCH_ASSOC);
}

if(count($result_1)==1){//配列数が唯一の場合
  //表示用ユーザ名のセッション変数に保存
  $_SESSION['id']=$result_1[0]['user_id'];
}

$shh = null;//データの消去
$dbh=null;//DBを閉じる


//セッション変数に代入
$_SESSION['login'] = $login;
$_SESSION['user']=$user;
//移動
if($login == 'OK'){
  header('Location:index_login.php');
}else{
  //ログイン失敗
  header('Location:login.html');
}
?>
