<?php
require_once('settings.php');
$db->beginTransaction();
$path = iconv('utf-8', 'gbk', '礼物.gft'); //$path -> gbk
foreach($_POST['id'] as $did) {
    $fname = iconv('gbk', 'utf-8', basename($path)); //$fname ->utf-8
    while(file_exists($fpath = iconv('utf-8', 'gbk', "$studir/$did/inbox/$fname")))$fname = substr($fname, 0, -4).'_'.substr($fname, -4);
    exec("fsutil hardlink create \"$fpath\" \"$path\"", $nul, $fail); //使用硬链接加速拷贝
    if($fail)$fail = !copy($path, $fpath); //若硬链接创建失败、使用普通拷贝
	if(!$fail){
	    $sth = $db->prepare('INSERT INTO inbox (device_id, filename) values (?, ?)');
        $sth->execute(array($did, $fname));
        $path = $fpath;
	}
}
//TODO: 提醒白板
$db->commit();
?>
<script>window.external.HideWeb();</script>
