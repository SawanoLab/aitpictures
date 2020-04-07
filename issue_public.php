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
    <link rel="stylesheet" href="css/table.css">
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
  <?php
  $dbh=connectDB();
  //DBへの接続
  if($dbh){
    //データベースへの問い合わせSQL文（文字列）　
    $sql = 'SELECT group_name,id FROM group_tb';
    $sth = $dbh->query($sql);//SQLの実行
    //データの取得
    $result = $sth->fetchALL(PDO::FETCH_ASSOC);

    $group = htmlspecialchars($_POST['problem_name'], ENT_QUOTES);

    if(isset($_POST['problem_name'])==""){
      $group =  $result[0]['group_name'];
    }

    $sql_2 ='SELECT id FROM group_tb WHERE group_name="'.$group.'"';
    $sth_2 = $dbh->query($sql_2);//SQLの実行
    //データの取得
    $result_2 = $sth_2->fetchALL(PDO::FETCH_ASSOC);
    if(count($result_2)==1){//配列数が唯一の場合
      //表示用ユーザ名のセッション変数に保存
      $group_id = $result_2[0]["id"];
    }

    $sql_1 ='SELECT title, id FROM problem_tb WHERE group_id="'.$group_id.'"';
    $sth_1 = $dbh->query($sql_1);//SQLの実行
    //データの取得
    $result_1 = $sth_1->fetchALL(PDO::FETCH_ASSOC);
    $user_id = $_SESSION['id'];
    $sql_3 ='SELECT problem_id,timestamp FROM user_Answer_tb WHERE user_id="'.$user_id.'"';
    $sth_3 = $dbh->query($sql_3);//SQLの実行
    //データの取得
    $result_3 = $sth_3->fetchALL(PDO::FETCH_ASSOC);

    $sql_4 ='SELECT user_id,group_id FROM group_participant_tb WHERE group_id="'.$group_id.'"';
    $sth_4 = $dbh->query($sql_4);//SQLの実行
    $result_4 = $sth_4->fetchALL(PDO::FETCH_ASSOC);
    $sql_5 ='SELECT user_id,group_id FROM group_participant_tb';
    $sth_5 = $dbh->query($sql_5);//SQLの実行
    $result_5 = $sth_5->fetchALL(PDO::FETCH_ASSOC);
  }
  // foreach文で配列の中身を一行ずつ出力
  ?>
  <h2>問題一覧</h2>
  <ul class="group">
    <form action="" method="post" name="form2" enctype="multipart/form-data" onSubmit="return check()">
      <p>
      <select name="problem_name">
        <?php
        foreach ($result as $row) {
          // データベースのフィールド名で出力
          if($row['id']=='1'){
            echo "<option>".$row['group_name']."</option>";
          }else {
            foreach ($result_5 as $row2){
              if(($row['id']==$row2['group_id'])&&($_SESSION['id']==$row2['user_id'])){
                echo "<option>".$row['group_name']."</option>";
              }
            }
          }
        }
        ?>
    </select>
    </p>
    <input type="submit" value="グループを移動する">
    </form>
    <!-- <li><a href="">グループを追加する</a></li> -->
  </ul>
  <table class="questions">
    <thead>
      <tr class="problem_tr">
        <th>チェック</th>
        <th>問題タイトル</th>
        <th>提出時間</th>
      </tr>
    </thead>
    <tbody>

      <?php
      foreach ($result_1 as $row) {
        $count = 0;
        foreach ($result_3 as $row1) {
          if($row1['problem_id']==$row['id']){
            echo "<tr><td>&#10004;</td>";
            $count++;
          }
        }
        if($count=='0'){
            echo "<tr><td> </td>";
        }
        echo "<td><form name='Problem" . $row['id'] . "' method='POST' action='problem_answer.php'><a href='javascript:Problem" . $row['id'] . ".submit()'><input type='hidden' value='" . $row['id'] . "' name='id'>" . $row['title'] . "</a></form></td>\n";
        $count = 0;
        foreach ($result_3 as $row1) {
          if($row1['problem_id']==$row['id']){
            $count++;
            echo "<td>" . $row1['timestamp'] . "</td>\n";
          }
      }
        if($count=='0'){
          echo "<td> </td>\n";
        }
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
  <?php
  $dbh = null;
  ?>

  <div class="footer">
    <p>Copyright@AIT_SawanoLab</p>
  </div>


  </body>
</html>
