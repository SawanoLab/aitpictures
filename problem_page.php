<!-- これはユーザに画像を提出させる、今の方法
プログラム提出時にネットワークを攻撃される恐れがある
それを防ぐ内側のプログラムを作成するのが時間かかるため
画像を提出させる方法にシフト（problme_page.php）済み -->

<?php
    //セッションスタート
    session_start();
?>

<html>
    <head>
        <title>画像処理チャレンジ</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/contents.css">
        <link rel="stylesheet" href="css/flexible-form.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
    
    </head>

    <body>
        <?php
            // if(!((isset($_SESSION['login'])&&$_SESSION['login'] == 'OK'))){
            //     //ログインフォームへ
            //     header('Location:index.php');
            //     // 終了
            //     exit();
            // }

            //接続用関数の呼び出し
            require_once __DIR__.'/functions.php';

            ?>

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

        <div class="contens">
        <!-- 問題名 -->
        <h3>
        <?php
            //問題一覧から選択した問題を取得する
            $dbh = connectDB(); //データベース接続
            if ($dbh) {
                //データベースへの問い合わせSQL文（文字列）
                $sql = 'SELECT * FROM `problem_tb` WHERE `id`='.$_GET['id'].''; //getとpostの違い（参考：https://techacademy.jp/magazine/4955）
                $sth = $dbh->query($sql); //SQLの実行
            }
            //(本当はPDOのほうがいい？（参考：https://gray-code.com/php/getting-data-by-using-pdo/）)
            // foreach文で配列の中身を一行ずつ出力（参考：https://www.flatflag.nir87.com/select-932）
            foreach ($sth as $row) {
                // データベースのフィールド名で出力
                echo $row['title'];
            }
        ?>
        </h3>

        <!-- 問題文 -->
        <p>
        <?php
            //問題一覧から選択した問題を取得する
            $dbh = connectDB(); //データベース接続
            if ($dbh) {
                //データベースへの問い合わせSQL文（文字列）
                $sql = 'SELECT * FROM `problem_tb` WHERE `id`='.$_GET['id']; //getとpostの違い（参考：https://techacademy.jp/magazine/4955）
                $sth = $dbh->query($sql); //SQLの実行
            }
            //(本当はPDOのほうがいい？（参考：https://gray-code.com/php/getting-data-by-using-pdo/）)
            // foreach文で配列の中身を一行ずつ出力（参考：https://www.flatflag.nir87.com/select-932）
            foreach ($sth as $row) {
                // データベースのフィールド名で出力
                echo $row['sentence'];
            }
        ?>
        </p>

        <!-- 判定＿入力画像 -->
        <p>下記の画像に画像処理をしてください<br>画像は保存してお使いください<br></p>
        <p>
        <?php
            //問題一覧から選択した問題の画像取得する
            $dbh = connectDB(); //データベース接続
            $sql = 'SELECT * FROM `image_tb` WHERE `problem_id`='.$_GET['id'].' AND `example_judgement`=1 AND `input_output`=0'; //カラム名条件からimage_tbの情報を抽出、``をしないと物が増えた時重くなる！（""はどっちでも）; //getとpostの違い（参考：https://techacademy.jp/magazine/4955）
            $stmt = $dbh->query($sql); // SQLステートメントを実行し、結果を変数に格納 //queryに$sqlを渡す
            foreach ($stmt as $row) { //queryの結果は配列で返ってくるのでforeach配列の中身を一行ずつ出力
                // print_r($row['id'].'：'.$row['img_path']); //確認用
                // print_r('<br>'); //確認用

                //画像表示(参考: https://kamuiblog.com/php-img/)
                echo '<img src="'.$row['img_path'].'"/>'; //確認用（画像）
                echo '<br />'; //確認用

                // $input = $input.' '.$row['img_path']; //画像複数あったらURLを追加していく
            }
        ?>
        </p>


        <h3>例</h3>
        <!-- 例題＿入力画像 -->
        <h4>入力画像</h4>
        <p>
        <?php
            //問題一覧から選択した問題の画像取得する
            $dbh = connectDB(); //データベース接続
            $sql = 'SELECT * FROM `image_tb` WHERE `problem_id`='.$_GET['id'].' AND `example_judgement`=0 AND `input_output`=0'; //カラム名条件からimage_tbの情報を抽出、``をしないと物が増えた時重くなる！（""はどっちでも）; //getとpostの違い（参考：https://techacademy.jp/magazine/4955）
            $stmt = $dbh->query($sql); // SQLステートメントを実行し、結果を変数に格納 //queryに$sqlを渡す
            foreach ($stmt as $row) { //queryの結果は配列で返ってくるのでforeach配列の中身を一行ずつ出力
                // print_r($row['id'].'：'.$row['img_path']); //確認用
                // print_r('<br>'); //確認用

                //画像表示(参考: https://kamuiblog.com/php-img/)
                echo '<img src="'.$row['img_path'].'"/>'; //確認用（画像）
                echo '<br />'; //確認用

                // $input = $input.' '.$row['img_path']; //画像複数あったらURLを追加していく
            }
        ?>
        </p>
        
        <!-- 例題＿出力画像 -->
        <h4>出力画像</h4>
        <p>
        <?php
            //問題一覧から選択した問題の画像取得する
            $dbh = connectDB(); //データベース接続
            $sql = 'SELECT * FROM `image_tb` WHERE `problem_id`='.$_GET['id'].' AND `example_judgement`=0 AND `input_output`=1'; //カラム名条件からimage_tbの情報を抽出、``をしないと物が増えた時重くなる！（""はどっちでも）; //getとpostの違い（参考：https://techacademy.jp/magazine/4955）
            $stmt = $dbh->query($sql); // SQLステートメントを実行し、結果を変数に格納 //queryに$sqlを渡す
            foreach ($stmt as $row) { //queryの結果は配列で返ってくるのでforeach配列の中身を一行ずつ出力
                // print_r($row['id'].'：'.$row['img_path']); //確認用
                // print_r('<br>'); //確認用

                //画像表示(参考: https://kamuiblog.com/php-img/)
                echo '<img src="'.$row['img_path'].'"/>'; //確認用（画像）
                echo '<br />'; //確認用

                // $input = $input.' '.$row['img_path']; //画像複数あったらURLを追加していく
            }
        ?>
        </p>

        <!-- ヒント -->
        <h4>ヒント</h4>
        <p>
        <?php
            //問題一覧から選択した問題を取得する
            if ($dbh) {
                //データベースへの問い合わせSQL文（文字列）
                $sql = 'SELECT * FROM `problem_tb` WHERE `id`='.$_GET['id'].''; //getとpostの違い（参考：https://techacademy.jp/magazine/4955）
                $sth = $dbh->query($sql); //SQLの実行
            }
            //(本当はPDOのほうがいい？（参考：https://gray-code.com/php/getting-data-by-using-pdo/）)
            // foreach文で配列の中身を一行ずつ出力（参考：https://www.flatflag.nir87.com/select-932）
            foreach ($sth as $row) {
                // データベースのフィールド名で出力
                echo $row['hint'];
            }
        ?></p>


        <form action="problem_result.php" method="post" name="form1" enctype="multipart/form-data" onSubmit="return check()">
            <h4>解答</h4>
            <p>自分のプログラムから出力された画像を入力してください<br></p>
            <!-- フォーム画面で複数枚選べるようにする（参考：https://webcrehoo.com/56） -->
            <!-- accept="ファイルの種類" -->
            <p>
            <div id="input_pluralBox">
            <div id="input_plural">
            <!-- required ファイル入っているか確認（参考：https://web-designer.cman.jp/html_ref/abc_list/input_file/） -->
                <input type="file" multiple="multiple" name="jud_answer_file[]" accept="image/*" required> 
                <input type="button" value="＋" class="add pluralBtn">
                <input type="button" value="－" class="del pluralBtn">
            </div>
            </div>
            </p>
            <p>
                <input type="submit" value="採点する">
                <!-- <input type="submit" value="reset"> -->
            </p>
        </form>
        </div>
        <?php
        //採点ページで問題IDを受け渡しするためにGET情報をSESSIONに入れる（参考：https://wepicks.net/phpref-session/）
        //セッションデータを初期化
        //セッションIDの新規発行、又は、既存のセッションを読み込む
        //$_SESSIONを読み込む
        session_start();
        //変数をセッションに登録
        $_SESSION['problem_id'] = $_GET['id'];
        // echo $_SESSION['problem_id']; //確認用
        ?>

        <footer>
        <p>Copyright@AIT_SawanoLab</p>
        </footer>

        
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
