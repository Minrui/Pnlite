<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>无标题页</title>
    <link href ="/style/Main1.css" type ="text/css" rel ="Stylesheet" />
	<script src='jquery.js'></script>
	<script>
		function OpenFile(url, path) {
			alert(url);
			$.get(url, function(data){alert(data);});
			//if(window.XMLHttpRequest)var xmlhttp = new XMLHttpRequest(); else var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			//var xmlhttp = new ActiveXObject("MSXML2.XMLHTTP");
			//alert(url);
			//xmlhttp.open("GET", url, false);
			//alert(xmlhttp);
			//window.external.OpenFile(path);
		}
	</script>
</head>
<body>
    <center>
       <table>
       <tr><th scope="col" colspan ="2">未读作业</th></tr>
		<?php
			require_once('settings.php');
			$tr_class = array('even', 'odd');
			$tr_seq = 0;
			
			$rows   = $db->query('SELECT * FROM outbox NATURAL JOIN clients')->fetchAll();
			$mtimes = array();
			
			foreach($rows as $row)$mtimes[] = filemtime("$studir/".$row['device_id']."/outbox/".iconv('utf-8', 'gbk', $row['dirname']));
				
			array_multisort($mtimes, SORT_DESC, $rows); //日期降序

			$tr_class = array('even', 'odd');
			$tr_seq = 0;
				
			for($i = 0; $i < count($rows); $i++) {
				$row = $rows[$i];
				$cwd = getcwd();$did = $row['device_id'];$dir = $row['dirname'];$uname = $row['username'];
				$mtime = date("Y-m-d H:i:s", $mtimes[$i]);
				echo "<tr class='".$tr_class[$tr_seq=1-$tr_seq]."'>";
				echo "<td>$uname</td>";
				//echo "<td>".addcslashes("<a href=\"javascript:OpenFile('http://localhost:7911/open_outbox/$did/$dir', '$cwd\\$studir\\$did\\outbox\\$dir');\">$dir</a><a style='float:right;'>$mtime</a>", '\\')."</td>";
				echo "<td><a href='http://localhost:7911/open_outbox/$did/$dir'>$dir</a><a style='float:right;'>$mtime</a></td>";
				echo "</tr>";
			}
		?>
       </table>
       <div style ="height :20px;"></div>
		<table>
		<tr class="odd"><th scope="col">作业管理</th></tr>
		<?php
		require_once('settings.php');
		$tr_class = array('even', 'odd');
		$tr_seq = 0;
		foreach ($db->query('SELECT * FROM clients ORDER BY username')->fetchAll() as $row) {
			$did = $row['device_id'];$username = $row['username'];
			echo "<tr class='".$tr_class[$tr_seq=1-$tr_seq]."'><td>";
			echo "<a href='/show_outbox_single/$did'>$username</a><br />";
			echo "</td></tr>";
		}
		?>
		</table>
		</center>
	</body>
</html>