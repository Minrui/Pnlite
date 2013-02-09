<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
        <link href="/style/Main1.css" type="text/css" rel="Stylesheet" />
        <title>文件发送</title>
        <script>
			function $(v){return document.getElementById(v);}
			
			function CheckAllCus() {
				var checks = document.getElementsByName("id[]");
				for (var i = 0; i < checks.length; i++)checks[i].checked = $('checkall_'+checks[i].className).checked;
			}
			
			function CheckCus(t) {
				var is_all = true;
				var checks = document.getElementsByName("id[]");
				for(var i = 0; i < checks.length; i++)if(checks[i].className == t.className && !checks[i].checked)is_all = false;
				$('checkall_'+t.className).checked = is_all;
			}
			
			function createMyFile(){
				var i = 0;while($("myfile_" + i))i++;
			
				var tr = document.createElement("tr");
				tr.id = "myfile_" + i;
				
					var td = document.createElement("td");
			
					var myfile = document.createElement("input");
					myfile.name = "myfile[]"; myfile.type = "file";
					td.appendChild(myfile);
					
					tr.appendChild(td);
					
					var td = document.createElement("td");
			
					var rm_btn = document.createElement("input");
					rm_btn.type = "button"
					rm_btn.value = "删除";
					rm_btn.className = "btn";
					rm_btn.onclick=function(){$('filetable').removeChild($("myfile_"+i));};
					td.appendChild(rm_btn);
					
					tr.appendChild(td);
				
				$("filetable").appendChild(tr);
			}
			
			function hasCheckAny() {
				var is_any = false;
				var checks = document.getElementsByName("id[]");
				for(var i = 0; i < checks.length; i++)if(checks[i].checked)is_any = true;
				if(!is_any)alert("请选择要发送的学生!");
				return is_any;
			}
        </script>
    </head>
	
    <body>
	<center>
		<form action="/send_gift_post.php" enctype="multipart/form-data" method="post" onsubmit="return hasCheckAny();">
            <table style="width:400px">
                <tr><th scope="col" colspan="2" align="center" >赠送礼物</th></tr>
				<?php
					require_once("settings.php");
					
					$stu_html = ''; $stu_count = 0; $stu_total = 0;
					$pad_html = ''; $pad_count = 0; $pad_total = 0;
					
					$tr_class = array('even', 'odd'); $tr_seq = 0;
		
					foreach ($db->query('SELECT * FROM clients ORDER BY username')->fetchAll() as $row) {
						$did = $row['device_id']; $username = $row['username']; $dead = time() > $row['ttl'];

                        if(strncmp($did, 'PAD', 3) != 0){$_html = &$stu_html; $_count = &$stu_count; $_total = &$stu_total; $_cls="stu"; }else {$_html = &$pad_html; $_count = &$pad_count; $_total = &$pad_total; $_cls="pad";}

						$_html .= "<tr class='".$tr_class[$tr_seq=1-$tr_seq]."'>";
						$_html .= "<td><input type='checkbox' name='id[]' value='$did' onclick='CheckCus(this);' class='$_cls'/>$username</td>";
						$_html .= "<td>".($dead?"离线":"在线")."</td>";
						$_html .= "</tr>";
						
						if(!$dead)$_count++;
						$_total++;
					}
				?>				
				<tr class="even"><td><input type="checkbox" id="checkall_pad" onclick="CheckAllCus();"/>全选</td><td>数字课桌状态(<?=$pad_count?>/<?=$pad_total?>)</td></tr>
				<?=$pad_html?>
				<tr class="<?=$tr_class[1-$tr_seq]?>">
					<td colspan="2" style="text-align:center" >
					<input type="submit" class="btn" value='赠送' />
					</td>
				</tr>
			</table>
		</form>
    </center>
	</body>
</html>
