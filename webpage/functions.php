<?php
//参考URL: http://qiita.com/fantm21/items/891192da1a095e94c9e1

require_once(__DIR__ . '/config.php');

//データベース(ユーザ)に接続
function connectDb() {
    try {
        return new PDO(DSN, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}
?>