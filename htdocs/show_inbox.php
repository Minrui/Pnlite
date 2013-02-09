<?php header("content-type:text/html; charset=gb2312"); require_once('settings.php'); $did = $_GET['device_id']; $uname = iconv('utf-8', 'gbk', $_GET['username']); ?>
<html> 
    <head> 
        <title>文件查看</title> 
    </head> 
    <body>
<center>
<a><?=$uname?>文件管理</a>
<hr />
<table width="100%">
<?php
init_student($did, $_GET['username']);

$fnames = array();
$mtimes = array();

$fso = opendir("$studir/$did/inbox/");
readdir($fso);readdir($fso); //跳过 . .. 两个目录

while($file = readdir($fso)) {$fnames[] = $file;$mtimes[] = filemtime("$studir/$did/inbox/$file");}

array_multisort($mtimes, SORT_DESC, $fnames); //日期降序

$npp = 10; //每页显示文件数

$total_pages = (count($fnames) + $npp - 1) / $npp;
$cur_page = $_GET['page'] > $total_pages ? 1 : $_GET['page'];

for($i = ($cur_page - 1) * $npp; $i < $cur_page * $npp && $i < count($fnames); $i++) {
	$fname = $fnames[$i];
	$mtime = date("Y-m-d H:i", $mtimes[$i]);
	$url   = urlencode(iconv('gbk', 'utf-8', $fname));
	echo "<tr>";
	echo "<td width='60'><h1><a href='/$studir/$did/inbox/$fname'>$fname</a></h1></td>";
	echo "<td><font size='100'><a>$mtime</a></font></td>";
	echo "<td><font size='100'><a href='/rm_inbox/$fname/$did/$uname/'>删除</a></font></td>";
	echo "</tr>";
}
?>
</table>
<hr />
<font size='100'>
<?php
if($cur_page != 1)echo "<a href='/show_inbox/$did/$uname/".($cur_page - 1)."'>上一页</a>&nbsp;";
for($i = 1; $i <= $total_pages; $i++) {
	echo "<a ".(($i != $cur_page)?"href='/show_inbox/$did/$uname/$i'":"").">$i</a>&nbsp;";
}
if($cur_page + 1 <= $total_pages)echo "<a href='/show_inbox/$did/$uname/".($cur_page + 1)."'>下一页</a>";

?>
</font>
</center>
    </body> 
</html> 