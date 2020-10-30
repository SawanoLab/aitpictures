<!-- テスト用 -->
<!-- PDOの参考:https://codeforfun.jp/save-images-php-and-mysql-3/ -->
<!-- 使わなかったけど見やすそう（参考：http://web-design-fox.hatenablog.com/entry/2015/06/23/000412） -->

<?php
    require_once 'functions.php';

    //実行用のinput画像を取得
    $input = '';

    //DBからデータの取得 (参考：https://www.flatflag.nir87.com/select-932)
    $dbh = connectDB(); //データベース接続
    $sql = 'SELECT * FROM `image_tb` WHERE `problem_id`="1" AND `example_judgement`="1" /*AND input_output=1*/'; //カラム名条件からimage_tbの情報を抽出、``をしないと物が増えた時重くなる！（""はどっちでも）
    $stmt = $dbh->query($sql); // SQLステートメントを実行し、結果を変数に格納 //queryに$sqlを渡す
    foreach ($stmt as $row) { //queryの結果は配列で返ってくるのでforeach配列の中身を一行ずつ出力
        print_r($row['id'].'：'.$row['img_path']); //確認用
        print_r('<br>'); //確認用

        //画像表示(参考: https://kamuiblog.com/php-img/)
        echo '<img src="'.$row['img_path'].'"/>'; //確認用（画像）
        echo '<br />'; //確認用

        $input = $input.' '.$row['img_path']; //画像複数あったらURLを追加していく
    }

    echo $input; //確認用(文字)
    echo '<br />'; //確認用
    echo __DIR__; //確認用（文字）
    echo '<br />'; //確認用

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Image Test</title>