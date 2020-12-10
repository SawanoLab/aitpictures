<?php
//セッションのスタート
session_start(); //セッション変数　他のphpファイルで使うため

  // ログイン確認　最終的にチェック外す！
  if (!((isset($_SESSION['login']) && $_SESSION['login'] == 'OK'))) {
      //ログインフォームへ
      header('Location:index.php');
      // 終了
    // exit();
  }
?>

<html>
  <head>
    <title>画像処理チャレンジ: IPC</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/item.css">
    <link rel="stylesheet" href="css/flexible-form.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
    
    <script type="text/javascript">
    //未入力のアラート通知（参考：https://uxmilk.jp/11590 , http://alphasis.info/2011/04/javascript-form-check-required-input/）
    function check(){
    	var flag = 0;
    	// 設定開始（必須にする項目を設定してください）
    	if(document.form1.title.value == ""){ // 「タイトル」の入力をチェック
    		flag = 1;
    	}
    	else if(document.form1.sentence.value == ""){ // 「問題文」の入力をチェック
    		flag = 1;
    	}


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
    <header>
        <h1><a href="index_login.php">画像処理プログラム判定サイト</a></h1>
        <div id="fixedBox" class="nav">
        <ul id="itemMenu">
            <li><a href="problem_list.php">問題一覧</a></li>
            <li><a href="problem_setting.php">問題作成</a></li>
            <!-- <li><a href="mypage.php">マイページ</a></li> -->
            </ul>

            <ul id="LoginTop">
            <li id="quickstart-sign-in"><a href="logout.php">ログアウト</a></li>
    <!--          <li><a href="#">Top</a></li>-->
        </ul>
        </div>
    </header>
    <br>

  <form action="problem_setting_result.php" method="post" name="form1" enctype="multipart/form-data" onSubmit="return check()">
    <p>
      問題名<input type="text" name="title" size="30">
    </p>
    <p>
      問題文<br>
      <textarea name="sentence" cols="30" rows="10"></textarea>
    </p>
    <p>
      例題＿入力画像<br>（問題と一緒に表示される画像です）<br>
      <!-- フォーム画面で複数枚選べるようにする（参考：https://webcrehoo.com/56） -->
      <!-- <input type="text" name="input_name"  size="30"> -->
      <!-- accept="ファイルの種類" -->
      <!-- required ファイル入っているか確認（参考：https://web-designer.cman.jp/html_ref/abc_list/input_file/） -->
      <div id="input_pluralBox">
      <div id="input_plural">
        <input type="file" multiple="multiple" name="ex_input_file[]" accept="image/*" required> 
        <input type="button" value="＋" class="add pluralBtn">
        <input type="button" value="－" class="del pluralBtn">
      </div>
    </div>
    </p>
    <p>
      例題＿出力画像<br>（問題と一緒に表示される画像です）<br>
      <div id="input_pluralBox">
      <div id="input_plural">
        <input type="file" multiple="multiple" name="ex_output_file[]" accept="image/*" required> 
        <input type="button" value="＋" class="add pluralBtn">
        <input type="button" value="－" class="del pluralBtn">
      </div>
    </div>
    </p>
    <p>
      判定＿入力画像<br>（ユーザの入力したコードで使用される入力画像です）<br>
      <div id="input_pluralBox">
      <div id="input_plural">
        <input type="file" multiple="multiple" name="jud_input_file[]" accept="image/*" required>
        <input type="button" value="＋" class="add pluralBtn">
        <input type="button" value="－" class="del pluralBtn">
      </div>
    </div>
    </p>
    <p>
      判定＿出力画像<br>（ユーザの入力したコードで出力された画像と比べる正解用の画像です）<br>
      <div id="input_pluralBox">
      <div id="input_plural">
        <input type="file" multiple="multiple" name="jud_output_file[]" accept="image/*" required> 
        <input type="button" value="＋" class="add pluralBtn">
        <input type="button" value="－" class="del pluralBtn">
      </div>
    </div>
    </p>
    <p>
      出力テキスト<br>（数字などテキストで答えた場合の回答です）<br>
      <textarea name="output_text" cols="30" rows="10"></textarea>
    </p>
    <p>
      ヒント<br>
      <textarea name="hint" cols="30" rows="10"></textarea>
    </p>
    <p>
      <input type="submit" value="送信">
    </p>
  </form>


  <div class="footer">
    <p>Copyright@AIT_SawanoLab</p>
  </div>

  <script type="text/javascript">
  $(document).on("click", ".add", function() {
    $(this).parent().clone(true).insertAfter($(this).parent());
  });
  $(document).on("click", ".del", function() {
    var target = $(this).parent();
    if (target.parent().children().length > 1) {
        target.remove();
    }
  });
  </script>

</body>
</html>
