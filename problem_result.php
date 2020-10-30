<!-- これはユーザに画像を提出させる、今の方法
プログラム提出時にネットワークを攻撃される恐れがある
それを防ぐ内側のプログラムを作成するのが時間かかるため
画像を提出させる方法にシフト（problme_result.php）済み -->

<?php
    //前ページで何も受け取ってないとき　　最終的にチェック外す
    // if (!isset($_POST)) {
    //     header('Location: problem_page.php');
    //     exit;
    // } elseif ($_POST === '') {
    //     header('Location: problem_page.php');
    //     exit;
    // }

    require_once __DIR__.'/functions.php'; /* ファイルパスを指定して読み込む */

     //タイムスタンプ
    date_default_timezone_set('Asia/Tokyo'); //日本時間設定
    $timestamp = date('YmdHis'); //年月日時分秒
    // echo $timestamp; //確認用
    // echo '<br />'; //確認用

    session_start();
    /*セッションとは、コンピュータのサーバー側に一時的にデータを保存する仕組み*/
    //前ページの問題IDを受け渡しするためにSESSIONに入れたGET情報を返す（参考：https://wepicks.net/phpref-session/）
    //セッションIDの新規発行、又は、既存のセッションを読み込む
    //前ページ$_SESSIONを読み込む
    // echo $_SESSION['problem_id']; //確認用
    // echo '<br />'; //確認用

    //ユーザの提出した画像を読み込む
    //複数枚（判定＿出力画像）（参考：https://qiita.com/hidepy/items/23ab9bb2c291e912763f）
    //フォーム画面で複数枚選べるようにする（参考：https://webcrehoo.com/56）
    // ファイルがあれば処理実行
    if (isset($_FILES['jud_answer_file'])) {
        // アップロードされたファイル件を処理
        for ($i = 1; $i <= count($_FILES['jud_answer_file']['name']); ++$i) {
            // アップロードされたファイルか検査
            if (is_uploaded_file($_FILES['jud_answer_file']['tmp_name'][$i - 1])) {
                // ファイルをお好みの場所に移動
                $filename = $timestamp.'_'.$i.'.jpg'; //保存ファイル名を変更（参考：https://techacademy.jp/magazine/18804）
                // echo '保存ファイル名：'.$filename.'<br>'; //確認用
                $answer = 'images/problem/problem_'.$_SESSION['problem_id'].'/judgement/output/'.$filename; //保存場所
                // echo '保存場所：'.$answer.'<br>'; //確認用
                move_uploaded_file($_FILES['jud_answer_file']['tmp_name'][$i - 1], $answer);
                // echo 'あなたが提出した画像ファイルは下記の通りです。<br>'; //確認用
                // echo '<img src="'.$answer.'"><br>'; //確認用

                $input = $input.' '.$answer; //画像複数あったらURLを追加していく
                // echo '答え合わせに使う あなたが提出した画像パス名'.$input; //確認用
                // echo '<br />'; //確認用
            }
        }
    }

    //正解画像表示
    //問題一覧から選択した問題の画像取得する
    $dbh = connectDB(); //データベース接続
    $sql = 'SELECT * FROM `image_tb` WHERE `problem_id`='.$_SESSION['problem_id'].' AND `example_judgement`=1 AND `input_output`=1'; //カラム名条件からimage_tbの情報を抽出、``をしないと物が増えた時重くなる！（""はどっちでも）; //getとpostの違い（参考：https://techacademy.jp/magazine/4955）
    $stmt = $dbh->query($sql); // SQLステートメントを実行し、結果を変数に格納 //queryに$sqlを渡す
    foreach ($stmt as $row) { //queryの結果は配列で返ってくるのでforeach配列の中身を一行ずつ出力
        // print_r($row['id'].'：'.$row['img_path']); //確認用
        // print_r('<br>'); //確認用

        //画像表示(参考: https://kamuiblog.com/php-img/)
        // echo '正解画像は下記の通りです。<br>'; //確認用
        // echo '<img src="'.$row['img_path'].'"/>'; //確認用
        // echo '<br />'; //確認用

        $output = $output.' '.$row['img_path']; //画像複数あったらURLを追加していく
        // echo '答え合わせに使う　正解画像パス名'.$output; //確認用
        // echo '<br />'; //確認用
    }

    //ユーザの提出した画像と正解画像を比べて正誤判定を出す

    //ターミナルで画像の差分を比較する
    //ImageMagickを使用（参考：https://higuma.github.io/2016/08/31/imagemagick-1/；https://imagemagick.org/index.php）
    // （参考：https://qiita.com/kwst/items/c40817b3cdf841995257）
    // （参考：https://qiita.com/yoya/items/2021944690bd9c0dafb1）
    // （参考：http://www.imagemagick.org/Usage/compare/#difference）

    //そのままだとphp下だと使えないので使う方法（参考：https://joppot.info/2014/05/05/1307）
    //shell_execとexecの違い（参考：https://takuya-1st.hatenablog.jp/entry/20110719/1311060317）
    // echo exec($exec_cmd, $a);
    // echo '<br />'; //確認用

    $filename2 = $timestamp.'_diff.jpg'; //保存ファイル名を変更（参考：https://techacademy.jp/magazine/18804）
    $diff = 'images/problem/problem_'.$_SESSION['problem_id'].'/judgement/output/'.$filename2;

    // $a = 0; //デフォルト値　数字が増えるほど差がある
    // $exec_cmd0 = 'ls -la';
    // $exec_cmd = 'compare -metric AE '.$input.' '.$output.' '.$diff; //compare -metric [アルゴリズム] [画像1] [画像2] [出力される比較画像]
    // $exec_cmd = 'compare -metric AE img_1.jpg img_2.jpg diff.jpg';
    $exec_cmd = '/usr/local/bin/compare -metric AE '.$input.' '.$output.' '.$diff.' 2>&1'; //compare -metric [アルゴリズム] [画像1] [画像2] [出力される比較画像]

    //表示
    // echo $exec_cmd.'<br>'; //確認用
    //実行
    exec($exec_cmd, $a); //execはターミナル、前文コンパイル分、''は文字列であってコンパイルの区切りではない、コンパイルの区切りは,!

    // //表示
    // echo 'a(配列要素指定)='; //確認用
    // echo $a[0]; //確認用 //(参考：https://www.sejuku.net/blog/26785)
    // echo '<br />'; //確認用

    //正解、不正解のフラグ　（デフォルト）0を正解、1なら不正解
    $_SESSION['flag'] = 1;

    //閾値から正誤判定フラグを出す
    if ($a[0] < 100) { //可変できるようにする
        $_SESSION['flag'] = 0;
    } else {
        $_SESSION['flag'] = 1;
    }

    //データ重くなるので消す　今は確認用画像表示があるので、あとでコメントアウト消す！
    //execはターミナル、rmはけす
    exec('rm '.$input); //ユーザから提出した画像を消す
    exec('rm '.$diff); //差分比較して生成された画像を消す
    //?>

