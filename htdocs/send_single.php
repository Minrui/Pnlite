<?php
require_once('settings.php');
$did = $_GET['device_id'];
$fname = basename(iconv('gbk', 'utf-8', $_GET['path']));

while(file_exists($fpath = iconv('utf-8', 'gbk', "$studir/$did/inbox/$fname")))$fname = substr($fname, 0, -4).'_'.substr($fname, -4);
rename($_GET['path'], $fpath);
$sth = $db->prepare('INSERT INTO inbox (device_id, filename) values (:did, :filename)');
$sth->bindValue(':did', $did, PDO::PARAM_STR);
$sth->bindValue(':filename', $fname, PDO::PARAM_STR);
$sth->execute();

//TODO: 提醒白板
?>