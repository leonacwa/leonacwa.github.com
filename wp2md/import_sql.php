<?php
$cfg_db_host_from = 'localhost';
$cfg_db_user_from = 'root';
$cfg_db_pwd_from = 'nsdhr64326136';
$cfg_db_name_from = 'hrbustoj';
$cfg_db_port_from = '3306';

$cfg_db_host_new = 'localhost';
$cfg_db_user_new = 'root';
$cfg_db_pwd_new = 'nsdhr64326136';
$cfg_db_name_new = $_SERVER['argv'][1];
$cfg_db_port_new = '3306';

$_mysqli_from = mysqli_connect($cfg_db_host_from, $cfg_db_user_from, $cfg_db_pwd_from, $cfg_db_name_from, $cfg_db_port_from) or die('Connect Old Database Error!');
mysqli_query($_mysqli_from, "set names utf8") or die('Set Old Database Charset Error!');
$_mysqli_new = mysqli_connect($cfg_db_host_new, $cfg_db_user_new, $cfg_db_pwd_new, $cfg_db_name_new, $cfg_db_port_new) or die('Connect New Database Error!');
mysqli_query($_mysqli_new, "set names utf8") or die('Set New Database Charset Error!');
ini_set('date.timezone','Asia/Shanghai');

$strSql = "SELECT user_name, password, gender, school, avatar, real_name FROM users";
$dtUsers = mysqli_query($_mysqli_from, $strSql) or die($strSql);
while ($row = mysqli_fetch_row($dtUsers)) {
	$strUsername = $row[0];
	$strPassword = $row[1];
	$nGender = ($row[2] > 0) ? $row[2] : 1;
	$strSchool = $row[3];
	$strAvatar = $row[4];
	$strRealname = $row[5];
	$strSqlImport = "INSERT INTO users (username, gender, school, comment, avatar, password) VALUES ('{$strUsername}', '{$nGender}', '{$strSchool}', '{$strRealname}', '{$strAvatar}', '{$strPassword}')";
	mysqli_query($_mysqli_new, $strSqlImport) or die($strSqlImport);
}
?>
