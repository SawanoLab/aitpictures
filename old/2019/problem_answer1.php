<html>
    <head>
        <title>画像処理版AOJ</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/contents.css">
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
              $sql = 'SELECT * FROM problem_tb WHERE id=' . $_POST['id'] . ';';
              $sth = $dbh->query($sql);//SQLの実行
              //データの取得
              $result = $sth->fetchALL(PDO::FETCH_ASSOC);
            }
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
                </ul>
            </div>
        </div>
        <!-- <h3><br><br>問題1 白黒画像にしよう</h3> -->
        <!-- <p>この画像を白黒画像にしよう!</p> -->
        <div class="contents">
        <br>
        <h3><br><br><?php echo $result[0]['title']; ?><?php echo $result[0]['title']; ?></h3>
        <p><?php echo $result[0]['sentence']; ?></p>
        <h4>入力画像</h4>
        <?php
        $title = htmlspecialchars($_POST['id'], ENT_QUOTES);

         ?>
        <p>
            <img src="images/problem_img/group1/problem1/sample.jpg" alt="サンプル画像" width="200" heigth="100">
            <img src="images/problem_img/group1/problem1/sample.jpg" alt="サンプル画像" width="200" heigth="100" hspace="20">
        </p>
        <h4>出力画像</h4>
        <p>
            <img src="images/problem_img/group1/problem1/sample_black.jpg" alt="サンプル画像" width="200" height="150">
        </p>
        <h4>ヒント</h4>
        <!-- <p>白色は(255,255,255) 黒色は(0,0,0)</p> -->
        <p><?php echo $result[0]['hint']; ?></p>
        <form action="compile.php" method="post" name="form1" enctype="multipart/form-data">
            <h4>解答</h4>
            <textarea  cols="70" rows="20"></textarea>
            <p center>
                <input type="submit" value="採点する">
                <input type="submit" value="reset">
            </p>
        </form>
      </div>
        <div class="footer">
            <p>Copyright@AIT_SawanoLab</p>
        </div>
    </body>
