<?php
require_once('settings.php');
function deleteDir($dir) { //递归删除目录
	if (!rmdir($dir) && is_dir($dir)) {
		if ($dp = opendir($dir)) {
			readdir($dp);readdir($dp);
			while ($file = readdir($dp)){$file = $dir.DIRECTORY_SEPARATOR.$file; if (is_dir($file)) deleteDir($file); else unlink($file);} 
			closedir($dp);
		}
		rmdir($dir);
	}
}

$did = $_GET['device_id'];$dir = $_GET['dir'];

$sth = $db->prepare('DELETE FROM outbox WHERE device_id = :did and dirname = :dirname');
$sth->bindValue(':did', $did, PDO::PARAM_STR);
$sth->bindValue(':dirname', $dir, PDO::PARAM_STR);
$sth->execute();

deleteDir("$studir/$did/outbox/".iconv('utf-8', 'gbk', $dir));

header("Location: ".$_SERVER['HTTP_REFERER']);
?>