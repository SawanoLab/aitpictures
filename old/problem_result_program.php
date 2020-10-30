<!-- これはユーザにプログラムを提出させる、過去の方法
プログラム提出時にネットワークを攻撃される恐れがある
それを防ぐ内側のプログラムを作成するのが時間かかるため
画像を提出させる方法にシフト（problme_result.php）済み -->

<?php
    //前ページでユーザがコードを入力してない場合　　最終的にチェック外す
    // if (!isset($_POST['text'])) {
    //     header('Location: problem_page.php');
    //     exit;
    // } elseif ($_POST['text'] === '') {
    //     header('Location: problem_page.php');
    //     exit;
    // }

    require_once __DIR__.'/functions.php'; /* ファイルパスを指定して読み込む */

     //タイムスタンプ
    date_default_timezone_set('Asia/Tokyo'); //日本時間設定
    $timestamp = date('YmdHis'); //年月日時分秒
    echo $timestamp; //確認用

    //ユーザがproblem.answerで入力したコードをタイムスタンプ.cppにベタ打ち
    //$cpp_file = 'file.cpp'; //確認用_前ページ入力しないcpp
    //cppファイルを新規作成
    $cpp_file = $timestamp.'.cpp';
    $text = $_POST['text']; //入力したテキストを変数textに入れる
    touch($cpp_file); //ファイルがなければ新規作成、ファイルの最終アクセス時刻および最終更新日をセットする
    $cpp = fopen($cpp_file, 'w'); //新しいテキストファイルを作って書き込む
    fwrite($cpp, $text); //入力したテキストをfile.cppに書き込む
    fclose($cpp);

    //file.cppをコンパイル
    $a; //コンパイル時の出力結果
    $b; //0ならコンパイルOK、1ならコンパイルエラー
    $compile_cmd = 'g++ -std=c++11 '.$cpp_file.' `/usr/local/bin/pkg-config --libs --cflags opencv4` -o '.$timestamp;
    exec($compile_cmd, $a, $b); //execはターミナル、前文コンパイル文、aとbは出力結果 ''は文字列であってコンパイルの区切りではない、コンパイルの区切りは,!
    /*　参考　https://rikunora2.hatenadiary.org/entry/20100802/1280731016 */

    echo '<pre>'; //確認用
    var_dump($a); //確認用
    echo '</pre>'; //確認用
    echo '<br />'; //確認用

    echo 'b='.$b; //確認用
    echo '<br />'; //確認用

    //file.cppを実行する
    //画像を取得する
    session_start();
    /*セッションとは、コンピュータのサーバー側に一時的にデータを保存する仕組み*/
    //前ページの問題IDを受け渡しするためにSESSIONに入れたGET情報を返す（参考：https://wepicks.net/phpref-session/）
    //セッションIDの新規発行、又は、既存のセッションを読み込む
    //前ページ$_SESSIONを読み込む
    echo $_SESSION['problem_id']; //確認用
    echo '<br />'; //確認用

    if ($b == 0) { //コンパイルできて実行ファイル作成できた時
        //問題一覧から選択した問題の画像取得する
        $dbh = connectDB(); //データベース接続
        $sql = 'SELECT * FROM `image_tb` WHERE `problem_id`='.$_SESSION['problem_id'].' AND `example_judgement`=1 AND `input_output`=0'; //カラム名条件からimage_tbの情報を抽出、``をしないと物が増えた時重くなる！（""はどっちでも）; //getとpostの違い（参考：https://techacademy.jp/magazine/4955）
        $stmt = $dbh->query($sql); // SQLステートメントを実行し、結果を変数に格納 //queryに$sqlを渡す
        foreach ($stmt as $row) { //queryの結果は配列で返ってくるのでforeach配列の中身を一行ずつ出力
            // print_r($row['id'].'：'.$row['img_path']); //確認用
            // print_r('<br>'); //確認用

            //画像表示(参考: https://kamuiblog.com/php-img/)
            // echo '<img src="'.$row['img_path'].'"/>'; //確認用（画像）
            // echo '<br />'; //確認用

            $input = $input.' '.$row['img_path']; //入力画像 //画像複数あったらURLを追加していく
            echo $input; //確認用
            print_r('<br>'); //確認用
        }

        $c; //実行時の出力結果
        $d; //0なら実行OK、1なら実行エラー、127は実行ファイルない（コンパイルできていない）
        $output = 'images/problem/problem_'.$_SESSION['problem_id'].'/judgement/output/'.$timestamp.'.jpg'; //出力画像
        $exec_cmd = './'.$timestamp.' '.$input.' '.$output;
        // $exec_cmd = './'.$timestamp.' /Applications/MAMP/htdocs/aitpictures_20/images/problem_1/judgement/input/img1.jpg /Applications/MAMP/htdocs/aitpictures_20/images/problem_1/judgement/output/'.$timestamp.'.jpg';
        exec($exec_cmd, $c, $d); //execはターミナル、前文コンパイル分、aとbは出力結果 ''は文字列であってコンパイルの区切りではない、コンパイルの区切りは,!

        echo '<pre>'; //確認用
        var_dump($c); //確認用
        echo '</pre>'; //確認用

        echo 'd='.$d; //確認用
        echo '<br />'; //確認用
    }

    //出力画像と正解画像を比べて正誤判定を出す

    //正解、不正解のフラグ　（デフォルト）0を正解、1なら不正解
    $_SESSION['flag'] = 0;

    //画素を比較するcppファイル

    /////////////////////////////////////////

    //実行ファイル./a.outの名前指定バージョンを消さないとエラー起こしても実行できたデータ残っているので消す！
    //execはターミナル、rmはけす
    exec('rm '.$timestamp); //実行ファイルを消す
    exec('rm '.$cpp_file); //ユーザが入力したコードファイルを消す
    exec('rm '.$output); //コードファイルから出力された画像を消す

    ?>

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
            <!-- <h1><a href="index_login.php">画像処理プログラム判定サイト</a></h1>

            <div id="fixedBox" class="nav">
                <ul id="itemMenu">
                <li><a href="issue_public.php">公開問題</a></li>
                <li><a href="create.php">新規作成</a></li>
                <li><a href="mypage.php">マイページ</a></li>
                </ul>

                <ul id="LoginTop">
                <li id="quickstart-sign-in"><a href="logout.php">ログアウト</a></li>
                </ul>
            </div> -->
        </header>

        <p><br><br>＜結果＞</p>

        <p>
        <?php
            //ユーザのコードをコンパイルできてないとき
            if ($d == 127) {
                print_r('コンパイルエラー');

                return;

            //ユーザのコードをコンパイルできたとき
            //実行できない時
            } elseif ($d == 1) {
                print_r('実行できません。画像部分はargv[1],argv[2]...にしてください。');

                return;
            //実行できた時
            } elseif ($d == 0) {
                if ($_SESSION['flag'] == 0) {
                    print_r('正解');
                } elseif ($_SESSION['flag'] == 1) {
                    print_r('不正解');
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
