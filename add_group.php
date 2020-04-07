<html>
<head>
    <meta charset="UTF-8"/>
</head>
<body>
あああ<br>
<?php
    require_once(__DIR__.'/functions.php');
    $dbh=connectDB();

    //the verification of the [title].
    if(!isset($_POST['title'])){
        echo "not found<br>";
    }
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
    echo $title."<br>";
    $group = htmlspecialchars($_POST['group'], ENT_QUOTES);
    echo $group."<br>";
    $problem = htmlspecialchars($_POST['problem'], ENT_QUOTES);
    echo $problem."<br>";
    $outputText = htmlspecialchars($_POST['outputText'], ENT_QUOTES);
    echo $outputText."<br>";
    $hintText = htmlspecialchars($_POST['hintText'], ENT_QUOTES);
    echo $hintText."<br>";

    if($dbh){
      //データベースへの問い合わせSQL文（文字列）　

    }
    //認証
    //if(( == '')&&( == ''))
    if(count($result_2)==1){//配列数が唯一の場合
      //表示用ユーザ名のセッション変数に保存
      $group_id = $result_2[0]["id"];
    }
    echo "グループID".$group_id."<br>";

    //認証
    //if(( == '')&&( == ''))
    if(count($result_1)==1){//配列数が唯一の場合
      //表示用ユーザ名のセッション変数に保存
      $creator_id = $result_2[0]["creator_id"];
    }
    echo "作者ID".$creator_id"<br>";


    //update check function
    function chk_ext( $chk_name, $allow_exts=array( "png", "jpg" ) ) {
        //使用出来ない拡張子のチェック
        $ext_err = true;//エラーフラグは初期値 真
        $exts = preg_split( "/[.]/", $chk_name );// ファイル名を.で分割する。
        if( count( $exts ) < 2 ) return false;
        $ext = $exts[ count( $exts ) - 1 ];//.で分割した最後のブロックの文字列を取得する
        foreach( $allow_exts as $val ) {
            if( !empty( $val ) ) {
                if( strcasecmp( $val, $ext ) == 0 ) {
                    $ext_err = false;//エラーフラグ 偽に変更
                    break;
                }
            }
        }
        unset($val);
        $ret = !$ext_err;//戻り値はエラーフラグを反転
        return $ret;
    }

    $MAXSIZE = 2097152;
    //update [input_file].
    $filename="images/".$_FILES['input_file']['name'];
    if(is_uploaded_file($_FILES['input_file']['tmp_name'])){
        echo "入力ファイルが見つかりました<br>";
        if((0 < $_FILES["output_file"]["size"]) && ($_FILES["output_file"]["size"] < $MAXSIZE)){
            //ファイル名の拡張子チェックテスト
            if( !chk_ext( $_FILES["input_file"]["name"] ) ) {
                echo "認められていない拡張子です。<br>";
            }else if(move_uploaded_file($_FILES['input_file']['tmp_name'],$filename)){

                echo "入力のアップロードができました<br>";
            }else{
                echo "入力のアップロードができませんでした<br>";
            }
        }else{
            echo "入力ファイルのサイズが指定サイズ外です<br>";
        }
    }else{
        echo "入力ファイルが見つかりませんでした<br>";
    }
    echo $_FILES['input_file']['name']."<br>";
    //update [output_file].
    $filename="image/".$_FILES['output_file']['name'];
    if(is_uploaded_file($_FILES['output_file']['tmp_name'])){
        echo "出力ファイルが見つかりました<br>";
        if((0 < $_FILES["output_file"]["size"]) && ($_FILES["output_file"]["size"] < $MAXSIZE)){
                //ファイル名の拡張子チェックテスト
            if( !chk_ext( $_FILES["output_file"]["name"] ) ) {
                echo "認められていない拡張子です。<br>";
            }else if(move_uploaded_file($_FILES['output_file']['tmp_name'],$filename)){
                echo "出力のアップロードができました<br>";
            }else{
                echo "出力のアップロードができませんでした<br>";
            }
        }else{
            echo "出力ファイルのサイズが指定サイズ外です<br>";
        }
    }else{
        echo "出力のファイルが見つかりませんでした<br>";
    }
    echo $_FILES['output_file']['name']."<br>";
    if($dbh) {
        // データベースへの問い合わせSQL⽂ (⽂字列) 
        $sql = "INSERT INTO `ipc_db`.`problem_tb`( `id`, `group_id`, `problemNo`, `title`, `sentence`, `hint`, `timestamp`)
        VALUES(NULL, '$group_id', '1', '$title', '$problem', '$hint', CURRENT_TIMESTAMP)";
        echo $sql;
        echo "<br>";
         $sth = $dbh->query($sql); //SQLの実⾏
     }
?>
</body>
</html>
