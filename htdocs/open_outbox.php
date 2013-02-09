<?php
require_once('settings.php');

$did = $_GET['device_id'];
$dir = $_GET['dir'];

$sth = $db->prepare('DELETE FROM outbox WHERE device_id = :did AND dirname = :dir');
$sth->bindValue(':did', $did, PDO::PARAM_STR);
$sth->bindValue(':dir', $dir, PDO::PARAM_STR);
$sth->execute();

$cwd = getcwd();
echo addcslashes("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" /><script>window.external.OpenFile('$cwd\\$studir\\$did\\outbox\\$dir');</script></head></html>", "\\");
?>