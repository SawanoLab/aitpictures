<?php
//セッションとは（参考：https://wepicks.net/phpref-session/）
//セッションデータを初期化
//セッションIDの新規発行、又は、既存のセッションを読み込む
//セッションのスタート
session_start(); //セッション変数　他のphpファイルで使うため
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
<?php
//requireとrequire_onceの違い(URL:https://zeropuro.com/blog/?p=322)
    require_once __DIR__.'/functions.php';
    $dbh = connectDB();

    //何も受け取ってないとき　問題登録フォームへ返す　最終的にチェック外す
    if (!isset($_POST)) {
        header('Location: form_setting.php');
        exit;
    } elseif ($_POST === '') {
        header('Location: form_setting.php');
        exit;
    }

    //problem_tbにテキストを保存する
    //受け取ったものを変数に入れる
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
    echo '題名は　'.$title.'<br>'; //確認用
    $sentence = htmlspecialchars($_POST['sentence'], ENT_QUOTES);
    echo '問題文は　'.$sentence.'<br>'; //確認用
    $output_text = htmlspecialchars($_POST['output_text'], ENT_QUOTES);
    echo '文字の正答は　'.$output_text.'<br>'; //確認用
    $hint = htmlspecialchars($_POST['hint'], ENT_QUOTES);
    echo 'ヒントは　'.$hint.'<br>'; //確認用

    //DBにテキストデータを入れる
    if ($dbh) {
        // データベースへの問い合わせSQL⽂ (⽂字列) 
        // （参考：https://www.flatflag.nir87.com/select-932）
        $sql_1 = "INSERT INTO `problem_tb`( `title`, `sentence`, `hint`) VALUES ('$title','$sentence','$hint')";
        // echo $sql_1.'<br>'; //確認用
        //$sth = $dbh->query($sql); //SQLの実⾏
        $sth_1 = $dbh->query($sql_1); //SQLの実⾏
        echo '上記で登録しました<br>'; //確認用
        //データの取得（参考？：https://bituse.info/php/37）
        // $result = $sth->fetchALL(PDO::FETCH_ASSOC);　//消さないとこれより下読み込まない
    }

    //img_tb、ディレクトリに画像を保存する
    //直前にインサートしたidを取得（image_tbのproblem_id = problem_tbのid）（参考：https://gray-code.com/php/getting-id-of-last-inserted-data-by-pdo/）
    $problem_id = $dbh->lastInsertId();
    echo '問題idは'.$problem_id.'です。<br>'; //確認用

    //解答履歴、解答画面で問題IDを受け渡しするためにGET情報をSESSIONに入れる
    //変数をセッションに登録
    //セッションにimage_tbのproblem_id(=problem_tbのid)を保存する
    $_SESSION['problem_id'] = $_GET['id'];
    // echo $_SESSION['problem_id']; //確認用

    //問題ごとにファイルを分けるため新規ファイル作成をする（参考：https://gray-code.com/php/make-the-directory/）
    // 親ディレクトリへのパス
    $path1 = './images/problem/';
    // 作成するディレクトリ名
    $dir_name1 = 'problem_'.$problem_id.'';
    // 親ディレクトリが書き込み可能か、および同じ名前のディレクトリが存在しないか確認
    if (is_writable($path1) && !file_exists($path1.$dir_name1)) {
        // ディレクトリを作成
        if (mkdir($path1.$dir_name1)) {
            echo '「problem_問題ID」ディレクトリを作成しました。<br>';
        } else {
            echo '「problem_問題ID」ディレクトリの作成に失敗しました。<br>';
        }
    } else {
        echo '「problem_問題ID」は親ディレクトリが書き込みを許可していないか、すでに同名のディレクトリがあり作成できませんでした。<br>';
    }
    // 親ディレクトリへのパス
    $path2 = 'images/problem/problem_'.$problem_id;
    // 作成するディレクトリ名
    $dir_name2 = '/example';
    $dir_name3 = '/judgement';
    // 親ディレクトリが書き込み可能か、および同じ名前のディレクトリが存在しないか確認
    if (is_writable($path2) && !file_exists($path2.$dir_name2)) {
        // ディレクトリを作成
        if (mkdir($path2.$dir_name2)) {
            echo '「example」ディレクトリを作成しました。<br>';
        } else {
            echo '「example」」ディレクトリの作成に失敗しました。<br>';
        }
    } else {
        echo '「example」は親ディレクトリが書き込みを許可していないか、すでに同名のディレクトリがあり作成できませんでした。<br>';
    }
    // 親ディレクトリが書き込み可能か、および同じ名前のディレクトリが存在しないか確認
    if (is_writable($path2) && !file_exists($path2.$dir_name3)) {
        // ディレクトリを作成
        if (mkdir($path2.$dir_name3)) {
            echo '「judgement」ディレクトリを作成しました。<br>';
        } else {
            echo '「judgement」」ディレクトリの作成に失敗しました。<br>';
        }
    } else {
        echo '「judgement」は親ディレクトリが書き込みを許可していないか、すでに同名のディレクトリがあり作成できませんでした。<br>';
    }
    // 親ディレクトリへのパス
    $path3 = 'images/problem/problem_'.$problem_id.'/example';
    // 作成するディレクトリ名
    $dir_name4 = '/input';
    $dir_name5 = '/output';
    // 親ディレクトリが書き込み可能か、および同じ名前のディレクトリが存在しないか確認
    if (is_writable($path3) && !file_exists($path3.$dir_name4)) {
        // ディレクトリを作成
        if (mkdir($path3.$dir_name4)) {
            echo 'exampleの中に「input」ディレクトリを作成しました。<br>';
        } else {
            echo 'exampleの中に「input」ディレクトリの作成に失敗しました。<br>';
        }
    } else {
        echo 'exampleの中に「input」は親ディレクトリが書き込みを許可していないか、すでに同名のディレクトリがあり作成できませんでした。<br>';
    }
    if (is_writable($path3) && !file_exists($path3.$dir_name5)) {
        // ディレクトリを作成
        if (mkdir($path3.$dir_name5)) {
            echo 'exampleの中に「output」ディレクトリを作成しました。<br>';
        } else {
            echo 'exampleの中に「output」ディレクトリの作成に失敗しました。<br>';
        }
    } else {
        echo 'exampleの中に「output」は親ディレクトリが書き込みを許可していないか、すでに同名のディレクトリがあり作成できませんでした。<br>';
    }
    // 親ディレクトリへのパス
    $path4 = 'images/problem/problem_'.$problem_id.'/judgement';
    // 作成するディレクトリ名 //上のをそのまま活用
    // $dir_name4 = 'input';
    // $dir_name5 = 'output';
    // 親ディレクトリが書き込み可能か、および同じ名前のディレクトリが存在しないか確認
    if (is_writable($path4) && !file_exists($path4.$dir_name4)) {
        // ディレクトリを作成
        if (mkdir($path4.$dir_name4)) {
            echo 'judgementの中に「input」ディレクトリを作成しました。<br>';
        } else {
            echo 'judgementの中に「input」ディレクトリの作成に失敗しました。<br>';
        }
    } else {
        echo 'judgementの中に「input」は親ディレクトリが書き込みを許可していないか、すでに同名のディレクトリがあり作成できませんでした。<br>';
    }
    if (is_writable($path4) && !file_exists($path4.$dir_name5)) {
        // ディレクトリを作成
        if (mkdir($path4.$dir_name5)) {
            echo 'judgementの中に「output」ディレクトリを作成しました。<br><br>';
        } else {
            echo 'judgementの中に「output」ディレクトリの作成に失敗しました。<br><br>';
        }
    } else {
        echo 'judgementの中に「output」は親ディレクトリが書き込みを許可していないか、すでに同名のディレクトリがあり作成できませんでした。<br><br>';
    }

    // //個別設定（例題＿入力画像）
    // //受け取ったものをディレクトリに保存する（参考：https://gray-code.com/php/save-the-upload-file/）
    // if (!empty($_FILES['ex_input_file']['tmp_name']) && is_uploaded_file($_FILES['ex_input_file']['tmp_name'])) {
    //     //画像を指定したパスへ保存する
    //     //[‘tmp_name’]は一時フォルダに保存されているそのファイルまでのパス（参考：https://techacademy.jp/magazine/18804）
    //     // //name=受け取ったものの名前をそのまま使う(参考：https://qiita.com/okdyy75/items/669dd51b432ee2c1dfbc)
    //     // move_uploaded_file($_FILES['ex_input_file']['tmp_name'], './images/problem/problem_'.$problem_id.'/example/input/'.$_FILES['ex_input_file']['name']);
    //     //if (move_uploaded_file($val, $path3.$dir_name4.'/image_1.jpg')) {
    //     if (move_uploaded_file($_FILES['ex_input_file']['tmp_name'], $path3.$dir_name4.'/image_1.jpg')) {
    //         echo '例題＿入力画像でアップロードされたファイルを保存しました。<br>';
    //         echo '<img src="'.$path3.$dir_name4.'/image_1.jpg"><br>'; //確認用
    //         //DBにテキストデータを入れる
    //         if ($dbh) {
    //             // データベースへの問い合わせSQL⽂ (⽂字列) 
    //             $sql_2 = "INSERT INTO `image_tb`(`problem_id`, `img_path`, `example_judgement`, `input_output`) VALUES ('$problem_id','$path3$dir_name4/image_1.jpg','0','0')";
    //             echo $sql_2.'<br>'; //確認用
    //             //$sth = $dbh->query($sql); -> SQLの実⾏
    //             $sth_2 = $dbh->query($sql_2);
    //         }
    //     } else {
    //         echo '例題＿入力画像でアップロードされたファイルの保存に失敗しました。<br>';
    //     }
    // }
    //複数枚（例題＿入力画像）　ほんとは上のコメントアウトしてるものの判定処理をしたい（参考：https://qiita.com/hidepy/items/23ab9bb2c291e912763f）
    //フォーム画面で複数枚選べるようにする（参考：https://webcrehoo.com/56）
    // ファイルがあれば処理実行
    if (isset($_FILES['ex_input_file'])) {
        // アップロードされたファイルを処理
        for ($i = 1; $i <= count($_FILES['ex_input_file']['name']); ++$i) {
            // アップロードされたファイルか検査
            if (is_uploaded_file($_FILES['ex_input_file']['tmp_name'][$i - 1])) {
                // ファイルをお好みの場所に移動
                $filename = 'img'.$i.'.jpg'; //保存ファイル名を変更（参考￥：https://techacademy.jp/magazine/18804）
                echo '保存ファイル名：'.$filename.'<br>';
                move_uploaded_file($_FILES['ex_input_file']['tmp_name'][$i - 1], $path3.$dir_name4.'/'.$filename);
                echo '例題＿入力画像でアップロードされたファイルを保存しました。<br>';
                echo '<img src="'.$path3.$dir_name4.'/'.$filename.'"><br>'; //確認用
                //DBにテキストデータを入れる
                if ($dbh) {
                    // データベースへの問い合わせSQL⽂ (⽂字列) 
                    $sql_2 = "INSERT INTO `image_tb`(`problem_id`, `img_path`, `example_judgement`, `input_output`) VALUES ('$problem_id','$path3$dir_name4/img$i.jpg','0','0')";
                    // echo $sql_2.'<br><br>'; //確認用
                    //$sth = $dbh->query($sql); -> SQLの実⾏
                    $sth_2 = $dbh->query($sql_2);
                }
            }
        }
    }

    // //個別設定（例題＿出力画像）
    // //受け取ったものをディレクトリに保存する（参考：https://gray-code.com/php/save-the-upload-file/）
    // if (!empty($_FILES['ex_output_file']['tmp_name']) && is_uploaded_file($_FILES['ex_output_file']['tmp_name'])) {
    //     //画像を指定したパスへ保存する
    //     //[‘tmp_name’]は一時フォルダに保存されているそのファイルまでのパス（参考：https://techacademy.jp/magazine/18804）
    //     // //name=受け取ったものの名前をそのまま使う(参考：https://qiita.com/okdyy75/items/669dd51b432ee2c1dfbc)
    //     // move_uploaded_file($_FILES['ex_output_file']['tmp_name'], './images/problem/problem_'.$problem_id.'/example/input/'.$_FILES['ex_output_file']['name']);
    //     if (move_uploaded_file($_FILES['ex_output_file']['tmp_name'], $path3.$dir_name5.'/image_1.jpg')) {
    //         echo '例題＿出力画像でアップロードされたファイルを保存しました。<br>';
    //         echo '<img src="'.$path3.$dir_name5.'/image_1.jpg"><br>'; //確認用
    //         //DBにテキストデータを入れる
    //         if ($dbh) {
    //             // データベースへの問い合わせSQL⽂ (⽂字列) 
    //             $sql_2 = "INSERT INTO `image_tb`(`problem_id`, `img_path`, `example_judgement`, `input_output`) VALUES ('$problem_id','$path3$dir_name5/image_1.jpg','0','1')";
    //             echo $sql_2.'<br>'; //確認用
    //             //$sth = $dbh->query($sql); -> SQLの実⾏
    //             $sth_2 = $dbh->query($sql_2);
    //         }
    //     } else {
    //         echo '例題＿出力画像でアップロードされたファイルの保存に失敗しました。<br>';
    //     }
    // }
    //複数枚（例題＿出力画像）　ほんとは上のコメントアウトしてるものの判定処理をしたい（参考：https://qiita.com/hidepy/items/23ab9bb2c291e912763f）
    //フォーム画面で複数枚選べるようにする（参考：https://webcrehoo.com/56）
    // ファイルがあれば処理実行
    if (isset($_FILES['ex_output_file'])) {
        // アップロードされたファイル件を処理
        for ($i = 1; $i <= count($_FILES['ex_output_file']['name']); ++$i) {
            // アップロードされたファイルか検査
            if (is_uploaded_file($_FILES['ex_output_file']['tmp_name'][$i - 1])) {
                // ファイルをお好みの場所に移動
                $filename1 = 'img'.$i.'.jpg'; //保存ファイル名を変更（参考￥：https://techacademy.jp/magazine/18804）
                echo '保存ファイル名：'.$filename1.'<br>';
                move_uploaded_file($_FILES['ex_output_file']['tmp_name'][$i - 1], $path3.$dir_name5.'/'.$filename1);
                echo '例題＿出力画像でアップロードされたファイルを保存しました。<br>';
                echo '<img src="'.$path3.$dir_name5.'/'.$filename1.'"><br>'; //確認用
                //DBにテキストデータを入れる
                if ($dbh) {
                    // データベースへの問い合わせSQL⽂ (⽂字列) 
                    $sql_2 = "INSERT INTO `image_tb`(`problem_id`, `img_path`, `example_judgement`, `input_output`) VALUES ('$problem_id','$path3$dir_name5/img$i.jpg','0','1')";
                    // echo $sql_2.'<br><br>'; //確認用
                    //$sth = $dbh->query($sql); -> SQLの実⾏
                    $sth_2 = $dbh->query($sql_2);
                }
            }
        }
    }

    // //個別設定（判定＿入力画像）
    // //受け取ったものをディレクトリに保存する（参考：https://gray-code.com/php/save-the-upload-file/）
    // if (!empty($_FILES['jud_input_file']['tmp_name']) && is_uploaded_file($_FILES['jud_input_file']['tmp_name'])) {
    //     //画像を指定したパスへ保存する
    //     //[‘tmp_name’]は一時フォルダに保存されているそのファイルまでのパス（参考：https://techacademy.jp/magazine/18804）
    //     // //name=受け取ったものの名前をそのまま使う(参考：https://qiita.com/okdyy75/items/669dd51b432ee2c1dfbc)
    //     // move_uploaded_file($_FILES['jud_input_file']['tmp_name'], './images/problem/problem_'.$problem_id.'/example/input/'.$_FILES['jud_input_file']['name']);
    //     if (move_uploaded_file($_FILES['jud_input_file']['tmp_name'], $path4.$dir_name4.'/image_1.jpg')) {
    //         echo '判定＿入力画像でアップロードされたファイルを保存しました。<br>';
    //         echo '<img src="'.$path4.$dir_name4.'/image_1.jpg"><br>'; //確認用
    //         //DBにテキストデータを入れる
    //         if ($dbh) {
    //             // データベースへの問い合わせSQL⽂ (⽂字列) 
    //             $sql_2 = "INSERT INTO `image_tb`(`problem_id`, `img_path`, `example_judgement`, `input_output`) VALUES ('$problem_id','$path4$dir_name4/image_1.jpg','1','0')";
    //             echo $sql_2.'<br>'; //確認用
    //             //$sth = $dbh->query($sql); -> SQLの実⾏
    //             $sth_2 = $dbh->query($sql_2);
    //         }
    //     } else {
    //         echo '判定＿入力画像でアップロードされたファイルの保存に失敗しました。<br>';
    //     }
    // }
    //複数枚（判定＿入力画像）　ほんとは上のコメントアウトしてるものの判定処理をしたい（参考：https://qiita.com/hidepy/items/23ab9bb2c291e912763f）
    //フォーム画面で複数枚選べるようにする（参考：https://webcrehoo.com/56）
    // ファイルがあれば処理実行
    if (isset($_FILES['jud_input_file'])) {
        // アップロードされたファイル件を処理
        for ($i = 1; $i <= count($_FILES['jud_input_file']['name']); ++$i) {
            // アップロードされたファイルか検査
            if (is_uploaded_file($_FILES['jud_input_file']['tmp_name'][$i - 1])) {
                // ファイルをお好みの場所に移動
                $filename2 = 'img'.$i.'.jpg'; //保存ファイル名を変更（参考￥：https://techacademy.jp/magazine/18804）
                echo '保存ファイル名：'.$filename2.'<br>';
                move_uploaded_file($_FILES['jud_input_file']['tmp_name'][$i - 1], $path4.$dir_name4.'/'.$filename2);
                echo '判定＿入力画像でアップロードされたファイルを保存しました。<br>';
                echo '<img src="'.$path4.$dir_name4.'/'.$filename2.'"><br>'; //確認用
                //DBにテキストデータを入れる
                if ($dbh) {
                    // データベースへの問い合わせSQL⽂ (⽂字列) 
                    $sql_2 = "INSERT INTO `image_tb`(`problem_id`, `img_path`, `example_judgement`, `input_output`) VALUES ('$problem_id','$path4$dir_name4/img$i.jpg','1','0')";
                    // echo $sql_2.'<br><br>'; //確認用
                    //$sth = $dbh->query($sql); -> SQLの実⾏
                    $sth_2 = $dbh->query($sql_2);
                }
            }
        }
    }

    // //個別設定（判定＿出力画像）
    // //受け取ったものをディレクトリに保存する（参考：https://gray-code.com/php/save-the-upload-file/）
    // if (!empty($_FILES['jud_output_file']['tmp_name']) && is_uploaded_file($_FILES['jud_output_file']['tmp_name'])) {
    //     //画像を指定したパスへ保存する
    //     //[‘tmp_name’]は一時フォルダに保存されているそのファイルまでのパス（参考：https://techacademy.jp/magazine/18804）
    //     // //name=受け取ったものの名前をそのまま使う(参考：https://qiita.com/okdyy75/items/669dd51b432ee2c1dfbc)
    //     // move_uploaded_file($_FILES['jud_output_file']['tmp_name'], './images/problem/problem_'.$problem_id.'/example/input/'.$_FILES['jud_output_file']['name']);
    //     if (move_uploaded_file($_FILES['jud_output_file']['tmp_name'], $path4.$dir_name5.'/image_1.jpg')) {
    //         echo '判定＿出力画像でアップロードされたファイルを保存しました。<br>';
    //         echo '<img src="'.$path4.$dir_name5.'/image_1.jpg"><br>'; //確認用
    //         //DBにテキストデータを入れる
    //         if ($dbh) {
    //             // データベースへの問い合わせSQL⽂ (⽂字列) 
    //             $sql_2 = "INSERT INTO `image_tb`(`problem_id`, `img_path`, `example_judgement`, `input_output`) VALUES ('$problem_id','$path4$dir_name5/image_1.jpg','1','1')";
    //             echo $sql_2.'<br>'; //確認用
    //             //$sth = $dbh->query($sql); -> SQLの実⾏
    //             $sth_2 = $dbh->query($sql_2);
    //         }
    //     } else {
    //         echo '判定＿出力画像でアップロードされたファイルの保存に失敗しました。<br>';
    //     }
    // }
    //複数枚（判定＿出力画像）　ほんとは上のコメントアウトしてるものの判定処理をしたい（参考：https://qiita.com/hidepy/items/23ab9bb2c291e912763f）
    //フォーム画面で複数枚選べるようにする（参考：https://webcrehoo.com/56）
    // ファイルがあれば処理実行
    if (isset($_FILES['jud_output_file'])) {
        // アップロードされたファイル件を処理
        for ($i = 1; $i <= count($_FILES['jud_output_file']['name']); ++$i) {
            // アップロードされたファイルか検査
            if (is_uploaded_file($_FILES['jud_output_file']['tmp_name'][$i - 1])) {
                // ファイルをお好みの場所に移動
                $filename3 = 'img'.$i.'.jpg'; //保存ファイル名を変更（参考：https://techacademy.jp/magazine/18804）
                echo '保存ファイル名：'.$filename3.'<br>';
                move_uploaded_file($_FILES['jud_output_file']['tmp_name'][$i - 1], $path4.$dir_name5.'/'.$filename3);
                echo '判定＿出力画像でアップロードされたファイルを保存しました。<br>';
                echo '<img src="'.$path4.$dir_name5.'/'.$filename3.'"><br>'; //確認用
                //DBにテキストデータを入れる
                if ($dbh) {
                    // データベースへの問い合わせSQL⽂ (⽂字列) 
                    $sql_2 = "INSERT INTO `image_tb`(`problem_id`, `img_path`, `example_judgement`, `input_output`) VALUES ('$problem_id','$path4$dir_name5/img$i.jpg','1','1')";
                    // echo $sql_2.'<br><br>'; //確認用
                    //$sth = $dbh->query($sql); -> SQLの実⾏
                    $sth_2 = $dbh->query($sql_2);
                }
            }
        }
    }

?>
</body>
</html>
