<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=gbk" /> 
        <link href="/style/Main1.css" type="text/css" rel="Stylesheet" />
        <title>�ļ�����</title>
        <script>
			function $(v){return document.getElementById(v);}
			
			function CheckAllCus() {
				var checks = document.getElementsByName("id[]");
				for (var i = 0; i < checks.length; i++)checks[i].checked = $('checkall').checked;
			}
			
			function CheckCus() {
				var is_all = true;
				var checks = document.getElementsByName("id[]");
				for(var i = 0; i < checks.length; i++)if(!checks[i].checked)is_all = false;
				$('checkall').checked = is_all;
			}
						
			function hasCheckAny() {
				var is_any = false;
				var checks = document.getElementsByName("id[]");
				for(var i = 0; i < checks.length; i++)if(checks[i].checked)is_any = true;
				if(!is_any)alert("��ѡ��Ҫ���͵�ѧ��!");
				return is_any;
			}
        </script>
    </head>
	
    <body>
	<center>
		<form action="/send_video_post.php" enctype="multipart/form-data" method="post" onsubmit="return hasCheckAny();">
			<input type="hidden" value="<?=stripslashes($_GET['path'])?>" name="path" />
            <table style="width:400px">
                <tr><th scope="col" colspan="2" align="center" >��Ƶ�ļ�����</th></tr>
				<?php
					require_once("settings.php");
					
					$stu_html = ''; $stu_count = 0; $stu_total = 0;
					
					$tr_class = array('even', 'odd'); $tr_seq = 0;
		
					foreach ($db->query("SELECT * FROM clients WHERE device_id LIKE 'PAD%' ORDER BY username")->fetchAll() as $row) {
						$did = $row['device_id']; $username = iconv('utf-8', 'gbk', $row['username']); $dead = time() > $row['ttl'];
			
						$stu_html .= "<tr class='".$tr_class[$tr_seq=1-$tr_seq]."'>";
						$stu_html .= "<td><input type='checkbox' name='id[]' value='$did' onclick='CheckCus();'/>$username</td>";
						$stu_html .= "<td>".($dead?"����":"����")."</td>";
						$stu_html .= "</tr>";
						
						if(!$dead)$stu_count++;
						$stu_total++;
					}
				?>				
				<tr class="even"><td><input type="checkbox" id="checkall" onclick="CheckAllCus();"/>ȫѡ</td><td>���ֿ���״̬(<?=$stu_count?>/<?=$stu_total?>)</td></tr>
				<?=$stu_html?>
				<tr class="<?=$tr_class[1-$tr_seq]?>">
					<td colspan="2" style="text-align:center" >
					<input type="submit" class="btn" value='����' />
					</td>
				</tr>
			</table>
		</form>
    </center>
	</body>
</html>