<html>
    <head>
        <title>画像処理チャレンジ</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/table.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
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

        <p><br><br>＜結果＞</p>

        <p>
        <?php
            //実行できた時
            if (isset($a[0])) {
                if ($_SESSION['flag'] == 0) {
                    print_r('正解');
                    echo '<br>';
                } elseif ($_SESSION['flag'] == 1) {
                    print_r('不正解');
                    echo '<br>';
                }
            }
            //なんかエラーが起こる…
            // else {　//NULLのとき
                // print_r('判定不可能');
            // }

            // if (!isset($a[0])) { //NULLのとき
            //     print_r('判定不可能');
            // } else {
            //     if ($_SESSION['evaluation'] == 0) {
            //         $_SESSION['flag'] = 0; //正解
            //     } else {
            //         $_SESSION['flag'] = 1; //不正解
            //     }
            // }

            //表示
            echo '画素のズレ='; //確認用
            echo $a[0]; //確認用 //(参考：https://www.sejuku.net/blog/26785)
            echo '<br />'; //確認用

            //DBにテキストデータを入れる
            if ($dbh) {
                if (isset($a[0])) {
                    if ($_SESSION['flag'] == 0) { //正解のとき
                        // データベースへの問い合わせSQL⽂ (⽂字列) 
                        // （参考：https://www.flatflag.nir87.com/select-932）
                        //
                        $sql_1 = "INSERT INTO `answer_history_tb`( `user_id`, `problem_id`, `right_wrong`) VALUES ('{$_SESSION['id']}','{$_SESSION['problem_id']}',0)";
                        // $sql_1 = "INSERT INTO `problem_tb`( `title`, `sentence`, `hint`) VALUES ('$title','$sentence','$hint')";
                        // echo $sql_1.'<br>'; //確認用
                        //$sth = $dbh->query($sql); //SQLの実⾏
                        $sth_1 = $dbh->query($sql_1); //SQLの実⾏
                        // echo '上記で登録しました<br>'; //確認用
                        // //データの取得（参考？：https://bituse.info/php/37）
                        // $result = $sth->fetchALL(PDO::FETCH_ASSOC);
                    } elseif ($_SESSION['flag'] == 1) { //不正解
                        // データベースへの問い合わせSQL⽂ (⽂字列) 
                        // （参考：https://www.flatflag.nir87.com/select-932）
                        //insertでセッション入れれない…（参考：https://teratail.com/questions/172540）
                        $sql_1 = "INSERT INTO `answer_history_tb`( `user_id`, `problem_id`, `right_wrong`) VALUES ('{$_SESSION['id']}','{$_SESSION['problem_id']}',1)";
                        // echo $sql_1.'<br>'; //確認用
                        //$sth = $dbh->query($sql); //SQLの実⾏
                        $sth_1 = $dbh->query($sql_1); //SQLの実⾏
                        // echo '上記で登録しました<br>'; //確認用
                        // //データの取得（参考？：https://bituse.info/php/37）
                        // $result = $sth->fetchALL(PDO::FETCH_ASSOC);
                    }
                }
            }

        ?>
        </p>

        <?php
            // $dbh = connectDB();
            // $user_id = $_SESSION['id'];
            // $prob_id = $_SESSION['problem_id'];
            // //DBへの接続
            // if ($dbh) {
            //     //データベースへの問い合わせSQL文（文字列）
            //     $sql = 'INSERT INTO `user_Answer_tb`(`user_id`) VALUES ($user_id)';
            //     $sth = $dbh->query($sql); //SQLの実行
            // }
            // $dbh = null;
            // // foreach文で配列の中身を一行ずつ出力
        ?>

        <footer>
        <p>Copyright@AIT_SawanoLab</p>
        <footer>

    </body>
</html>

