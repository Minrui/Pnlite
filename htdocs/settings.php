<?php
$studir = 'stu';
$host   = $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'];
$db     = new PDO('sqlite:eclass.db');
$ttl	= 10;

function init_student($device_id, $username) {
	$db 	= $GLOBALS['db']; 
	$ttl 	= $GLOBALS['ttl'];
	$studir = $GLOBALS['studir'];

    $sth = $db->prepare('INSERT INTO clients (device_id) values (:did)');
    $sth->bindValue(':did', $device_id, PDO::PARAM_STR);
    $sth->execute();
	
	$sth = $db->prepare('UPDATE clients SET username = :uname, ttl = :ttl WHERE device_id = :did');
	$sth->bindValue(':uname', $username, PDO::PARAM_STR);
	$sth->bindValue(':ttl', time() + $ttl, PDO::PARAM_INT);
	$sth->bindValue(':did', $device_id, PDO::PARAM_STR);
	$sth->execute();
	
    @mkdir("$studir");
    @mkdir("$studir/$device_id");
    @mkdir("$studir/$device_id/inbox/");
    @mkdir("$studir/$device_id/outbox/");
}
?>