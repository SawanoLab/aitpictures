<?php

require_once __DIR__.'/config.php';

//データベース(ユーザ)に接続
function connectDB()
{
    try {
        return new PDO(DSN, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
        // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
        // - 下ではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
        //header('Content-Type: text/plain; charset=UTF-8', true, 500);
        echo $e->getMessage();
        ecit;
    }
}

// function mkDir($path, $dir, $problem_id)
// $path1 = './images/problem/';
//     // 作成するディレクトリ名
//     $dir_name1 = 'problem_'.$problem_id;
//     $dir = $dir.$problem_id;
//     // 親ディレクトリが書き込み可能か、および同じ名前のディレクトリが存在しないか確認
//     if (is_writable($path) && !file_exists($path.$dir)) {
//         // ディレクトリを作成
//         if (mkdir($path.$dir)) {
//             echo '「problem_問題ID」ディレクトリを作成しました。<br>';
//         } else {
//             echo '「problem_問題ID」ディレクトリの作成に失敗しました。<br>';
//         }
//     } else {
//         echo '「problem_問題ID」は親ディレクトリが書き込みを許可していないか、すでに同名のディレクトリがあり作成できませんでした。<br>';
//     }
