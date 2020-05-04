<?php
    //接続用関数の呼び出し
    require_once __DIR__.'/functions.php';

    createTable(); //テーブルの生成

    //テーブルの生成
    function createTable()
    {
        //DBへの接続
        $dbh = connectDB();
        //データベースの接続確認
        if (!$dbh) {  //接続できていない場合
            echo 'DBに接続できていません．';

            return;
        }

        //テーブルが存在するかを確認するSQL文
        $sql = 'show tables';
        $sth = $dbh->query($sql); //SQLの実行
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if (0 < count($result)) {
            //データベース構築済み
            return;
        }

        //---------------------------------------------------------------------------
        //問題概要テーブルの作成
        $sql = 'CREATE TABLE IF NOT EXISTS `problem_tb` ( `id` INT NOT NULL AUTO_INCREMENT,
        `level` INT NULL, 
        `title` text NULL,
        `sentence` text NULL,
        `hint` text NULL,
        `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
        PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8';
        $dbh->exec($sql); //SQLの実行
        //---------------------------------------------------------------------------

        //---------------------------------------------------------------------------
        //画像テーブルの作成
        $sql = 'CREATE TABLE IF NOT EXISTS `image_tb` ( `id` INT NOT NULL AUTO_INCREMENT,
        `problem_id` INT NOT NULL, 
        `img_path` INT NOT NULL,
        `problem_answer` INT NOT NULL,
        `example_judgement` INT NOT NULL,
        PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8';
        $dbh->exec($sql); //SQLの実行
        //---------------------------------------------------------------------------

        //---------------------------------------------------------------------------
        //標準入力の作成
        $sql = 'CREATE TABLE IF NOT EXISTS `input_value_tb` ( `id` INT NOT NULL AUTO_INCREMENT,
        `problem_id` INT NOT NULL, 
        `input_value` INT NOT NULL,
        PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8';
        $dbh->exec($sql); //SQLの実行
        //---------------------------------------------------------------------------

        //---------------------------------------------------------------------------
        //標準出力の作成
        $sql = 'CREATE TABLE IF NOT EXISTS `output_value_tb` ( `id` INT NOT NULL AUTO_INCREMENT,
        `problem_id` INT NOT NULL, 
        `output_value` INT NOT NULL,
        PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8';
        $dbh->exec($sql); //SQLの実行
        //---------------------------------------------------------------------------
    }

    // Webブラウザにこれから表示するものがUTF-8で書かれたHTMLであることを伝える
    // (これか <meta charset="utf-8"> の最低限どちらか1つがあればいい． 両方あっても良い．)
    header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>DB作成完了</title>
    </head>
    <body>
        <!-- ここではHTMLを書く以外のことは一切しない -->
    </body>
</html>