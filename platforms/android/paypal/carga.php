<?php
define('INCLUDE_CHECK',true);

require 'connect.php';
require 'functions.php';

$ID = urlencode($_POST["ID"]);
$NAME =  $_POST["NAME"];
move_uploaded_file($_FILES["file"]["tmp_name"], "TEST/".$ID."_".$NAME );
mysql_query(" UPDATE jobs SET pathOfVideo = 'TEST/{$ID}_{$NAME}'	WHERE jobId='{$ID}' ");

?>
