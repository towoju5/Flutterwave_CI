<?php

include_once('databaseValues.php');


$conn = @mysql_pconnect($hostName,$dbUserName,$dbPassword) or die("Database Connection Failed<br>". mysql_error());



mysql_select_db($databaseName, $conn) or die('DB not selected');



mysql_query("ALTER TABLE `fc_rentalsenquiry` ADD `cancelled` ENUM('No','Yes') NOT NULL DEFAULT 'No' ;") or die(mysql_error());



unlink("cancel_batch.php");

mysql_close();



 ?>