<?php
require_once('settings.php');

$did = $_POST['id'];

init_student($did, $_POST['username']);

for($i = 0; $i < count($_FILES['myfile'][name]); $i++) {
	$fname = $_FILES['myfile'][name][$i];
    if(strncmp($did, 'PAD', 3) == 0)$fname = urldecode($fname);//!!dirty hack for PAD
	if(substr_compare($fname, '.trk', -4) == 0 || substr_compare($fname, '.pdf', -4) == 0) {
		$orig_name = $fname; $new_fname = $fname;
		if(substr_compare($new_fname, '.trk', -4) == 0)$new_fname = substr($new_fname, 0, -4).'.png';
		while(!@mkdir(iconv('utf-8', 'gbk', $dirname = "$studir/$did/outbox/$new_fname")))$new_fname = substr($new_fname, 0, -4).'_'.substr($new_fname, -4);
		break;
	}
}

if($dirname) { //若有$dirname
	for($i = 0; $i < count($_FILES['myfile'][name]); $i++) if(!$_FILES['myfile'][error][$i]) {
		$tmpfn = $_FILES['myfile'][name][$i];
        	if(strncmp($did, 'PAD', 3) == 0)$tmpfn = urldecode($tmpfn); //!!dirty hack for PAD
		$fname = $new_fname.substr($tmpfn, strlen($orig_name));
print_r($fname);
		//$fname = eregi_replace("^".addcslashes("$orig_name", "[]"), $new_fname, $tmpfn);
		copy("../".$_FILES['myfile'][tmp_name][$i], iconv('utf-8', 'gbk', "$dirname/$fname"));
	}
		
	//TODO:更新数据
	$sth = $db->prepare('INSERT INTO outbox (device_id, dirname) values (:did, :dirname)');
	$sth->bindValue(':did', $did, PDO::PARAM_STR);
	$sth->bindValue(':dirname', basename($dirname), PDO::PARAM_STR);
	$sth->execute();

	//TODO: 提醒白板
	exec('..\\bin\\send_outbox_msg.exe');
}
?>
