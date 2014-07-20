<?php

if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');


/* Database config */

//$db_host		= 'hl114.dinaserver.com';
//$db_host		= '82.98.160.7';
$db_host		=  '127.0.0.1';
$db_user		= 'makeit';
$db_pass		= 'Gvmor99s';
$db_database	= 'makeit'; 

/* End config */



$link = mysql_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');

mysql_select_db($db_database,$link);
mysql_query("SET names UTF8");

?>