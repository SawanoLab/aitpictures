<html>
<head>
  <meta http-equiv="content-type" content="text/html;" charset="utf-8">
  <title>formsample</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
  <script type="text/javascript">
    //未入力のアラート通知（参考：https://uxmilk.jp/11590 , http://alphasis.info/2011/04/javascript-form-check-required-input/）
    function check(){ //form actionに name="form1" と　onsubmit="return check()　を入れて適用
    	var flag = 0;
    	// 設定開始（必須にする項目を設定してください）
    	if(document.form1.user.value == ""){ // 「ユーザ名」の入力をチェック
    		flag = 1;
    	}
    	else if(document.form1.pass.value == ""){ // 「パスワード」の入力をチェック
    		flag = 1;
    	}
    	else if(document.form1.name.value == ""){ // 「表示する名前」の入力をチェック
    		flag = 1;
    	}
    	// 設定終了
    	if(flag){
    		alert('必須項目に未入力がありました'); // 入力漏れがあれば警告ダイアログを表示
    		return false; // 送信を中止
    	}
    	else{
    		return true; // 送信を実行
    	}
    }
    </script>
</head>
<body>
  <div id="form">
    <p class="form-title">Login</p>
    <p class="form-Description">ユーザー名・パスワード・表示する名前を<br>⼊⼒してください．</p>

    <form action="sign_up_output.php" name="form1" method="POST" onsubmit="return check()">
      <p>User Name</p>
      <p class="userName"><input type="text" name="user" size="30"></p>
      <p>Password</p>
      <p class="pass"><input type="password" name="pass" size="30"></p>
      <p>Display Name</p>
      <p class="displayName"><input type="text" name="name" size="30"></p>
      <p class="submit"><input type="submit" value="登録"></p>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</body>
</html>
