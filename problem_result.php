<?php
    //    header( "Location: problem_answer.php" ) ;
    //    exit ;

    require_once __DIR__.'/functions.php'; /* ファイルパスを指定して読み込む */
    $dbh = connectDB(); /* データベース接続 */

    session_start();
    /*セッションとは、コンピュータのサーバー側に一時的にデータを保存する仕組み*/

    //ユーザがproblem.answerで入力したコードをfile.cppにベタ打ち
    //cppファイルを新規作成
    //      ！！！！下は正解コード書き直しのため終わったらコメントアウト外す！！！！
    // $text = $_POST['text']; //入力したテキストを変数textに入れる
    // touch('file.cpp'); //ファイルの最終アクセス時刻および最終更新日をセットする
    // $cpp = fopen('file.cpp', 'w'); //新しいテキストファイルを作って書き込む
    // fwrite($cpp, $text); //入力したテキストをfile.cppに書き込む
    // fclose($cpp);

    //関数
    $a;
    $b;
    $c;
    $d;
    $ev; //0:提出コードが正解//0以外:提出コードが不正解
    $_SESSION['errorFlag'] = 0; //0:提出コードがコンパイル成功//0以外:提出コードがコンパイル失敗
   /* SESSION[‘username’] を取り出してあげれば、中身を取り出すことができます。*/

    //file.cppをコンパイル
    $cpp_src = 'file.cpp'; //タイムスタンプ

    $compile_cmd = 'g++ -std=c++11 '.$cpp_src.' `/usr/local/bin/pkg-config --libs --cflags opencv4` -o aa';
    exec($compile_cmd, $a, $b); //execはターミナル、前文コンパイル文、aとbは出力結果 ''は文字列であってコンパイルの区切りではない、コンパイルの区切りは,!
    /*　参考　https://rikunora2.hatenadiary.org/entry/20100802/1280731016 */

    echo '<pre>';
    var_dump($a);
    echo '</pre>';
    echo '<br />';

    echo 'b='.$b; //0ならコンパイルOK、1ならコンパイルエラー
    echo '<br />';

    //file.cppを実行する
    exec('./aa /Applications/MAMP/htdocs/aitpictures_20/images/problem_1/example/input/img1.jpg /Applications/MAMP/htdocs/aitpictures_20/images/problem_1/example/output/img2.jpg', $c, $d); //execはターミナル、前文コンパイル分、aとbは出力結果 ''は文字列であってコンパイルの区切りではない、コンパイルの区切りは,!

    echo '<pre>';
    var_dump($c);
    echo '</pre>';

    echo 'd='.$d; //0なら実行OK、1なら実行エラー、127は実行ファイルない（コンパイルできていない）
    echo '<br />';

    //実行ファイル./a.outの名前指定バージョンを消さないとエラー起こしても実行できたデータ残っているので消す！
    exec('rm '.$a, $b); //execはターミナル、rmはけす

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
            // if ($_SESSION['flag'] == -1) {
            //     print_r('コンパイルエラー');
            // } elseif ($_SESSION['flag'] == 0) {
            //     print_r('正解');
            // } elseif ($_SESSION['flag'] == 1) {
            //     print_r('不正解');
            // }
        ?>
        </p>
        <?php
//            $dbh=connectDB();
//            //DBへの接続
//            if($dbh){
//                //データベースへの問い合わせSQL文（文字列）
//                $sql = 'SELECT group_name FROM group_tb';
//                $sth = $dbh->query($sql);//SQLの実行
//                //データの取得
//                $result = $sth->fetchALL(PDO::FETCH_ASSOC);
//            }
//            $dbh = null;
//            // foreach文で配列の中身を一行ずつ出力
        ?>
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
