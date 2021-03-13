<?php
$_OPT['title'] =  "Логи - Админ панель - ".$_OPT['sub-title'];
?>
<div class="row panel panel-default panel-body">
<div class="col-sm-3">
	<?php require_once "template/".$_OPT['style']."/inc/admin_menu.php";?>
</div>
<div class="col-sm-9">
	<script>
		top_menu('admin');
		admin_menu('a_logs');
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
				Администратор
			</td>
			<td>
				Действие
			</td>
			<td>
				Дата
			</td>
		</thead>
		<?php
		if(isset($data['a_logs'])){
			foreach($data['a_logs'] as $logs){
				if(isset($logs['id'])){
					echo "<tr>";
						echo "<td>";
							$admin_id = $logs['user_id'];
							$db->Query("SELECT `login` FROM `accounts` WHERE `id` = {$admin_id}");
							$admin_all = $db->FetchArray();
							echo $admin_all['login'];
						echo "</td>";
						echo "<td>";
							echo $logs['text'];
						echo "</td>";
						echo "<td>";
							echo date("j.m.Y", $logs['date'])." г.";
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