<?php
define('INCLUDE_CHECK',true);

require 'connect.php';
require 'functions.php';

$jobID = urlencode($_POST["jobId"]);

move_uploaded_file($_FILES["file"]["tmp_name"], "RECEIPT/".$jobID);
mysql_query(" UPDATE jobs SET pathDeliveryReceipt = 'RECEIPT/{$jobID}'	WHERE jobId='{$jobID}' ");

?>
