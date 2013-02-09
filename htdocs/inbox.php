<?php
require_once('settings.php');
$did = $_GET['device_id'];
init_student($did, $_GET['username']);

$sth = $db->prepare('SELECT * FROM inbox WHERE device_id = :did');
$sth->bindValue(':did', $_GET['device_id'], PDO::PARAM_STR);
$sth->execute();
$result = $sth->fetchAll();

//Çå¿ÕINBOX µ÷ÊÔÊ±×¢ÊÍµô
$sth = $db->prepare('DELETE FROM inbox WHERE device_id = :did');
$sth->bindValue(':did', $did, PDO::PARAM_STR);
$sth->execute();

$buffer = pack('L', count($result));
foreach ($result as $file) {
	$fname   = $file['filename'];
    $buffer .= pack('La128a512a256', filesize(iconv('utf-8', 'gbk', "$studir/$did/inbox/$fname")), $fname, "http://$host/$studir/$did/inbox/".urlencode($fname), '');
}

echo $buffer;
?>