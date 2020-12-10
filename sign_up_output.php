<?php
//接続用関数の呼び出し
require_once __DIR__.'/functions.php';

//セッションの生成
session_start();

//未入力の場合
// if (!(isset($_POST['user']) && isset($_POST['pass']))) {
//     header('Location:sign_up_re2.php'); //注意事項表記の登録画面に戻す
// }

// if ((isset($_POST['user']) && $_POST['user'] == '' && isset($_POST['pass']))) {
//     header('Location:sign_up_re2.php'); //注意事項表記の登録画面に戻す
// }

// if ((isset($_POST['user']) && $_POST['pass'] == '' && isset($_POST['pass']))) {
//     header('Location:sign_up_re2.php'); //注意事項表記の登録画面に戻す
// }

//ユーザ名/パスワード
$user = htmlspecialchars($_POST['user'], ENT_QUOTES);
$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES);
$name = htmlspecialchars($_POST['name'], ENT_QUOTES);

//DBへの接続
$dbh = connectDB();
if ($dbh) {
    //データベースへの問い合わせSQL文（文字列）　
    $sql = 'SELECT display_name FROM user_tb WHERE login_name="'.$user.'" AND login_password="'.$pass.'"';
    $sth = $dbh->query($sql); //SQLの実行
    //データの取得
    $result = $sth->fetchALL(PDO::FETCH_ASSOC);
}
//認証
//if(($user == 'x17000')&&($pass == 'webphp')){
if (count($result) == 1) {//配列数が唯一の場合
  //ログイン成功
  $login = 'OK';
} else {
    //ログイン失敗（ログイン情報がないとき）
    if ((isset($_POST['user']) && $_POST['user'] == '' && isset($_POST['pass']))) {
    } elseif ((isset($_POST['user']) && $_POST['pass'] == '' && isset($_POST['pass']))) {
    } elseif ($dbh) {
        //新しく登録する
        $sql = 'INSERT INTO user_tb(login_name, login_password, display_name) VALUES("'.$user.'","'.$pass.'","'.$name.'")';
        $sth = $dbh->query($sql); //SQLの実行
    }
}
$sth = null; //データの消去
$dbh = null; //DBを閉じる

//移動
if ($login == 'OK') { //ログインできてしまったら
    header('Location:sign_up_re.php'); //ユーザIDが使われていることにして登録し直す
}
?>

<html>
<head>
  <meta http-equiv="content-type" content="text/html;" charset="utf-8">
  <title>登録ページ</title>
</head>
<body>
  登録しました。ログインしてください.
  <a href="login.php">ログインページへ</a>

</body>
</html>
