<?php

    //セッションの生成
    session_start();

    //接続用関数の呼び出し
    require_once __DIR__.'/functions.php';

    // if (!(isset($_POST['user']) && isset($_POST['pass']))) {
    //     header('Location:index.html');
    // }

    //ユーザ名/パスワード
    $user = htmlspecialchars($_POST['user'], ENT_QUOTES);
    $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES);

    //DBへの接続
    $dbh = connectDB();

    if (!$dbh) {
        echo 'データベースの接続に失敗しました．<br>';
        echo '管理者にご連絡ください．';

        return false;
    }

  /////////////////////////////////////////////////////////////////

    if ($dbh) {
        //データベースへの問い合わせSQL文（文字列）　
        $sql = 'SELECT * FROM user_tb WHERE login_name="'.$user.'" AND login_password="'.$pass.'"'; //*で全て読み込む
        $sth = $dbh->query($sql); //SQLの実行
        //データの取得（参考？：https://bituse.info/php/37）
        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
    }
    //認証
    if (count($result) == 1) {//配列数が唯一の場合
        //ログイン成功
        $login = 'OK';
        //表示用ユーザ名のセッション変数に保存 index_login.php、使用・表示
        $_SESSION['name'] = $result[0]['display_name'];
        //ユーザ情報を保存　解答履歴などで使用・表示
        $_SESSION['id'] = $result[0]['id'];
    } else {
        //ログイン失敗
        // $login = 'failure';
    }

     //ログイン時間の更新 （参考：https://www.softel.co.jp/blogs/tech/archives/277）
     $sql = 'UPDATE `user_tb` SET `last_login`=CURRENT_TIMESTAMP WHERE `user_id`='.$result[0]['user_id'];
     $dbh->query($sql); //SQLの実行

     $shh = null; //データの消去
     $dbh = null; //DBを閉じる

/////////////////////////////////////////////////////////////////

    // if ($dbh) {
    //     //データベースへの問い合わせSQL文（文字列）　
    //     $sql_1 = 'SELECT user_id FROM user_tb WHERE login_name="'.$user.'" AND login_password="'.$pass.'"';
    //     $sth_1 = $dbh->query($sql_1); //SQLの実行
    //     //データの取得
    //     $result_1 = $sth_1->fetchALL(PDO::FETCH_ASSOC);
    // }
    // //認証
    // if (count($result_1) == 1) {//配列数が唯一の場合
    //     //表示用ユーザ名のセッション変数に保存
    //     $_SESSION['id'] = $result_1[0]['user_id'];
    // }

    // //ログイン時間の更新
    // $sql = 'UPDATE `user_tb` SET `last_login`=CURRENT_TIMESTAMP WHERE `user_id`='.$result_1[0]['user_id'];
    // $dbh->query($sql); //SQLの実行

    $shh = null; //データの消去
    $dbh = null; //DBを閉じる

    //セッション変数に代入
    $_SESSION['login'] = $login;
    $_SESSION['user'] = $user;

    //移動
    if ($login == 'OK') {
        header('Location:index_login.php');
    } else {
        //ログイン失敗
        $_SESSION['login'] = 'failure';
        header('Location:login.php');
    }
