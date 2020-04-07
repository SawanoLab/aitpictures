<?php
    require_once(__DIR__.'/functions.php');
    $dbh=connectDB();

    //[group_participant_tb]
    $del_sql = "DROP TABLE if exists group_participant_tb";
    $sth = $dbh->query($del_sql);

    $sql =  "CREATE TABLE if not exists `group_participant_tb` (`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',`group_id` int(11) NULL COMMENT 'group_tbのid',`user_id` int(11) NULL COMMENT 'user_tbのid',`role_id` int(11) NULL COMMENT 'role_tdのid',`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日', PRIMARY KEY (`id`))ENGINE = InnoDB DEFAULT CHARSET=utf8";
    $sth = $dbh->query($sql);

    //[group_tb]
    $del_sql = "DROP TABLE if exists group_tb";
    $sth = $dbh->query($del_sql);

    $sql =  "CREATE TABLE if not exists `group_tb`(`id` INT NOT NULL AUTO_INCREMENT COMMENT 'ID', `group_name` TEXT NULL COMMENT 'グループ名', `creator_id` INT NULL COMMENT 'グループ製作者のuser_tbのuser_id', `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日', PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8";
    $sth = $dbh->query($sql);

    //[problem_info_tb]
    $del_sql = "DROP TABLE if exists problem_info_tb";
    $sth = $dbh->query($del_sql);

    $sql =  "CREATE TABLE if not exists `problem_info_tb`(`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',`problem_id` int(11) NULL COMMENT 'problem_tbのid',`input_output` int(11)NULL COMMENT '入力(0)or出力(1)',`img_or_answer_flag` int(11)NULL COMMENT '画像(0)orテキスト(1)',`URL` text NULL COMMENT '画像のURL',`answer` text NULL COMMENT '出力テキスト',`No` int(11) NULL COMMENT '画像orテキストを表示する順番',`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日', PRIMARY KEY (`id`))ENGINE = InnoDB DEFAULT CHARSET=utf8";
    $sth = $dbh->query($sql);

    //[problem_tb]
    $del_sql = "DROP TABLE if exists problem_tb";
    $sth = $dbh->query($del_sql);

    $sql =  "CREATE TABLE if not exists `problem_tb`(`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',`group_id` int(11)NULL COMMENT 'group_tbのid',`problemNo` int(11) NULL COMMENT '問題番号',`title` text NULL COMMENT '問題の題名',`sentence` text NULL COMMENT '問題文',`hint` text NULL COMMENT '問題のヒント',`creator_id` int(11) NULL COMMENT '製作者のuser_tbのuser_id',`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日', PRIMARY KEY (`id`))ENGINE=InnoDB DEFAULT CHARSET=utf8";
    $sth = $dbh->query($sql);

    //[request_tb]
    $del_sql = "DROP TABLE if exists request_tb";
    $sth = $dbh->query($del_sql);

    $sql = "CREATE TABLE if not exists `request_tb`( `request_id` INT NOT NULL AUTO_INCREMENT COMMENT '自動入力', `user_id` INT NULL COMMENT 'user_tbのuser_idが入ります',`group_id` INT NULL COMMENT 'group_tbのid が入ります',`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日',PRIMARY KEY (`request_id`))ENGINE = InnoDB";
    $sth = $dbh->query($sql);

    //[role_tb]
    $del_sql = "DROP TABLE if exists role_tb";
    $sth = $dbh->query($del_sql);

    $sql =  "CREATE TABLE if not exists `role_tb`(`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',`user_type` text NULL COMMENT '(製作者or解答者orゲスト)',`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日', PRIMARY KEY (`id`))ENGINE=InnoDB DEFAULT CHARSET=utf8";
    $sth = $dbh->query($sql);

    //[user_Answer_tb]
    $del_sql = "DROP TABLE if exists user_Answer_tb";
    $sth = $dbh->query($del_sql);

    $sql =  "CREATE TABLE if not exists `user_Answer_tb`(`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',`user_id` int(11) NULL COMMENT 'user_tdのuser_id',`problem_id` int(11) NULL COMMENT 'problem_tdのid',`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日', PRIMARY KEY (`id`))ENGINE=InnoDB DEFAULT CHARSET=utf8";
    $sth = $dbh->query($sql);

    //[user_tb]
    $del_sql = "DROP TABLE if exists user_tb";
    $sth = $dbh->query($del_sql);

    $sql = "CREATE TABLE if not exists `user_tb` ( user_id INT(8) NOT NULL AUTO_INCREMENT COMMENT 'ID' , login_name VARCHAR(30) NULL COMMENT 'ユーザ名' , login_password VARCHAR(30) NULL COMMENT 'パスワード' , display_name VARCHAR(100) NULL COMMENT '表示する名前' , create_on TIMESTAMP NOT NULL COMMENT 'IDを作った時間' , PRIMARY KEY (user_id)) ENGINE = InnoDB";
    $sth = $dbh->query($sql);

    //[group_participant_tb]　insert
    $insert = "INSERT INTO `group_participant_tb` (`group_id`, `user_id`, `role_id`) VALUES ('1', '1', '1')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `group_participant_tb` (`group_id`, `user_id`, `role_id`) VALUES ('1', '2', '2')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `group_participant_tb` (`group_id`, `user_id`, `role_id`) VALUES ('2', '1', '1')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `group_participant_tb` (`group_id`, `user_id`, `role_id`) VALUES ('2', '2', '2')";
    $sth_insert = $dbh->query($insert);

    //[group_tb] insert
    $insert = "INSERT INTO `group_tb` (`group_name`, `creator_id`) VALUES ('公開問題', '1')";
    $sth_insert = $dbh->query($insert);
    $insert = "INSERT INTO `group_tb` (`group_name`, `creator_id`) VALUES ('限定問題', '1')";
    $sth_insert = $dbh->query($insert);

    //[problem_info_tb] insert
    $insert = "INSERT INTO `problem_info_tb` (`problem_id`, `input_output`, `img_or_answer_flag`, `URL`,`answer`, `No`) VALUES ('1', '0', '0', 'images/problem_img/group1/problem1/img1.jpg', NULL,'1')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `problem_info_tb` (`problem_id`, `input_output`, `img_or_answer_flag`, `URL`,`answer`, `No`) VALUES ('1', '0', '0', 'images/problem_img/group1/problem1/img2.jpg', NULL,'2')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `problem_info_tb` (`problem_id`, `input_output`, `img_or_answer_flag`, `URL`,`answer`, `No`) VALUES ('1', '0', '0', 'images/problem_img/group1/problem1/img3.jpg', NULL, '3')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `problem_info_tb` (`problem_id`, `input_output`, `img_or_answer_flag`, `URL`,`answer`, `No`) VALUES ('1', '1', '0', 'images/problem_img/group1/problem1/teacher.jpg', NULL, '1')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `problem_info_tb` (`problem_id`, `input_output`, `img_or_answer_flag`, `URL`,`answer`, `No`) VALUES ('2', '0', '0', 'images/problem_img/group1/problem1/sample.jpg', NULL,'1')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `problem_info_tb` (`problem_id`, `input_output`, `img_or_answer_flag`, `URL`,`answer`, `No`) VALUES ('2', '0', '0', 'images/problem_img/group1/problem1/sample.jpg', NULL, '2')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `problem_info_tb` (`problem_id`, `input_output`, `img_or_answer_flag`, `URL`,`answer`, `No`) VALUES ('2', '1', '0', 'images/problem_img/group1/problem1/sample_black.jpg', NULL,'1')";
    $sth_insert = $dbh->query($insert);


    //[problem_tb] insert
    $insert = "INSERT INTO `problem_tb` (`group_id`, `problemNo`, `title`, `sentence`,`hint`, `creator_id`) VALUES ('1', '1', '白黒画像にしよう', 'この画像を白黒画像にしよう!', 'hint','1')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `problem_tb` (`group_id`, `problemNo`, `title`, `sentence`,`hint`, `creator_id`) VALUES ('2', '2', '限定問題', '問題文2', 'text','1')";
    $sth_insert = $dbh->query($insert);

    //[request_tb] insert
    $insert = "INSERT INTO `request_tb` (`user_id`, `group_id`) VALUES ('2', '2')";
    $sth_insert = $dbh->query($insert);

    //[role_tb] insert
    $insert = "INSERT INTO `role_tb` (`user_type`) VALUES ('admin')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `role_tb` (`user_type`) VALUES ('student')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `role_tb` (`user_type`) VALUES ('guests')";
    $sth_insert = $dbh->query($insert);

    //[user_Answer_tb] insert
    $insert = "INSERT INTO `user_Answer_tb` (`user_id`, `problem_id`) VALUES ('2', '1')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `user_Answer_tb` (`user_id`, `problem_id`) VALUES ('2', '2')";
    $sth_insert = $dbh->query($insert);

    //[user_tb] insert
    $insert = "INSERT INTO `user_tb`(`login_name`, `login_password`, `display_name`) VALUES ('ipc_user', 'sawano-lab', 'ipc')";
    $sth_insert = $dbh->query($insert);

    $insert = "INSERT INTO `user_tb` (`login_name`, `login_password`, `display_name`) VALUES ('student', '1234', 'student')";
    $sth_insert = $dbh->query($insert);

?>
