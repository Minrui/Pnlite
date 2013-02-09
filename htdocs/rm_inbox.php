<?php
require_once('settings.php');

$did = $_GET['device_id'];$fname = $_GET['fname'];$uname = $_GET['username'];

$sth = $db->prepare('DELETE FROM inbox WHERE device_id = :did and filename = :fname');
$sth->bindValue(':did', $did, PDO::PARAM_STR);
$sth->bindValue(':fname', $fname, PDO::PARAM_STR);
$sth->execute();
unlink("$studir/$did/inbox/".iconv('utf-8', 'gbk', $fname));

header("Location: /show_inbox/$did/$uname");
?>