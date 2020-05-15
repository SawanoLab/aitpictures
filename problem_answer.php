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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
            // if(!((isset($_SESSION['login'])&&$_SESSION['login'] == 'OK'))){
            //     //ログインフォームへ
            //     header('Location:login.html');
            //     // 終了
            //     exit();
            // }
            // //接続用関数の呼び出し
            // require_once(__DIR__.'/functions.php');
            // $dbh=connectDB();

            // if($dbh){
            //     //データベースへの問い合わせSQL文（文字列）
            //     $sql = 'SELECT * FROM problem_tb WHERE id=' . $_POST['id'] . ';';
            //     $sth = $dbh->query($sql);//SQLの実行
            //     //データの取得
            //     $result = $sth->fetchALL(PDO::FETCH_ASSOC);
            // }
            ?>
        <header>
            <h1>
            <!-- <a href="index_login.php"> -->
            画像処理プログラム判定サイト
            <!-- </a> -->
            </h1>
            <!-- <div id="fixedBox" class="nav">
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
            // foreach文で配列の中身を一行ずつ出力
        ?>

        <div class="contens">
        <h3><br><br>問題1 白黒画像にしよう</h3>
        <p>画像を白黒画像にしよう!</p>

        <!-- <h3><br><br>問題
        <?php
        // echo $result[0]['problemNo'];?> 
        <?php
        // echo $result[0]['title'];
        ?></h3>
        <p><?php
        //  echo $result[0]['sentence'];
         ?></p> -->

        <h3>例</h3>
        <h4>入力画像</h4>
        <p>
        <img src="images/problem_1/example/input/img1.jpg"
        <?php
         //DBへの接続
            //    if($dbh){
        //        //postの情報
        //        $pro_id=1;
        //        $no=1;
        //        $g_id=1;
        //        //データベースへの問い合わせSQL文（文字列）
        //        $sql ='SELECT * FROM problem_info_tb WHERE problem_id='.$pro_id.' AND input_output=0 AND img_or_answer_flag=0 AND No='.$no;
        //        $sth = $dbh->query($sql);//SQLの実行
        //        //データの取得
        //        foreach ($sth as $row){
        //            $url = $row['URL'];
        //        }
        //    }
        //    echo $url;
        ?>
        alt="サンプル画像" width="200" heigth="100">
        <!-- <img src="images/problem_img/group1/problem1/color.jpg" -->
        <?php
        //    $dbh=connectDB();
        //    //DBへの接続
        //    if($dbh){
        //        //postの情報
        //        $pro_id=1;
        //        $no=2;
        //        $g_id=1;
        //        //データベースへの問い合わせSQL文（文字列）
        //        $sql ='SELECT * FROM problem_info_tb WHERE problem_id='.$pro_id.' AND input_output=0 AND img_or_answer_flag=0 AND No='.$no;
        //        $sth = $dbh->query($sql);//SQLの実行
        //        //データの取得
        //        foreach ($sth as $row){
        //            $url = $row['URL'];
        //        }
        //    }
        //    echo "images/problem_img/group1/problem1/img1.jpg";
        ?>
<!-- alt="サンプル画像" width="200" heigth="100" hspace="20"> -->
<!-- </p> -->

        <h4>出力画像</h4>
        <p>
        <img src="images/problem_1/example/output/img1.jpg"
        <?php
        //    $dbh=connectDB();
        //    //DBへの接続
        //    if($dbh){
        //        //postの情報
        //        $_SESSION['problem_id']=1;
        //        $pro_id=1;
        //        $no=1;
        //        $g_id=1;
        //        //データベースへの問い合わせSQL文（文字列）
        //        $sql ='SELECT * FROM problem_info_tb WHERE problem_id='.$pro_id.' AND input_output=1 AND img_or_answer_flag=0 AND No='.$no;
        //        $sth = $dbh->query($sql);//SQLの実行
        //        //データの取得
        //        foreach ($sth as $row){
        //            $url = $row['URL'];
        //        }
        //    }
        //    echo $url;
        ?>
        alt="サンプル画像" width="200" height="150">
        </p>

        <h4>ヒント</h4>
        <p>cv::cvtColor(sourceImage, grayImage, cv::COLOR_BGR2GRAY);</p>


        <form action="problem_result.php" method="post" name="form1" enctype="multipart/form-data">
            <h4>解答</h4>
            <textarea  cols="70" rows="20" name="text"></textarea>
            <p>
                <input type="submit" value="採点する">
                <!-- <input type="submit" value="reset"> -->
            </p>
        </form>
        </div>

        <footer>
        <p>Copyright@AIT_SawanoLab</p>
        <footer>

    </body>
</html>
