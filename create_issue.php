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
    <link rel="stylesheet" href="css/item.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    function check(){
    	var flag = 0;
    	// 設定開始（必須にする項目を設定してください）
    	if(document.form1.title.value == ""){ // 「タイトル」の入力をチェック
    		flag = 1;
    	}
    	else if(document.form1.problem.value == ""){ // 「問題文」の入力をチェック
    		flag = 1;
    	}
    	// else if(document.form1.problem.value == ""){ // 「コメント」の入力をチェック
    	// 	flag = 1;
    	// }
    	// 設定終了
    	if(flag){
    		window.alert('必須項目に未入力がありました'); // 入力漏れがあれば警告ダイアログを表示
    		return false; // 送信を中止
    	}
    	else{
    		return true; // 送信を実行
    	}
    }
    </script>
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
  $dbh=connectDB();
  //DBへの接続
  if($dbh){
    //データベースへの問い合わせSQL文（文字列）　
    $sql = 'SELECT group_name FROM group_tb';
    $sth = $dbh->query($sql);//SQLの実行
    //データの取得
    $result = $sth->fetchALL(PDO::FETCH_ASSOC);
  }
  $dbh = null;
  // foreach文で配列の中身を一行ずつ出力
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
  <form action="form_output.php" method="post" name="form1" enctype="multipart/form-data" onSubmit="return check()">
      <p>
          グループ：
          <select name="group">
              <?php
  				    foreach ($result as $row) {
  				      // データベースのフィールド名で出力
  				      echo "<option>" . $row['group_name'] . "</option>\n";
  				    }
  				    ?>
          </select>
      </p>
      <p>
          タイトル：<input type="text" name="title" size="30">
      </p>
      <p>
          問題文：<br>
          <textarea name="problem" cols="30" rows="10"></textarea>
      </p>
      <p>
          入力：
          <!-- <input type="text" name="input_name"  size="30"> -->
          <input type="file" name="input_file">
      </p>
      <p>
          出力：
          <input type="file" name="output_file">
      </p>
      <p>
          出力Text：<br>
          <textarea name="outputText" cols="30" rows="10"></textarea>
      </p>
  		<p>
          ヒント：<br>
          <textarea name="hintText" cols="30" rows="10"></textarea>
      </p>
      <p>
          <input type="submit" value="送信"><input type="reset" value="リセット">
      </p>
  </form>


  <div class="footer">
    <p>Copyright@AIT_SawanoLab</p>
  </div>


  </body>
</html>
