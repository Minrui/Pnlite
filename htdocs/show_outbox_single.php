<?php require_once('settings.php'); $row = $db->query("SELECT * FROM clients WHERE device_id = '".$_GET['device_id']."'")->fetch(); 
	  $did = $row['device_id'];$username = $row['username'];?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>无标题页</title>
    <link href ="/style/Main1.css" type ="text/css" rel ="Stylesheet" />
</head>
	<body>
	<center>
	    <table>
	    <tr><th scope="col"><?php echo $username;?></th>
	        <th scope="col" colspan ="2">作业管理</th>
	        <th scope="col"><a href="/show_outbox/">返回收件箱</a></th></tr>
			
			<?php
				$fnames = array();
				$mtimes = array();

				$fso = opendir("$studir/$did/outbox/");
				readdir($fso);readdir($fso); //跳过 . .. 两个目录

				while($file = readdir($fso)) {$fnames[] = iconv('gbk', 'utf-8', $file);$mtimes[] = filemtime("$studir/$did/outbox/$file");}
				
				closedir($fso);
				
				array_multisort($mtimes, SORT_DESC, $fnames); //日期降序

				$tr_class = array('even', 'odd');
				$tr_seq = 0;
				
				for($i = 0; $i < count($fnames); $i++) {
					$fname = $fnames[$i];
					$mtime = date("Y-m-d H:i:s", $mtimes[$i]);
					$cwd = getcwd();
					echo "<tr class='".$tr_class[$tr_seq=1-$tr_seq]."'>";
					echo "<td colspan='2'>".addcslashes("<a href=\"javascript:window.external.OpenFile('$cwd\\$studir\\$did\\outbox\\$fname');\">$fname</a><a style='float:right;'>$mtime</a>", '\\')."</td>";
					echo "<td colspan='2'><a href='/rm_outbox/$did/$fname'>删除</a></td>";
					echo "</tr>";
				}
			?>
	    </table>
	    </center> 
	</body>
</html>
