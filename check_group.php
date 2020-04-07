<?php
//接続用関数の呼び出し
require_once(__DIR__.'/functions.php');
//セッションの生成
session_start();
if(!(isset($_POST['group_create']))){
  header('Location:create_group.php');
}

if((isset($_POST['group_create'])&&
  $_POST['group_create']=="")){
  header('Location:create_group.php');
}


//ユーザ名/パスワード
$group_create = htmlspecialchars($_POST['group_create'],ENT_QUOTES);
$dbh=connectDB();
//DBへの接続
if($dbh){
  //データベースへの問い合わせSQL文（文字列）　
  $sql ='SELECT group_name FROM group_tb WHERE group_name="'.$group_create.'"';
  $sth = $dbh->query($sql);//SQLの実行
  //データの取得
  $result = $sth->fetchALL(PDO::FETCH_ASSOC);

  $user_id = $_SESSION['id'];
}

//認証
//if(($user == 'x17000')&&($pass == 'webphp')){
if((isset($_POST['group_create'])&&
    $_POST['group_create']=="")){

  }else if($dbh){
    if($result[0]['group_name']==$group_create){
      header('Location:create_group.php');
    }else{
      $sql_1='INSERT INTO group_tb(group_name,creator_id) VALUES("'.$group_create.'","'.$user_id.'")';
      $sth_1 = $dbh->query($sql_1);//SQLの実行
      $sql_3 = 'SELECT id FROM group_tb WHERE group_name="'.$group_create.'" AND creator_id="'.$user_id.'"';
      $sth_3 = $dbh->query($sql_3);//SQLの実行
      $result_1 = $sth_3->fetchALL(PDO::FETCH_ASSOC);
      $group_id =$result_1[0]['id'];
      $role_id =1;
      $sql_2='INSERT INTO group_participant_tb(group_id,user_id,role_id) VALUES("'.$group_id.'","'.$user_id.'","'.$role_id.'")';
      $sth_2 = $dbh->query($sql_2);//SQLの実行
    }
}
$shh = null;//データの消去
$dbh=null;//DBを閉じる
 ?>

<html>
 <head>
   <meta http-equiv="content-type" content="text/html;" charset="utf-8">
   <title>画像処理チャレンジ: IPC</title>
   <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/check_group.css">
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
    ?>
    <div class="header">
      <h1>
        <a href="index_login.php">画像処理プログラム判定サイト</a>
      </h1>
      <div id="fixedBox" class="nav">
        <ul id="itemMenu">
          <li><a href="issue_public.php">公開問題</a></li>
          <li><a href="create.php">新規作成</a></li>
          <li><a href="mypage.php">マイページ</a></li>
        </ul>

        <ul id="LoginTop">
          <li id="quickstart-sign-in">
            <a href="logout.php">ログアウト</a>
          </li>
        </ul>
      </div>
    </div>
    <br>
    <br>
    <h2>
      グループ登録完了
    </h2>
    <div id="check_group_id">
      <p class="check_group">
        <?php echo $group_create." ";?>グループを作成しました.<br>
      </p>
      <p class="explanation">
        作成したグループを確認する場合は作成したグループ一覧をクリックして下さい.<br>
        問題を制作する場合は問題制作ページをクリックして下さい.
      </p>
      <div id="submit">
        <p　class="create-group">
          <a href="mypage_create_group.php">
            <input type="submit" value="作成したグループ一覧"></a>
            <a href="create_issue.php" class="problem_create">
              <input type="submit" value="問題制作ページ">
            </a>
        </p>
      </div>
    </div>
    <div class="footer">
      <p>Copyright@AIT_SawanoLab</p>
    </div>
 </body>
</html>
