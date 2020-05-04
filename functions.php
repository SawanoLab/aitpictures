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
