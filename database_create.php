<?php
CREATE TABLE `aoj_picture`.`user_tb2` ( `user_id` INT(8) NOT NULL AUTO_INCREMENT , `login_name` VARCHAR(30) NULL , `login_password` VARCHAR(30) NULL , `user_name` VARCHAR(100) NULL , `create_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`user_id`)) ENGINE = InnoDB;

?>
