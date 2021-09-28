<?php

include_once('databaseValues.php');

$conn = @mysql_pconnect($hostName,$dbUserName,$dbPassword) or die("Database Connection Failed<br>". mysql_error());



mysql_select_db($databaseName, $conn) or die('DB not selected');





mysql_query("ALTER TABLE `fc_help_main` ADD `seo` VARCHAR(250) NOT NULL ;") or die(mysql_error());

mysql_query("ALTER TABLE `fc_help_sub` ADD `seo` VARCHAR(250) NOT NULL ;") or die(mysql_error());

mysql_query("ALTER TABLE `fc_help_question` ADD `seo` VARCHAR(250) NOT NULL ;") or die(mysql_error());



mysql_close();



unlink("help_batch.php");

?>