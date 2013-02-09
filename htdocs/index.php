<?php
@header("content-Type: text/html; charset=utf-8");error_reporting(E_ALL);
define("YES","<b><font color=green>Yes</font></b>");define("NO","<b><font color=red>No</font></b>");
$act=isset($_GET['act'])?$_GET['act']:"";if($act=="phpinfo"){phpinfo();exit();}
$isvhs=substr($_SERVER["DOCUMENT_ROOT"],-6,6)=="htdocs"?0:1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHPnow</title>
<style type="text/css">
<!--
BODY{FONT-SIZE:75%;MARGIN-TOP:10px;}
BODY,TD,TH{FONT-FAMILY:Tahoma,Verdana;}
FORM{MARGIN:0px;}
TABLE{BORDER-COLLAPSE:collapse;}
TD,TH {BORDER:1px solid #000000;VERTICAL-ALIGN:baseline;PADDING-LEFT:10px;PADDING-RIGHT:10px;}
TH{BACKGROUND-COLOR:yellowgreen;FONT-WEIGHT:bold;}
INPUT{BORDER:1px solid #000000;}
A{TEXT-DECORATION:none;COLOR:#000000;}
A:HOVER{TEXT-DECORATION:underline;}
A.ARROW{FONT-FAMILY:Webdings,sans-serif;FONT-SIZE:10px;}
A.ARROW:HOVER{COLOR:#ff0000;TEXT-DECORATION:none;}
-->
</style>
</head>
<body>
<div style="MARGIN-LEFT:auto; MARGIN-RIGHT:auto; WIDTH:600px;">

<table><tr><td style="BORDER: 0px solid #000000; PADDING: 0px;" align=center>
<b><font size=6><font size=6 color=yellowgreen># PHP</font><font size=6 color=tomato>now</font><font size=6 color=lightskyblue>-Lite</font></a></font></b>
</td></tr></table>
<br>
<table width="100%" cellspacing="1" cellpadding="3">
	<tr>
		<th colspan="2">Server Information</th>
	</tr>

	<tr>
		<td>主机名 ( IP:port )</td>
		<td><?=$_SERVER['SERVER_NAME']?> (<?=$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']?>)</td>
	</tr>

	<tr>
		<td>服务器软件</td>
		<td><?=$_SERVER['SERVER_SOFTWARE']?></td>
	</tr>

	<tr>
		<td>网站主目录</td>
		<td><?=$_SERVER["DOCUMENT_ROOT"]?></td>
	</tr>

	<tr>
		<td>Other Links</td>
		<td>
		<a href='<?=$_SERVER['PHP_SELF']?>?act=phpinfo'>phpinfo()</a>
		| <a href='http://phpnow.org/?lite'>PHPnow.org</a>
		</td>
	</tr>
</table>

<hr>

<table width="100%" cellspacing="1" cellpadding="3">
	<tr>
		<th colspan="2">PHP 组件支持</th>
	</tr>

	<tr>
		<td>Zend Optimizer</td>
		<td><?=OPTIMIZER_VERSION!=="OPTIMIZER_VERSION"?YES." / ".OPTIMIZER_VERSION:NO?></td>
	</tr>

	<tr>
		<td>MySQL 支持</td>
		<td><?=function_exists("mysql_close")?YES." / ".mysql_get_client_info():NO?></td>
	</tr>

	<tr>
		<td>GD library</td>
		<td><?=function_exists("gd_info")?YES." / ".get_gd_info("GD Version"):NO?></td>
	</tr>

</table>

<hr>

<table width="100%" border="0" cellspacing="1" cellpadding="3">
	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<tr>
		<th colspan="4">MySQL 连接测试</th>
	</tr>

	<tr>
		<td>MySQL 服务器</td>
		<td><input type="text" name="mysqlHost" value="localhost:3307" /></td>
		<td>MySQL 数据库名</td>
		<td><input type="text" name="mysqlDb" value="test" /></td>
	</tr>

	<tr>
		<td>MySQL 用户名</td>
		<td><input type="text" name="mysqlUser" value="root" /></td>
		<td>MySQL 用户密码</td>
		<td><input type="text" name="mysqlPassword" /></td>
	</tr>

	<tr>
		<td colspan=4 align=right><input type="submit" value="连接" name="act" /> &nbsp;</td>
	</tr>

<?php if(isset($_POST['act'])){$link=@mysql_connect($_POST['mysqlHost'],$_POST['mysqlUser'],$_POST['mysqlPassword']);?>
	<tr>
		<td colspan=2>连接服务器 <?=$_POST['mysqlHost']?></td>
		<td colspan=2><?=($link?"<font color=green>连接正常":"<font color=red>连接失败</font>")?></td>
	</tr>

<?php if($link){?>
	<tr>
		<td colspan=2>MySQL 服务器信息</td>
		<td colspan=2><?=mysql_get_server_info($link)?></td>
	</tr>

<?}?>
	<tr>
		<td colspan=2>连接数据库 <?=$_POST['mysqlDb']?></td>
		<td colspan=2><?=(@mysql_select_db($_POST['mysqlDb'],$link))?"<font color=green>连接正常</font>":"<font color=red>连接失败</font>"?></td>
	</tr>
<?}?>
	</form>
</table>

<hr>

<p align=right>2007 - <a href="http://phpnow.org" target="_blank">PHPnow.org</a></p>

</div>
</body>
</html>
<?php
function get_gd_info($name){$gd_info=gd_info();return $gd_info[$name];}
?>