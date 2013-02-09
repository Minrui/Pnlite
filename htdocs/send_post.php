<?php
require_once('settings.php');
$db->beginTransaction();
for($i = 0; $i < count($_FILES['myfile'][name]); $i++) {
    if(!$_FILES['myfile'][error][$i]) {
		$tmpfile = "../".$_FILES['myfile'][tmp_name][$i];
        foreach($_POST['id'] as $did) {
			$fname = $_FILES['myfile'][name][$i];
			while(file_exists($fpath = iconv('utf-8', 'gbk', "$studir/$did/inbox/$fname")))$fname = substr($fname, 0, -4).'_'.substr($fname, -4);
			exec("fsutil hardlink create \"$fpath\" \"$tmpfile\"", $nul, $fail); //使用硬链接加速拷贝
			if($fail)$fail = !copy($tmpfile, $fpath); //若硬链接创建失败、使用普通拷贝
			if(!$fail){
				$sth = $db->prepare('INSERT INTO inbox (device_id, filename) values (?, ?)');
				$sth->execute(array($did, $fname));
			}
        }
    }
//TODO: 提醒白板
}
$db->commit();
?>
<script>window.external.HideWeb();</script>