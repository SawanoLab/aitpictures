<html>
<head>
  <meta http-equiv="content-type" content="text/html;" charset="utf-8">
  <title>formsample</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
  <script type="text/javascript">
    function check(){
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
  <div id="form">
    <p class="form-title">Login</p>
    <p class="form-Description">未入力項目があります．<br>ユーザー名・パスワード・表示する名前を<br>⼊⼒してください．</p>
    <form action="sign_up_output.php" method="POST" onsubmit="return check()">
      <p>User Name</p>
      <p class="userName"><input type="text" name="user" size="30"></p>
      <p>Password</p>
      <p class="pass"><input type="password" name="pass" size="30"></p>
      <p>Display Name</p>
      <p class="displayName"><input type="text" name="name" size="30"></p>
      <p class="submit"><input type="submit" value="登録"></p>
    </form>
</div>
</body>
</html>
