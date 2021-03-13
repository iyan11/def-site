<?php
$_OPT['title'] =  "Логи принятых сообщений вконтакте - Админ панель - ".$_OPT['sub-title'];
?>
<div class="row panel panel-default panel-body">
<div class="col-sm-3">
	<?php require_once "template/".$_OPT['style']."/inc/admin_menu.php";?>
</div>
<div class="col-sm-9">
	<script>
		top_menu('admin');
		admin_menu('a_u_logs_enter');
	</script>
	<?php
	if(isset($data['log_zero'])){
	?>
	<div class="page-header">
		<h1>Логов нет!</h1>
	</div>
	<?php
	}else {
	?>
	<table class="table table-striped table-hover">
		<thead>
			<td>
				Пользователь
			</td>
			<td>
				IP
			</td>
			<td>
				Дата
			</td>
		</thead>
		<?php
		if(isset($data['u_logs'])){
			foreach($data['u_logs'] as $logs){
				if(isset($logs['id'])){
					echo "<tr>";
						echo "<td>";
							$user_id = $logs['id_acc'];
							$db->Query("SELECT `login` FROM `accounts` WHERE `id` = {$user_id}");
							$user_all = $db->FetchArray();
							echo $user_all['login'];
						echo "</td>";
						echo "<td>";
							echo $logs['ip'];
						echo "</td>";
						echo "<td>";
							echo date("j.m.Y г. в h:i:s", $logs['time']);
						echo "</td>";
					echo "</tr>";
				}
			}
		}
		?>
	</table>
	<?php
	}
	?>
</div>
</div>