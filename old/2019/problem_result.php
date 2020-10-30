<?php
    //    header( "Location: problem_answer.php" ) ;
    //    exit ;

    require_once __DIR__.'/functions.php'; /* ファイルパスを指定して読み込む */
    $dbh = connectDB(); /* データベース接続 */

    session_start();
 /*セッションとは、コンピュータのサーバー側に一時的にデータを保存する仕組み*/

    //cppファイルを新規作成 file.cppは解答したコードを受け取ってベタ打ちで記入する

    //      ！！！！下は正解コード書き直しのため終わったらコメントアウト外す！！！！
    // $text = $_POST['text']; /*入力したテキストを変数textに入れる*/
    // touch('file.cpp'); /*ファイルの最終アクセス時刻および最終更新日をセットする*/
    // $cpp = fopen('file.cpp', 'w'); /*新しいテキストファイルを作って書き込む*/
    // fwrite($cpp, $text); /*入力したテキストをfile.cppに書き込む*/
    // fclose($cpp);

    $a; //a.outの標準出力を保存
        //画像の枚数（複数対応させるため）?　だから文字列の配列（から個数が目視でわかる）
        //提出コードのコンパイル後の画像と、正解画像のパス名が入る
    $b = 0; //0:提出コードのコンパイルが成功//0以外:提出コードのコンパイルが失敗
    $c; //0:evaluation.cppのコンパイルが成功//0以外:evaluation.cppのコンパイルが失敗
    $ev; //0:提出コードが正解//0以外:提出コードが不正解
    $_SESSION['errorFlag'] = 0; //0:提出コードがコンパイル成功//0以外:提出コードがコンパイル失敗
   /* SESSION[‘username’] を取り出してあげれば、中身を取り出すことができます。*/

    //提出コードをコンパイル

    $cpp_src = 'file.cpp';
    $compile_cmd = 'g++ -std=c++11 '.$cpp_src.' `/usr/local/bin/pkg-config --libs --cflags opencv4`';
    exec($comple_cmd, $a, $b); //execはターミナル、前文コンパイル文、aとbは出力結果 ''は文字列であってコンパイルの区切りではない、コンパイルの区切りは,!

    /*string exec ( string $command [, array &$output [, int &$return_var ]] )
    引数
    $command    実行するコマンドを指定します。
    &$output    変数を指定した場合、コマンドの出力結果を行ごとに配列に格納します。
    &$return_var    変数を指定した場合、コマンドのステータスが格納されます。
    コマンド実行の成功時には「0」、コマンド実行の失敗時には「1」が格納されます。
    返り値
    コマンド実行結果の最後の行を返します。*/
    /*　参考　https://rikunora2.hatenadiary.org/entry/20100802/1280731016 */
    //    print_r($b); //0ならコンパイル成功
    //    echo "\n";

    //提出コードを実行
    if ($b == 0) { /*コマンドのステータス,成功時には「0」*/
        //実行用のinput画像を取得
        $inputs = '';
        //データの取得(入力，画像)　/*DBはアカウントと問題の読み込みに使われる！*/
        $sql = 'SELECT * FROM problem_info_tb WHERE problem_id=1 AND input_output=0 AND img_or_answer_flag=0';
        /*カラム名条件からproblem_info_tbの情報を抽出 */
        $sth = $dbh->query($sql); //SQLの実行
        /* queryに$sqlを渡す */
        foreach ($sth as $row) { /*↓queryの結果は配列で返ってくるのでforeachで取り出す */
            //            print_r($row['id'].':'.$row['URL']);
            //            print_r("<br>");
            $inputs = $inputs.' '.$row['URL']; //URL-画像パス名
            /* 複数あったらURLを追加していく　*/
        }
        echo "\n";
        /* https://www.sejuku.net/blog/72118 */

        //echo "compile success!\n";
        exec('./a.out'.$inputs); //execはターミナル、前文コンパイル分、aとbは出力結果 ''は文字列であってコンパイルの区切りではない、コンパイルの区切りは,!
        //a.out のあとに文字列入れると実行するcppファイルに変数として使える
//                print_r($inputs);
//                print_r("<br>");
    }

    if ($b == 0) {
        //evaluation.cppをコンパイル
        exec('g++ -std=c++11 evaluation.cpp `/usr/local/bin/pkg-config --libs --cflags opencv4`', $a, $c);

//        print_r($a[0]);
//        print_r("<br>");
//        print_r($a[1]);
//        print_r("<br>");
//        print_r($c); //0ならコンパイル成功
//        print_r("<br>");

        //お手本の取得(出力，画像)
        //        $teacher="";
        //        $sql ='SELECT * FROM problem_info_tb WHERE problem_id=1 AND input_output=1 AND img_or_answer_flag=0';
        //        $sth = $dbh->query($sql);//SQLの実行
        //        foreach ($sth as $row){
        //            print_r($row['id'].':'.$row['URL']);
        //            print_r("<br>");
        //            $teacher = $teacher." ".$row['URL'];
        //        }

        //evaluation.cppを実行
        exec('./a.out '.$a[0].' '.$a[1]); //execはターミナル、''は文字列であってコンパイルの区切りではない、コンパイルの区切りは,!
        //exec("./a.out", $ev, $c);
//                print_r("abs:".$ev[0]); //画素値合計を表示

        //        exec("./a.out".$inputs, $ev, $c);
        //        print_r("abs:".$ev[0]); //画素値合計を表示

        echo "\n";
    //        print_r($c); //0なら実行成功
        //        echo "\n";
    } else { //そもそもfile.cppがコンパイルできない時、evaluation.cppはそもそもシステムで動くはずだから確かめてない
        $_SESSION['errorFlag'] = 1; //コンパイルエラーのフラグを立てる
        //        echo "compile error!\n";
        //        print_r($_SESSION['errorFlag']);
        //        echo "\n";
    }

    //セッションに結果を代入(0なら正解)
    if ($b == 0) {
        $num = intval($ev[0]); //文字列を数値に変換
        $_SESSION['evaluation'] = $ev[0];
        //        echo "evaluation:";
        //        echo $_SESSION['evaluation'];
        //        echo "\n";
        //出力画像，テキストを消去
        exec('rm '.$a[0].' '.$a[1].' '.$a[2].' '.$a[3], $a, $b); //execはターミナル、rmはけす
        //        print_r($b); //0なら実行成功
        //        echo "\n";
    }

    echo "\n";

    //結果表示
    $_SESSION['flag'] = -1;
    if ($_SESSION['errorFlag'] != 0) {
        $_SESSION['flag'] = -1; //コンパイルエラー
    } else {
        if ($_SESSION['evaluation'] == 0) {
            $_SESSION['flag'] = 0; //正解
        } else {
            $_SESSION['flag'] = 1; //不正解
        }
    }

//    if($_SESSION['flag'] == -1){
//        print_r("compile error!!");
//    }else if($_SESSION['flag'] == 0){
//        print_r("Nice Answer!!");
//    }else if($_SESSION['flag'] == 1){
//        print_r("Bad Answer...");
//    }

    ?>

<html>
    <head>
        <title>画像処理版AOJ</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/table.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>

        <div class="header">
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
        </div>

        <p><br><br>＜結果＞</p>
        <p>
        <?php
            if ($_SESSION['flag'] == -1) {
                print_r('コンパイルエラー');
            } elseif ($_SESSION['flag'] == 0) {
                print_r('正解');
            } elseif ($_SESSION['flag'] == 1) {
                print_r('不正解');
            }
            ?>
        </p>
//        <?php
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
//?>
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

        <!-- <div class="footer">
            <p>Copyright@AIT_SawanoLab</p>
        </div> -->
    </body>
</html>
